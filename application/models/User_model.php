<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户模型
 */
class User_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_user';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'user_id' => 0,
        'user_name' => '',
        'user_password' => '',
        'user_ex_password' => '',
        'user_phone' => '',
        'user_phone_area' => '',
        'user_email' => '',
        'user_language' => '',
        'user_access_token' => '',
        'user_register_time' => 0,
        'user_last_login' => 0,
        'user_last_ip' => '',
        'user_register_step' => 1,
        'user_auth' => 0,
        'user_auth_time' => 0,
        'user_auth_name' => '',
        'user_auth_number' => '',
        'user_auth_image' => '',
        'user_agent' => 0,
        'user_invite_code' => '',
        'user_invite_count' => 0,
        'user_parent' => 0,
        'user_memo' => 0,
        'user_contact' => '',
        'user_merchant' => 0,
        'user_merchant_time' => 0,
        'user_merchant_name' => '',
        'user_merchant_pay' => '',
        'user_merchant_status' => 0,
        'user_otc_pay' => '',
        'user_lock_free' => 0,
        'user_status' => 1
    );


    /**
     * 从指定来源获取插入用户实例
     * @param  array  $source 包含用户信息字段的来源数组
     * @return array          array(
     *                            用户字段...
     *                        )
     */
    public function initInsert($source){

        $user = parent::initInsert($source);

        $user['user_name'] = $user['user_phone'] == '' ? $user['user_email'] : $user['user_phone'];
        $user['user_access_token']  = base64_encode(pwd_encode(APP_TIME . rand(100, 999) . rand(100, 999) . rand(100, 999)));
        $user['user_password']      = pwd_encode($user['user_password']);
        $user['user_ex_password']   = pwd_encode($user['user_ex_password']);
        $user['user_invite_code']   = strtoupper(sprintf('%x',crc32(microtime())));
        $user['user_register_time'] = APP_TIME;

        return $user;
    }


    //添加用户
    public function insert($user){

        $result = FALSE;

        $this->db->trans_start();

        $result = parent::insert($user);

        if ($result) {

            $insert_id = $this->db->insert_id();

            $user['user_id'] = $insert_id;
            
            //新增用户时，更新用户memo
            $user['user_memo'] = $this->config->item('udun_memo_start') . $insert_id;

            if ($this->update($user)) {
                
                $result = $user;
            };
        }

        $this->db->trans_complete();

        return $result;
    }


    /**
     * 从指定来源获取更新用户实例
     * @param  array  $source 包含用户信息字段的来源数组
     * @return array          返回用户信息字段
     */
    public function initUpdate($source){

        $user = parent::initUpdate($source);

        if (isset($user['user_password'])) {
            
            if ($user['user_password'] == '') {
                
                unset($user['user_password']);
            }else{

                $user['user_password'] = pwd_encode($user['user_password']);
            }
        }

        return $user;
    }


    public function update($user, $where = FALSE){

        $result = parent::update($user, $where);

        if (isset($_SESSION['USER']) && $result) {

            $user = $this->one($user['user_id']);
            $this->createLoginSession($user);
        }

        return $result;
    }


    public function countMerchant(){

        $where = '`user_merchant`=1';

        return $this->count($where);
    }


    public function getAllMerchant($pageIndex, $pageSize){

        $where = '`user_merchant`=1';

        $order = '`user_merchant_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function countTodayRegister(){

        $where = '`user_register_time` >=' . strtotime(date('Y-m-d', time()) . ' 00:00:00');

        return $this->count($where);
    }


    public function oneActiveUserByMemo($userMemo){

        $where = '`user_status`=1 AND `user_memo`=' . $this->db->escape($userMemo);

        return $this->one(FALSE, $where);
    }


    public function oneActiveUser($userId){

        $where = '`user_status`=1 AND `user_id`=' . $userId;

        return $this->one(FALSE, $where);
    }


    /**
     * 获取用户列表
     * @param  int     $pageIndex 页码
     * @param  int     $pageSize  每页数量
     * @return array              返回若干个用户组成的数组
     */
    public function getUserList($pageIndex, $pageSize, $search = ''){

        $where = "`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%'";

        $order = '`user_register_time` DESC';

        $join = array(

            array(

                //与用户表联表
                'table'         => 'ex_user',
                'on_left'       => 'user_parent',
                'on_right'      => 'user_id',
                'fields'        => array(

                    //查询交易币种标识
                    'user_name' => 'user_parent_name'
                )
            )
        );

        return $this->get($pageIndex, $pageSize, $where, $order, $join);
    }


    public function countUser($search = ''){

        $where = "`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%'";

        return $this->count($where);
    }


    public function searchUserIdList($search = ''){

        $result = array(0);

        $where = "`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%'";

        $userList = $this->get(FALSE, FALSE, $where);

        if ($userList && count($userList)) {
            
            $result = array_column($userList, 'user_id');
        }

        return $result;
    }


    public function countAgent($search = ''){

        $where = "`user_agent`=1 AND (`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%')";

        return $this->count($where);
    }

    public function getAgentList($pageIndex, $pageSize, $search = ''){

        $where = "`user_agent`=1 AND (`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%')";

        $order = '`user_register_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function getUserByUserName($userName){

        $where = '`user_name`=' . $this->db->escape($userName);

        return $this->one(FALSE, $where);
    }


    /**
     * 通过用户手机邮箱用户名查找用户
     * @param  string $userName 用户
     * @param  bool             是否排除自己，可选，默认不排除
     * @return array            返回用户对象数组
     */
    public function oneUserByEmailPhoneName($user, $noSelf = FALSE){

        $where = '(`user_name`=' . $this->db->escape($user['user_name']);

        if ($user['user_phone'] != '') {
            
            $where .= ' OR `user_phone`=' .$this->db->escape($user['user_phone']);
        }

        if ($user['user_email'] != '') {
            
            $where .= ' OR `user_email`=' .$this->db->escape($user['user_email']);
        }

        $where .= ')';

        if ($noSelf) {
            
            $where .= ' AND (`user_id`<>' . $this->db->escape($user['user_id']) . ')';
        }

        return $this->one(FALSE, $where);
    }


    /**
     * 通过用户手机查找用户
     * @param  string $userName 用户对象
     * @param  bool             是否排除自己，可选，默认不排除
     * @return array            返回用户对象数组
     */
    public function oneUserByPhone($user, $noSelf = FALSE){

        $where = '`user_phone`=' . $this->db->escape($user['user_phone']) . ' AND `user_phone_area`=' . $this->db->escape($user['user_phone_area']);

        if ($noSelf) {
            
            $where .= ' AND (`user_id`<>' . $this->db->escape($user['user_id']) . ')';
        }

        return $this->one(FALSE, $where);
    }


    /**
     * 通过用户邮箱查找用户
     * @param  string $userName 用户对象
     * @param  bool             是否排除自己，可选，默认不排除
     * @return array            返回用户对象数组
     */
    public function oneUserByEmail($user, $noSelf = FALSE){

        $where = '`user_email`=' . $this->db->escape($user['user_email']);

        if ($noSelf) {
            
            $where .= ' AND (`user_id`<>' . $this->db->escape($user['user_id']) . ')';
        }

        return $this->one(FALSE, $where);
    }


    public function oneUserByToken($token){

        $where = '`user_access_token`=' . $this->db->escape($token) . ' AND `user_status`=1';

        return $this->one(FALSE, $where);
    }


    public function countAuth($search = ''){

        $where = '`user_auth`<>0 AND `user_auth_time`>0 AND (' . "`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%'" . ')';

        return $this->count($where);
    }


    public function getAuth($pageIndex, $pageSize, $search = ''){

        $where = '`user_auth`<>0 AND `user_auth_time`>0 AND (' . "`user_name` LIKE '%" . $search . "%' OR `user_phone` LIKE '%" . $search . "%' OR `user_email` LIKE '%" . $search . "%'" . ')';

        $order = '`user_auth_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function checkAuth($user){

        $result = FALSE;

        if (isset($user['user_auth']) && $user['user_auth'] == 3) {
            
            $result = TRUE;
        }

        return $result;
    }


    public function oneUserByInviteCode($inviteCode){

        $where = "`user_invite_code`='" . $inviteCode . "'";

        return $this->one(FALSE, $where);
    }


    public function getUserInviteList($user_id, $pageIndex, $pageSize){

        $where = '`user_parent`=' . $user_id;

        $order = '`user_register_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    /**
     *
     * 用户登陆SESSION格式：
     *
     * $_SESSION['USER'] = array(
     * 
     *     'USER_ID'           => 用户ID,
     *     'USER_NAME'         => 用户用户名,
     *     'USER_LOGIN_TIME'   => 用户最后一次操作时间戳(用来判断登陆超时)
     * )
     * 
     */


    /**
     * 用户登陆
     * @param  string $userName     用户用户名
     * @param  string $userPassword 用户登陆密码(已加密)
     * @return bool                  返回登陆结果，登陆成功返回true，登陆失败返回false
     */
    public function login($userName, $userPassword){

        $result = FALSE;

        $where = '`user_status`=1 AND (`user_phone`=' . $this->db->escape($userName) . ' OR `user_email`=' . $this->db->escape($userName) . ') AND `user_password`=' . $this->db->escape($userPassword);

        return $this->one(FALSE, $where);
    }


    public function flushLastLogin($user_id){

        $user = array(

            'user_id' => $user_id,
            'user_last_login' => APP_TIME
        );

        if (isset($_SERVER['REMOTE_ADDR'])) {
            
            $user['user_last_ip'] = $_SERVER['REMOTE_ADDR'];
        }

        return $this->update($user);
    }


    /**
     * 检测用户登陆或是否超时
     */
    public function checkLogin($noAction = FALSE, $agent = FALSE) {

        if (isset($_SESSION['USER']) && isset($_SESSION['USER']['USER_LOGIN_TIME']) && (($agent == FALSE) || ($agent == TRUE && $_SESSION['USER']['USER_AGENT'] == 1))) {
            
            if (APP_TIME - $_SESSION['USER']['USER_LOGIN_TIME'] > $this->config->item('user_logout_time')) {
                
                if ($noAction) {
                    
                    return FALSE;
                }else{

                    $this->logout();
                }
            }else{

                $_SESSION['USER']['USER_LOGIN_TIME'] = APP_TIME;
            }
        }else{

            if ($noAction) {
                
                return FALSE;
            }else{

                $this->logout();
            }
        }

        return TRUE;
    }


    /**
     * 创建登陆SESSION
     * @param  Array $user 用户信息
     * @return Array        SESSION数组
     */
    public function createLoginSession($user){

        $result = array();

        foreach ($user as $key => $value) {
            
            $result[strtoupper($key)] = $value;
        }

        $result['USER_LOGIN_TIME'] = APP_TIME;

        $_SESSION['USER'] = $result;
    }


    /**
     * 用户登出
     */
    public function logout(){

        unset($_SESSION['USER']);

        if (isAjax()) {

            //异步响应
            echo json_encode(array('status' => FALSE, 'message' => '登陆超时，请重新登陆'), JSON_UNESCAPED_UNICODE);
        }else{

            header('Location:' . base_url('/account/login.html'));
        }

        exit();
    }


    /**
     * 检测图形验证码是否正确
     * @param  string $validate 需要校验的字符串
     * @return bool             返回校验结果
     */
    public function checkImageValidate($validate = ''){

        $result = FALSE;

        if ((isset($_SESSION['USER_VALIDATE']) && strtolower($_SESSION['USER_VALIDATE']) === strtolower($validate)) || ($_SESSION['SYSCONFIG']['sysconfig_global_validate_switch'] == '1' && $_SESSION['SYSCONFIG']['sysconfig_global_validate'] === strtolower($validate))) {
            
            $result = TRUE;
        }

        return $result;
    }


    /**
     * 检测短信验证码是否正确
     * @param  string $validate 需要校验的字符串
     * @return bool             返回校验结果
     */
    public function checkSmsValidate($validate = ''){

        $result = FALSE;

        if ((isset($_SESSION['USER_SMS_VALIDATE']) && strtolower($_SESSION['USER_SMS_VALIDATE']) === strtolower($validate)) || ($_SESSION['SYSCONFIG']['sysconfig_global_validate_switch'] == '1' && $_SESSION['SYSCONFIG']['sysconfig_global_validate'] === strtolower($validate))) {
            
            $result = TRUE;
        }

        return $result;
    }


    /**
     * 检测邮箱验证码是否正确
     * @param  string $validate 需要校验的字符串
     * @return bool             返回校验结果
     */
    public function checkEmailValidate($validate = ''){

        $result = FALSE;

        if ((isset($_SESSION['USER_EMAIL_VALIDATE']) && strtolower($_SESSION['USER_EMAIL_VALIDATE']) === strtolower($validate))) {
            
            $result = TRUE;
        }

        return $result;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员模型
 */
class Admin_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_admin';


    /**
     * 数据表字段缺省值数组
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'admin_id'          => 0,           /*管理员ID*/
        'admin_name'        => 0,           /*管理员用户名*/
        'admin_password'    => 0,           /*管理员密码*/
        'admin_nickname'    => 0,           /*管理员昵称*/
        'admin_auth'        => 0,           /*管理员权限*/
        'admin_super'       => 0,           /*是否是超级管理员，1为是，0为否*/
        'admin_last_login'  => 0,           /*管理员上一次登陆时间*/
        'admin_status'      => 0            /*管理员状态，1为正常，0为封禁*/
    );


    /**
     * 从指定来源获取管理员实例
     * @param  array  $source 包含管理员信息字段的来源数组
     * @param  int    $adminId 管理员ID
     * @return array          array(
     *                            管理员字段...
     *                        )
     */
    public function initAdmin($source, $adminId = FALSE){

        $admin = parent::initUpdate($source);

        $admin['admin_password'] = pwd_encode($admin['admin_password']);

        return $admin;
    }


    /**
     * 验证管理员密码
     * @param  string $adminPassword 管理员明文密码
     * @return bool                  返回验证结果，验证成功返回TRUE，验证失败返回FALSE
     */
    public function verifyPassword($adminPassword){

        return $this->login($_SESSION['MANAGE']['ADMIN_NAME'], pwd_encode($adminPassword));
    }


    /**
     *
     * 管理员登陆SESSION格式：
     *
     * $_SESSION['MANAGE'] = array(
     * 
     *     'ADMIN_ID'           => 管理员ID,
     *     'ADMIN_NAME'         => 管理员用户名,
     *     'ADMIN_NICKNAME'     => 管理员昵称,
     *     'ADMIN_AUTH'         => 管理员权限,
     *     'ADMIN_LOGIN_TIME'   => 管理员最后一次操作时间戳(用来判断登陆超时)
     * )
     * 
     */


    /**
     * 管理员登陆
     * @param  string $adminName     管理员用户名
     * @param  string $adminPassword 管理员登陆密码(已加密)
     * @return bool                  返回登陆结果，登陆成功返回true，登陆失败返回false
     */
    public function login($adminName, $adminPassword){

        $result = FALSE;

        $where = '`admin_name`=' . $this->db->escape($adminName) . ' AND `admin_password`=' . $this->db->escape($adminPassword);

        $admin = $this->one(FALSE, $where);

        if ($admin) {
            
            //比对成功，写入session
            $this->createLoginSession($admin);
            $result = TRUE;
        }

        return $result;
    }


    /**
     * 检测管理员登陆或是否超时
     */
    public function checkLogin() {

        if (isset($_SESSION['MANAGE']) && isset($_SESSION['MANAGE']['ADMIN_LOGIN_TIME'])) {
            
            if (APP_TIME - $_SESSION['MANAGE']['ADMIN_LOGIN_TIME'] > $this->config->item('manage_logout_time')) {
                
                $this->logout();
            }else{

                $_SESSION['MANAGE']['ADMIN_LOGIN_TIME'] = APP_TIME;
            }
        }else{

            $this->logout();
        }
    }


    /**
     * 创建登陆SESSION
     * @param  Array $admin 管理员信息
     * @return Array        SESSION数组
     */
    private function createLoginSession($admin){

        $result['ADMIN_ID'] = $admin['admin_id'];
        $result['ADMIN_NAME'] = $admin['admin_name'];
        $result['ADMIN_NICKNAME'] = $admin['admin_nickname'];
        $result['ADMIN_AUTH'] = $admin['admin_auth'];
        $result['ADMIN_LOGIN_TIME'] = APP_TIME;

        $_SESSION['MANAGE'] = $result;
    }


    /**
     * 管理员登出
     */
    public function logout(){

        unset($_SESSION['MANAGE']);

        if (isAjax()) {

            //异步响应
            echo json_encode(array('status' => FALSE, 'message' => '登陆超时，请重新登陆'), JSON_UNESCAPED_UNICODE);
        }else{

            header('Location:' . base_url('manage/main/login'));
        }

        exit();
    }
}

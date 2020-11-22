<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 前台用户页面控制器
 */
class Account extends MY_Controller {


    //资产帐户映射
    public $assetMap = array(

        'exchange' => 1,
        'futures' => 4
    );


	/**
	 * 构造函数，初始化
	 */
	public function __construct(){

		parent::__construct();

		//载入模型
		$this->load->model('user_model');
        $this->load->model('coin_model');
        $this->load->model('asset_model');
        $this->load->model('recharge_model');
        $this->load->model('withdraw_model');
        $this->load->model('wallet_model');
        $this->load->model('asset_log_model');
        $this->load->model('article_model');

		//用户中心,除了注册和登陆,其它都需要验证登陆状态
		if ($this->uri->segment(2) != 'login' && $this->uri->segment(2) != 'register' && $this->uri->segment(2) != 'forgot' && $this->uri->segment(2) != 'core_auth') {
			
			$this->user_model->checkLogin();
		}
	}


    public function index(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($user) {
            
            $data = array(

                'user' => $user
            );

            $this->load->view($this->viewPath . '/account/account', $data);
        }else{

            echo '<script>alert("' . lang('controller_account_index_1') . '");window.location.href="/";</script>';
        }
    }


    //绑定手机
    public function phone(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($_POST) {

            if (isset($_POST['user_phone']) && $_POST['user_phone'] != '' && isset($_POST['user_phone_area']) && $_POST['user_phone_area'] != '' && isset($_POST['validate']) && $_POST['validate'] != '' && isset($_POST['user_ex_password']) && $_POST['user_ex_password'] != '') {
                
                $result = array(

                    'status' => FALSE,
                    'message' => lang('controller_account_phone_1')
                );

                if ($this->user_model->checkSmsValidate($_POST['validate'])) {
                    
                    if ($user['user_ex_password'] == pwd_encode($_POST['user_ex_password'])) {
                        
                        $user['user_phone'] = $_POST['user_phone'];
                        $user['user_phone_area'] = $_POST['user_phone_area'];

                        $existPhone = $this->user_model->oneUserByPhone($user);

                        if ($existPhone && count($existPhone)) {
                            
                            $result['message'] = lang('controller_account_phone_2');
                        }else{

                            if ($this->user_model->update($user)) {
                                
                                $result['status'] = TRUE;
                                $result['message'] = lang('controller_account_phone_3');
                            }
                        }
                    }else{

                        $result['message'] = lang('controller_account_phone_4');
                    }
                }else{

                    $result['message'] = lang('controller_account_phone_5');
                }

                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }else{

            $defaultAreaCode = $this->config->item('phone_area_code_default');

            if ($user['user_phone'] != '') {
                
                $defaultAreaCode = $user['user_phone_area'];
            }

            $data = array(

                'user' => $user,
                'defaultAreaCode' => $defaultAreaCode
            );

            $this->load->view($this->viewPath . '/account/phone', $data);
        }
    }


    //绑定邮箱
    public function email(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($_POST) {

            if (isset($_POST['user_email']) && $_POST['user_email'] != '' && isset($_POST['validate']) && $_POST['validate'] != '' && isset($_POST['user_ex_password']) && $_POST['user_ex_password'] != '') {
                
                $result = array(

                    'status' => FALSE,
                    'message' => lang('controller_account_email_1')
                );

                if (checkEmailFomat($_POST['user_email'])) {

                    if ($this->user_model->checkEmailValidate($_POST['validate'])) {
                        
                        if ($user['user_ex_password'] == pwd_encode($_POST['user_ex_password'])) {
                            
                            $user['user_email'] = $_POST['user_email'];

                            $existEmail = $this->user_model->oneUserByEmail($user);

                            if ($existEmail && count($existEmail)) {
                                
                                $result['message'] = lang('controller_account_email_2');
                            }else{

                                if ($this->user_model->update($user)) {
                                    
                                    $result['status'] = TRUE;
                                    $result['message'] = lang('controller_account_email_3');
                                }
                            }
                        }else{

                            $result['message'] = lang('controller_account_email_4');
                        }
                    }else{

                        $result['message'] = lang('controller_account_email_5');
                    }
                }else{

                    $result['message'] = lang('controller_account_email_6');
                }

                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }else{

            $data = array(

                'user' => $user
            );

            $this->load->view($this->viewPath . '/account/email', $data);
        }
    }


    //资产
    public function asset(){

        $userAssetUsdTotal = '0.00';

        $userAsset = $this->asset_model->getUserAsset($_SESSION['USER']['USER_ID']);

        //计算并统计资产折合
        foreach ($userAsset as $key => $assetItem) {
            
            $userAsset[$key]['asset_usd'] = bcmul($assetItem['asset_total'], $assetItem['coin_usd'], 2);
            $userAssetUsdTotal = bcadd($userAssetUsdTotal, $userAsset[$key]['asset_usd'], 2);
        }

        $data = array(

            'current_page' => 'asset',
            'userAsset' => $userAsset,
            'userAssetUsdTotal' => $userAssetUsdTotal
        );

        $this->load->view($this->viewPath . '/account/asset', $data);
    }


    public function record($coin_symbol = '', $pageIndex = 1){

        $coin = FALSE;

        if ($coin_symbol && $coin_symbol != '') {
            
            $coin_symbol = strtoupper($coin_symbol);

            $coin = $this->coin_model->oneActiveCoinBySymbol($coin_symbol);
        }

        if ($coin) {

            $pageSize = 20;

            $recordCount = $this->asset_log_model->countUserAssetLog($_SESSION['USER']['USER_ID'], $coin['coin_id'], 1);

            $pagingInfo = getPagingInfo($recordCount, $pageIndex, $pageSize, $this->config->item('home_page'), base_url('/account/record/' . $coin_symbol . '/'));
            
            $recordList = $this->asset_log_model->getUserAssetLog($pagingInfo['pageindex'], $pageSize, $_SESSION['USER']['USER_ID'], $coin['coin_id'], 1);

            $data = array(

                'coin' => $coin,
                'recordList' => $recordList,
                'pagingInfo' => $pagingInfo,
                'recordCount' => $recordCount,
                'pageSize' => $pageSize,
                'assetSymbol' => 'exchange',
                'assetSymbolText' => lang('controller_account_record_1'),
                'backUrl' => '/account/asset'
            );

            $this->load->view($this->viewPath . '/account/asset_record', $data);
        }else{

            $this->asset();
        }
    }


    public function auth(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($_POST) {
            if (isset($_POST['auth_name']) && isset($_POST['auth_number']) && isset($_POST['image_1']) && isset($_POST['image_2'])) {
                
                $result = array(

                    'status' => FALSE,
                    'message' => lang('controller_account_auth_1')
                );

                $user['user_id'] = $_SESSION['USER']['USER_ID'];
                $user['user_auth'] = 1;
                $user['user_auth_time'] = APP_TIME;
                $user['user_auth_name'] = $_POST['auth_name'];
                $user['user_auth_number'] = $_POST['auth_number'];
                $user['user_auth_image'] = json_encode(array($_POST['image_1'], $_POST['image_2']));

                if ($this->user_model->update($user)) {
                    
                    $result['status'] = TRUE;
                    $result['message'] = lang('controller_account_auth_2');
                }

                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }else{

            $authImage = array('', '', '');

            if ($user['user_auth'] > 0) {
                
                $authImage = json_decode($user['user_auth_image'], TRUE);
            }

            $data = array(

                'current_page' => 'auth',
                'user' => $user,
                'authImage' => $authImage
            );

            $this->load->view($this->viewPath . '/account/auth', $data);
        }
    }


    public function repass(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($_POST) {

            if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['re_new_password']) && isset($_POST['validate'])) {
                
                $result = array(

                    'status' => FALSE,
                    'message' => lang('controller_account_repass_1')
                );

                if ($_POST['new_password'] == $_POST['re_new_password']) {

                    if ($this->user_model->checkSmsValidate($_POST['validate']) || $this->user_model->checkEmailValidate($_POST['validate'])) {

                        if ($user && $user['user_password'] == pwd_encode($_POST['old_password'])) {
                            
                            $user['user_password'] = pwd_encode($_POST['new_password']);

                            if ($this->user_model->update($user)) {
                                
                                $result['status'] = TRUE;
                                $result['message'] = lang('controller_account_repass_2');
                            }
                        }else{

                            $result['message'] = lang('controller_account_repass_3');
                        }
                    }else{

                        $result['message'] = lang('controller_account_repass_4');
                    }
                }else{

                    $result['message'] = lang('controller_account_repass_5');
                }

                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }else{

            $data = array(

                'user' => $user,
                'current_page' => 'repass'
            );

            $this->load->view($this->viewPath . '/account/repass', $data);
        }
    }


    public function reexpass(){

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($_POST) {

            if (isset($_POST['user_password']) && isset($_POST['new_expassword']) && isset($_POST['re_new_expassword']) && isset($_POST['validate'])) {
                
                $result = array(

                    'status' => FALSE,
                    'message' => lang('controller_account_reexpass_1')
                );

                if ($_POST['new_expassword'] == $_POST['re_new_expassword']) {

                    if ($this->user_model->checkSmsValidate($_POST['validate']) || $this->user_model->checkEmailValidate($_POST['validate'])) {

                        if ($user && $user['user_password'] == pwd_encode($_POST['user_password'])) {
                            
                            $user['user_ex_password'] = pwd_encode($_POST['new_expassword']);

                            if ($this->user_model->update($user)) {
                                
                                $result['status'] = TRUE;
                                $result['message'] = lang('controller_account_reexpass_2');
                            }
                        }else{

                            $result['message'] = lang('controller_account_reexpass_3');
                        }
                    }else{

                        $result['message'] = lang('controller_account_reexpass_4');
                    }
                }else{

                    $result['message'] = lang('controller_account_reexpass_5');
                }

                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }else{

            $data = array(

                'user' => $user,
                'current_page' => 'reexpass'
            );

            $this->load->view($this->viewPath . '/account/reexpass', $data);
        }
    }


    public function invite($pageIndex = 1){

        $pageSize = 20;

        $user = $this->user_model->one($_SESSION['USER']['USER_ID']);

        if ($user && count($user)) {

            $pagingInfo = getPagingInfo($user['user_invite_count'], $pageIndex, $pageSize, $this->config->item('home_page'), base_url('/account/invite/'));

            $inviteList = $this->user_model->getUserInviteList($user['user_id'], $pagingInfo['pageindex'], $pageSize);
            
            $data = array(

                'current_page' => 'invite',
                'user' => $user,
                'inviteList' => $inviteList,
                'pagingInfo' => $pagingInfo,
                'pageSize' => $pageSize
            );

            $this->load->view($this->viewPath . '/account/invite', $data);
        }
    }


    //登陆
    public function login(){

        if ($_POST && isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['validate'])) {
            
            $result = array(

                'status' => FALSE,
                'message' => lang('controller_account_login_1')
            );

            if ($_POST['user_name'] == '' || $_POST['user_password'] == '') {
                
                $result['message'] = lang('controller_account_login_2');
            }else{

                if ($this->user_model->checkImageValidate($_POST['validate'])) {
                    
                    $user = $this->user_model->login($_POST['user_name'], pwd_encode($_POST['user_password']));

                    if ($user && count($user)) {
                        
                        $this->user_model->createLoginSession($user);

                        $this->user_model->flushLastLogin($user['user_id']);

                        $result['status'] = TRUE;
                        $result['message'] = lang('controller_account_login_3');
                    }else{

                        $result['message'] = lang('controller_account_login_4');
                    }
                }else{

                    $result['message'] = lang('controller_account_login_5');
                }
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }else{

            $this->load->view($this->viewPath . '/account/login');
        }
    }


    //退出登陆
    public function logout(){

        $this->user_model->logout();
    }


    public function forgot(){

        if ($_POST && isset($_POST['user_phone']) && isset($_POST['user_phone_area']) && isset($_POST['user_email']) && isset($_POST['validate']) && isset($_POST['user_password']) && isset($_POST['repassword'])) {

            $result = array(

                'status' => FALSE,
                'message' => lang('controller_account_forgot_1')
            );

            if ($_POST['user_password'] == $_POST['repassword']) {

                if ($this->user_model->checkSmsValidate($_POST['validate']) || $this->user_model->checkEmailValidate($_POST['validate'])) {

                    $userInfo = array(

                        'user_phone' => $_POST['user_phone'],
                        'user_phone_area' => $_POST['user_phone_area'],
                        'user_email' => $_POST['user_email']
                    );

                    $user = FALSE;

                    if ($userInfo['user_phone'] != '') {
                        
                        $user = $this->user_model->oneUserByPhone($userInfo);
                    }

                    if ((! $user) && $userInfo['user_email'] != '') {
                        
                        $user = $this->user_model->oneUserByEmail($userInfo);
                    }

                    if ($user) {
                        
                        $user['user_password'] = pwd_encode($_POST['user_password']);

                        if ($this->user_model->update($user)) {
                            
                            if (isset($_SESSION['USER'])) {
                                
                                unset($_SESSION['USER']);
                            }

                            $result['status'] = TRUE;
                            $result['message'] = lang('controller_account_forgot_2');
                        }
                    }else{

                        $result['message'] = lang('controller_account_forgot_3');
                    }
                }else{

                    $result['message'] = lang('controller_account_forgot_4');
                }
            }else{

                $result['message'] = lang('controller_account_forgot_5');
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }else{

            $defaultAreaCode = $this->config->item('phone_area_code_default');

            $data = array(

                'defaultAreaCode' => $defaultAreaCode
            );

            $this->load->view($this->viewPath . '/account/forgot', $data);
        }
    }


    //用户注册
    public function register($step = 1){

    	if ($_POST) {
    		
    		$result = array(

    		    'status' => FALSE,
    		    'message' => lang('controller_account_register_1')
    		);

    		if ($_POST['user_password'] == $_POST['repassword']) {

                if ($_POST['user_ex_password'] == $_POST['reexpassword']) {

                    if ($_POST['user_password'] == $_POST['user_ex_password']) {

                        $result['message'] = lang('controller_account_register_2');
                    }else{

                        if ($this->user_model->checkSmsValidate($_POST['validate']) || $this->user_model->checkEmailValidate($_POST['validate'])) {

                            $parentUser = $this->user_model->oneUserByInviteCode(strtoupper($_POST['invite_code']));
                            
                            $user = $this->user_model->initInsert($_POST);

                            if ($parentUser) {

                                $parentUser['user_invite_count'] ++;
                                $this->user_model->update($parentUser);

                                $user['user_parent'] = $parentUser['user_id'];

                                $existUser = $this->user_model->oneUserByEmailPhoneName($user);

                                if ($existUser && count($existUser)) {
                                    
                                    $result['message'] = lang('controller_account_register_3');
                                }else{

                                    $user = $this->user_model->insert($user);

                                    if ($user && isset($user['user_id']) && $user['user_id'] > 0) {

                                        $user = $this->user_model->one($user['user_id']);

                                        $result['status'] = TRUE;
                                        $result['message'] = lang('controller_account_register_4');

                                        $this->user_model->registerNotice();
                                    }
                                }
                            }else{

                                $result['message'] = lang('controller_account_register_5');
                            }
                        }else{

                            $result['message'] = lang('controller_account_register_6');
                        }
                    }
                }else{

                    $result['message'] = lang('controller_account_register_7');
                }
    		}else{

    			$result['message'] = lang('controller_account_register_8');
    		}

    		echo json_encode($result, JSON_UNESCAPED_UNICODE);
    	}else{

            $inviteCode = FALSE;

            if (isset($_GET['i'])) {
                
                $inviteCode = $_GET['i'];
            }

            $defaultAreaCode = $this->config->item('phone_area_code_default');

    		$data = array(

                'inviteCode' => $inviteCode,
                'defaultAreaCode' => $defaultAreaCode
    		);

    		$this->load->view($this->viewPath . '/account/register', $data);
    	}
    }
}

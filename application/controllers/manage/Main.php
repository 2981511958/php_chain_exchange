<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台公共控制器
 */
class Main extends CI_Controller {


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		$this->load->model('admin_model');
		$this->load->model('sysconfig_model');
		$this->load->model('user_model');
		$this->load->model('recharge_model');
		$this->load->model('withdraw_model');
		$this->load->model('coin_model');

	}


	/**
	 * 后台首页入口
	 */
	public function index(){

		$this->admin_model->checkLogin();

		$_SESSION['SYSCONFIG'] = $this->sysconfig_model->getFormatSysconfig();

		$this->load->view('manage/index');
	}


	public function statistics(){

		$this->admin_model->checkLogin();

		$todayRegisterCount = $this->user_model->countTodayRegister();
		$todayRechargeList = $this->recharge_model->getTodayRecharge();
		$todayWithdrawList = $this->withdraw_model->getTodayWithdraw();
		$coinList = array_column($this->coin_model->getActiveCoinList(), NULL, 'coin_id');

		$todayRechargeUserList = array();
		if ($todayRechargeList && count($todayRechargeList)) {
			
			foreach ($todayRechargeList as $rechargeItem) {
				
				if (isset($todayRechargeUserList[$rechargeItem['recharge_user']])) {
					
					$todayRechargeUserList[$rechargeItem['recharge_user']] ++;
				}else{

					$todayRechargeUserList[$rechargeItem['recharge_user']] = 1;
				}

				if (isset($coinList[$rechargeItem['recharge_coin']]['recharge_sum'])) {
					
					$coinList[$rechargeItem['recharge_coin']]['recharge_sum'] = bcadd($coinList[$rechargeItem['recharge_coin']]['recharge_sum'], $rechargeItem['recharge_amount'], 8);
				}else{

					$coinList[$rechargeItem['recharge_coin']]['recharge_sum'] = $rechargeItem['recharge_amount'];
				}
			}
		}



		$todayWithdrawUserList = array();
		if ($todayWithdrawList && count($todayWithdrawList)) {
			
			foreach ($todayWithdrawList as $withdrawItem) {
				
				if (isset($todayWithdrawUserList[$withdrawItem['withdraw_user']])) {
					
					$todayWithdrawUserList[$withdrawItem['withdraw_user']] ++;
				}else{

					$todayWithdrawUserList[$withdrawItem['withdraw_user']] = 1;
				}

				if (isset($coinList[$withdrawItem['withdraw_coin']]['withdraw_sum'])) {
					
					$coinList[$withdrawItem['withdraw_coin']]['withdraw_sum'] = bcadd($coinList[$withdrawItem['withdraw_coin']]['withdraw_sum'], $withdrawItem['withdraw_amount'], 8);
				}else{

					$coinList[$withdrawItem['withdraw_coin']]['withdraw_sum'] = $withdrawItem['withdraw_amount'];
				}
			}
		}



		$data = array(

			'todayRegisterCount' => $todayRegisterCount,
			'todayRechargeCount' => count($todayRechargeList),
			'todayWithdrawCount' => count($todayWithdrawList),
			'todayRechargeUserCount' => count($todayRechargeUserList),
			'todayWithdrawUserCount' => count($todayWithdrawUserList),
			'coinList' => $coinList
		);

		$this->load->view('manage/statistics', $data);
	}


	/**
	 * 管理员登陆
	 */
	public function login(){

		if ($_POST) {

			//初始化异步结果
			$result = array(

				'status' => FALSE,
				'message' => '',
				'url' => base_url('manage/main')
			);

			//判断验证码
			$validate = $this->input->post('validate');
			if ($validate && strtolower($validate) === strtolower($_SESSION['validate'])) {
				
				//获取提交的管理员信息
				$admin = $this->admin_model->initAdmin($this->input->post());
				if ($admin['admin_name'] == '' || $admin['admin_password'] == '') {
					
					$result['message'] = '请填写正确的用户和密码';
				}else{

					//从数据库中检索管理员
					if ($this->admin_model->login($admin['admin_name'], $admin['admin_password'])) {

						$result['message'] = '登陆成功';
						$result['status'] = TRUE;
					}else{

						$result['message'] = '帐户或密码错误';
					}
				}
			}else{

				$result['message'] = '请填写正确的验证码';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}else{

			$this->load->view('manage/login');
		}
	}


	/**
	 * 管理员登出
	 */
	public function logout(){

		$this->admin_model->logout();
	}
}
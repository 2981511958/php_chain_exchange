<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台用户控制器
 */
class User extends CI_Controller {


	/**
	 * 每页数量
	 */
	private $pageSize = 20;


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();

		//载入模型
		$this->load->model('user_model');
		$this->load->model('asset_model');
		$this->load->model('coin_model');
		$this->load->model('recharge_model');
		$this->load->model('withdraw_model');
	}


	/**
	 * 用户页面
	 */
	public function index($pageIndex = 1){

		$search = isset($_GET['search']) ? trim($_GET['search']) : '';

		$userCount = $this->user_model->countUser($search);

		$pagingInfo = getPagingInfo($userCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/user/index/'));

		$userList = $this->user_model->getUserList($pagingInfo['pageindex'], $this->pageSize, $search);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'userList'	=> $userList,
			'search' => $search
		);

		$this->load->view('manage/user/user_index', $data);
	}


	public function login(){

		if ($_POST) {
			
			$user = $this->user_model->one($_POST['user_id']);

			$this->user_model->createLoginSession($user);
		}
	}


	public function change_agent(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);
			
			$user = $this->user_model->one($_POST['user_id']);

			if ($user) {
				
				$user['user_agent'] = $_POST['user_agent'];

				if ($this->user_model->update($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = '操作成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	public function change_status(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);
			
			$user = $this->user_model->one($_POST['user_id']);

			if ($user) {
				
				$user['user_status'] = $_POST['user_status'];

				if ($this->user_model->update($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = '操作成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	public function change_local_free(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);
			
			$user = $this->user_model->one($_POST['user_id']);

			if ($user) {
				
				$user['user_lock_free'] = $_POST['user_lock_free'];

				if ($this->user_model->update($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = '操作成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 用户的邀请列表
	 */
	public function user_invite($user_id = 0, $pageIndex = 1){

		$user = $this->user_model->one($user_id);

		$userCount = $user['user_invite_count'];

		$pagingInfo = getPagingInfo($userCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/user/user_invite/' . $user_id . '/'));

		$userList = $this->user_model->getUserInviteList($user_id, $pagingInfo['pageindex'], $this->pageSize);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'userList'	=> $userList,
			'user' => $user
		);

		$this->load->view('manage/user/user_invite', $data);
	}


	/**
	 * 添加用户
	 */
	public function add(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//初始化用户信息
			$user = $this->user_model->initInsert($this->input->post());

			$existUser = $this->user_model->oneUserByEmail($user);

			if ($existUser) {

				switch (TRUE) {

					case $user['user_email'] === $existUser['user_email']:
						
						$result['message'] = '该用户邮箱已注册';
					break;
				}
			}else{

				//尝试写入
				if ($this->user_model->insert($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = '添加成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 编辑用户
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$user = $this->user_model->initUpdate($this->input->post());

			$existUser = $this->user_model->oneUserByEmail($user, TRUE);

			if ($existUser) {

				switch (TRUE) {

					case $user['user_email'] === $existUser['user_email']:
						
						$result['message'] = '该用户邮箱已注册';
					break;
				}
			}else{

				//尝试修改
				if ($this->user_model->update($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = '修改成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 获取单个用户的信息
	 */
	public function one(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试',
				'user'	=> array()
			);
			
			$userId = $this->input->post('user_id');

			if ($userId) {

				$user = $this->user_model->one($userId);

				if ($user) {
					
					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['user'] = $user;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 删除用户
	 */
	public function delete(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$userId = $this->input->post('user_id');

			if ($userId) {

				//尝试删除
				if ($this->user_model->delete($userId)) {
					
					$result['status'] = TRUE;
					$result['message'] = '删除成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 用户充值记录页面
	 */
	public function user_recharge($userId = 0, $pageIndex = 1){

		if ($userId > 0) {
			
			$user = $this->user_model->one($userId);

			//用户存在
			if ($user && is_array($user) && count($user)) {

				$rechargeCount = $this->recharge_model->countUserRecharge($userId);

				$pagingInfo = getPagingInfo($rechargeCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/user/user_recharge/' . $userId . '/'));

				$rechargeList = $this->recharge_model->getUserRecharge($pagingInfo['pageindex'], $this->pageSize, $userId);

				$data = array(

					'pagingInfo' => $pagingInfo,
					'rechargeList'	=> $rechargeList
				);

				$this->load->view('manage/user/user_recharge', $data);
			}
		}
	}


	/**
	 * 用户提现记录页面
	 */
	public function user_withdraw($userId = 0, $pageIndex = 1){

		if ($userId > 0) {
			
			$user = $this->user_model->one($userId);

			//用户存在
			if ($user && is_array($user) && count($user)) {

				$withdrawCount = $this->withdraw_model->countUserWithdraw($userId);

				$pagingInfo = getPagingInfo($withdrawCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/user/user_withdraw/' . $userId . '/'));

				$withdrawList = $this->withdraw_model->getUserWithdraw($pagingInfo['pageindex'], $this->pageSize, $userId);

				$data = array(

					'pagingInfo' => $pagingInfo,
					'withdrawList'	=> $withdrawList
				);

				$this->load->view('manage/user/user_withdraw', $data);
			}
		}
	}
}
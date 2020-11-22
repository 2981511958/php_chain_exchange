<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台实名审核控制器
 */
class Auth extends CI_Controller {


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
	}


	/**
	 * 审核列表
	 */
	public function index($pageIndex = 1){

		$search = isset($_GET['search']) ? trim($_GET['search']) : '';

		$authCount = $this->user_model->countAuth($search);

		$pagingInfo = getPagingInfo($authCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/auth/index/'));

		$authList = $this->user_model->getAuth($pagingInfo['pageindex'], $this->pageSize, $search);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'authList'	=> $authList,
			'search' => $search
		);

		$this->load->view('manage/user/auth_index', $data);
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

			$user = $this->user_model->one($_POST['user_id']);

			if ($user) {
				
				$user['user_auth'] = $_POST['action'] == 1 ? 3 : 2;

				if ($this->user_model->update($user)) {
					
					$result['status'] = TRUE;
					$result['message'] = $_POST['action'] == 1 ? '成功通过' : '已拒绝';
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
			
			$authId = $this->input->post('user_id');

			if ($authId) {

				$auth = $this->user_model->one($authId);

				if ($auth) {
					
					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['user'] = $auth;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
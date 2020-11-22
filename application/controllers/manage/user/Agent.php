<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台用户控制器
 */
class Agent extends CI_Controller {


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
		$this->load->model('recharge_model');
		$this->load->model('withdraw_model');
	}


	/**
	 * 用户页面
	 */
	public function index($pageIndex = 1){

		$search = isset($_GET['search']) ? trim($_GET['search']) : '';

		$userCount = $this->user_model->countAgent($search);

		$pagingInfo = getPagingInfo($userCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/agent/index/'));

		$userList = $this->user_model->getAgentList($pagingInfo['pageindex'], $this->pageSize, $search);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'userList'	=> $userList,
			'search' => $search
		);

		$this->load->view('manage/user/user_agent', $data);
	}


	public function son_recharge($agentUserId = 0, $pageIndex = 1){

		$agentUser = $this->user_model->one($agentUserId);

		if ($agentUser && $agentUser['user_agent'] == 1) {

			$agentSonList = $this->user_model->getUserInviteList($agentUser['user_id'], FALSE, FALSE);

			$agentSonIdList = array_column($agentSonList, 'user_id');

			$rechargeCount = 0;
			$pagingInfo = getPagingInfo($rechargeCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/agent/son_recharge/' . $agentUserId . '/'));
			$rechargeList = array();

			if ($agentSonIdList && count($agentSonIdList)) {
				
				$rechargeCount = $this->recharge_model->countAllRecharge($agentSonIdList);

				$pagingInfo = getPagingInfo($rechargeCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/agent/son_recharge/' . $agentUserId . '/'));

				$rechargeList = $this->recharge_model->getAllRecharge($pagingInfo['pageindex'], $this->pageSize, $agentSonIdList);
			}
			
			$data = array(

				'pagingInfo' => $pagingInfo,
				'rechargeList'	=> $rechargeList
			);

			$this->load->view('manage/user/user_agent_recharge', $data);
		}
	}


	public function son_withdraw($agentUserId = 0, $pageIndex = 1){

		$agentUser = $this->user_model->one($agentUserId);

		if ($agentUser && $agentUser['user_agent'] == 1) {

			$agentSonList = $this->user_model->getUserInviteList($agentUser['user_id'], FALSE, FALSE);

			$agentSonIdList = array_column($agentSonList, 'user_id');

			$withdrawCount = 0;
			$pagingInfo = getPagingInfo($withdrawCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/agent/son_withdraw/' . $agentUserId . '/'));
			$withdrawList = array();

			if ($agentSonIdList && count($agentSonIdList)) {
				
				$withdrawCount = $this->withdraw_model->countAllWithdraw($agentSonIdList);

				$pagingInfo = getPagingInfo($withdrawCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/user/agent/son_withdraw/' . $agentUserId . '/'));

				$withdrawList = $this->withdraw_model->getAllWithdraw($pagingInfo['pageindex'], $this->pageSize, $agentSonIdList);
			}
			
			$data = array(

				'pagingInfo' => $pagingInfo,
				'withdrawList'	=> $withdrawList
			);

			$this->load->view('manage/user/user_agent_withdraw', $data);
		}
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台币币订单控制器
 */
class Order extends CI_Controller {


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
		$this->load->model('order_model');
	}


	/**
	 * 挂起订单
	 */
	public function delegate($pageIndex = 1){

		$orderCount = $this->order_model->countAllOrder(0);

		$pagingInfo = getPagingInfo($orderCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/bibi/order/delegate/'));

		$orderList = $this->order_model->getAllOrder(0, $pagingInfo['pageindex'], $this->pageSize);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'orderList'	=> $orderList
		);

		$this->load->view('manage/bibi/order_delegate', $data);
	}


	//历史订单
	public function history($pageIndex = 1){

		$orderCount = $this->order_model->countAllOrder(1);

		$pagingInfo = getPagingInfo($orderCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/bibi/order/history/'));

		$orderList = $this->order_model->getAllOrder(1, $pagingInfo['pageindex'], $this->pageSize);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'orderList'	=> $orderList
		);

		$this->load->view('manage/bibi/order_history', $data);
	}
}
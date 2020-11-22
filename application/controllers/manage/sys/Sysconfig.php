<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台系统设置控制器
 */
class Sysconfig extends CI_Controller {


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();

		//载入模型
		$this->load->model('sysconfig_model');
	}


	/**
	 * 基本配置
	 */
	public function index($pageIndex = 1){

		//读取系统设置
		$sysconfig = $this->sysconfig_model->getSysconfig();

		$data = array(

			'sysconfig' => $sysconfig
		);

		$this->load->view('manage/sys/sysconfig_index', $data);
	}


	/**
	 * 更新系统设置
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$sysconfig = $this->input->post();

			//尝试更新
			if ($this->sysconfig_model->updateSysconfig($sysconfig)) {
				
				$result['status'] = TRUE;
				$result['message'] = '更新成功';
			}

			$_SESSION['SYSCONFIG'] = $this->sysconfig_model->getFormatSysconfig();

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台管理员控制器
 */
class Admin extends CI_Controller {


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();
	}


	//修改密码
	public function modifypwd(){

		if ($_POST) {

			$result = array(

			    'status'    => FALSE,
			    'message'   => '网络繁忙，请稍后再试'
			);
			
			$admin_password = pwd_encode($this->input->post('admin_password'));
			$admin_password_old = pwd_encode($this->input->post('admin_password_old'));
			$admin_password_check = pwd_encode($this->input->post('admin_password_check'));

			$admin = $this->admin_model->one($_SESSION['MANAGE']['ADMIN_ID']);

			if ($admin) {
				
				if ($admin_password == $admin_password_check) {
					
					if ($admin_password_old == $admin['admin_password']) {
						
						$admin['admin_password'] = $admin_password;

						if ($this->admin_model->update($admin)) {
							
							$result['status'] = TRUE;
							$result['message'] = '修改成功';
						}
					}else{

						$result['message'] = '原密码不正确';
					}
				}else{

					$result['message'] = '两次输入的新密码不一致';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}else{

			$this->load->view('manage/admin_pwd');
		}
	}
}
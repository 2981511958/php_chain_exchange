<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台货币控制器
 */
class Coin extends CI_Controller {


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();

		//载入模型
		$this->load->model('coin_model');
	}


	/**
	 * 货币页面
	 */
	public function index(){

		$coinList = $this->coin_model->getAllCoinList();

		$data = array(

			'coinList' => $coinList,
			'chainList' => $this->config->item('udun_chain')
		);

		$this->load->view('manage/sys/coin_index', $data);
	}


	/**
	 * 添加货币
	 */
	public function add(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//初始化货币信息
			$coin = $this->coin_model->initInsert($this->input->post());

			$existCoin = $this->coin_model->oneCoinByNameOrSymbol($coin);

			if ($existCoin) {

				switch (TRUE) {

					case $coin['coin_symbol'] === $existCoin['coin_symbol']:
						
						$result['message'] = '货币标识已存在';
					break;
				}
			}else{

				//尝试写入
				if ($this->coin_model->insert($coin)) {
					
					$result['status'] = TRUE;
					$result['message'] = '添加成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 编辑货币
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$coin = $this->coin_model->initUpdate($this->input->post());

			$existCoin = $this->coin_model->oneCoinByNameOrSymbol($coin, TRUE);

			if ($existCoin) {

				switch (TRUE) {

					case $coin['coin_name'] === $existCoin['coin_name']:
						
						$result['message'] = '货币名已存在';
					break;

					case $coin['coin_symbol'] === $existCoin['coin_symbol']:
						
						$result['message'] = '货币标识已存在';
					break;
				}
			}else{

				//尝试修改
				if ($this->coin_model->update($coin)) {
					
					$result['status'] = TRUE;
					$result['message'] = '修改成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 获取单个货币的信息
	 */
	public function one(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试',
				'coin'	=> array()
			);
			
			$coinId = $this->input->post('coin_id');

			if ($coinId) {

				$coin = $this->coin_model->one($coinId);

				if ($coin) {

					$coin['coin_withdraw_amount'] = floatval($coin['coin_withdraw_amount']);
					$coin['coin_withdraw_fee'] = floatval($coin['coin_withdraw_fee']);
					$coin['coin_recharge_min_amount'] = floatval($coin['coin_recharge_min_amount']);
					
					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['coin'] = $coin;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 删除货币
	 */
	public function delete(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$coinId = $this->input->post('coin_id');

			if ($coinId) {

				//尝试删除
				if ($this->coin_model->delete($coinId)) {
					
					$result['status'] = TRUE;
					$result['message'] = '删除成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
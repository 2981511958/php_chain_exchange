<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台币币交易市场控制器
 */
class Market extends CI_Controller {


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();

		//载入模型
		$this->load->model('market_model');
		$this->load->model('robot_model');
	}


	/**
	 * 交易市场页面
	 */
	public function index(){

		$marketListTemp = $this->market_model->getAllMarketList();

		$marketList = FALSE;

		if ($marketListTemp && count($marketListTemp)) {
			
			foreach ($marketListTemp as $marketItem) {
				
				$marketList[$marketItem['market_money_symbol']][] = $marketItem;
			}
		}

		$this->load->model('coin_model');
		$coinList = $this->coin_model->getActiveCoinList();

		$data = array(

			'marketList' => $marketList,
			'coinList' => $coinList
		);

		$this->load->view('manage/bibi/market_index', $data);
	}


	/**
	 * 添加交易市场
	 */
	public function add(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//初始化交易市场信息
			$market = $this->market_model->initInsert($this->input->post());

			if ($market['market_stock_coin'] == $market['market_money_coin']) {
				
				$result['message'] = '交易币种和结算币种不能相同';
			}else{

				$existMarket = $this->market_model->oneExistsMarketByStockMoney($market);

				if ($existMarket) {

					$result['message'] = '交易对已存在';
				}else{

					//尝试写入
					if ($this->market_model->insert($market)) {
						
						$result['status'] = TRUE;
						$result['message'] = '添加成功';
					}
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 编辑交易市场
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$market = $this->market_model->initUpdate($this->input->post());

			if ($market['market_stock_coin'] == $market['market_money_coin']) {
				
				$result['message'] = '交易币种和结算币种不能相同';
			}else{

				$existMarket = $this->market_model->oneExistsMarketByStockMoney($market, TRUE);

				if ($existMarket) {

					$result['message'] = '交易对已存在';
				}else{

					//尝试修改
					if ($this->market_model->update($market)) {
						
						$result['status'] = TRUE;
						$result['message'] = '修改成功';
					}
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 获取单个交易市场的信息
	 */
	public function one(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试',
				'market'	=> array()
			);
			
			$marketId = $this->input->post('market_id');

			if ($marketId) {

				$market = $this->market_model->one($marketId);

				if ($market) {

					$market['market_min_amount'] = floatval($market['market_min_amount']);
					$market['market_taker_fee'] = floatval($market['market_taker_fee']);
					$market['market_maker_fee'] = floatval($market['market_maker_fee']);
					
					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['market'] = $market;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 删除交易市场
	 */
	public function delete(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$marketId = $this->input->post('market_id');

			if ($marketId) {

				//尝试删除
				if ($this->market_model->delete($marketId)) {

					$robot = $this->robot_model->oneRobotByMarketId($marketId);

					if ($robot && count($robot)) {
						
						$this->robot_model->delete($robot['robot_id']);
					}
					
					$result['status'] = TRUE;
					$result['message'] = '删除成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
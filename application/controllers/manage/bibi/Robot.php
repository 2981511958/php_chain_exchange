<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台币币机器人控制器
 */
class Robot extends CI_Controller {


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
	 * 机器人页面
	 */
	public function index(){

		$robotList = $this->robot_model->get();

		if ($robotList && count($robotList)) {
			
			$robotList = array_column($robotList, NULL, 'market_id');
		}

		$marketListTemp = $this->market_model->getAllMarketList();
		$marketListGroup = FALSE;

		if ($marketListTemp && count($marketListTemp)) {

			$marketList = array_column($marketListTemp, NULL, 'market_id');
			
			foreach ($marketListTemp as $marketItem) {
				
				$marketListGroup[$marketItem['market_money_symbol']][] = $marketItem;
			}
		}

		$data = array(

			'robotList' => $robotList,
			'marketList' => $marketList,
			'marketListGroup' => $marketListGroup
		);

		$this->load->view('manage/bibi/robot_index', $data);
	}


	/**
	 * 添加机器人
	 */
	public function add(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//初始化机器人信息
			$robot = $this->robot_model->initInsert($this->input->post());

			$market = $this->market_model->one($robot['robot_market']);

			if ($market) {

				if ($robot['robot_huobi'] == 0 && ($robot['robot_price_float'] == '' || !is_numeric($robot['robot_price_float']))) {
					
					$result['message'] = '火币没有行情时，必须填写价格浮动';
				}else{

					if (bccomp($robot['robot_max_price'], $robot['robot_min_price'], $market['market_decimal']) >= 0) {

						if (bccomp($robot['robot_max_amount'], $robot['robot_min_amount'], $market['market_decimal']) >= 0) {

							//行情计划判断
							$cronCheck = TRUE;
							$cronMessage = '';

							if ($robot['robot_cron'] == 1) {

								if (bccomp($robot['robot_cron_target'], 0, 8) < 0) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器目标价格必须大于0';
								}

								if (bccomp($robot['robot_cron_target'], $robot['robot_min_price'], 8) < 0 || bccomp($robot['robot_cron_target'], $robot['robot_max_price'], 8) > 0) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器目标价格必须在最低价格和最高价格的范围内';
								}

								if ($cronCheck && ($robot['robot_cron_start'] > $robot['robot_cron_end'])) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器结束时间必须晚于开始时间';
								}

								if ($robot['robot_cron_end'] == '') {
									
									$cronCheck = FALSE;
									$cronMessage = '请填写定时器结束时间';
								}else{

									$robot['robot_cron_end'] = strtotime($robot['robot_cron_end']);
								}

								if ($robot['robot_cron_start'] == '') {
									
									$cronCheck = FALSE;
									$cronMessage = '请填写定时器开始时间';
								}else{

									$robot['robot_cron_start'] = strtotime($robot['robot_cron_start']);
								}
							}else{

								$robot['robot_cron_start'] = $robot['robot_cron_start'] == '' ? 0 : strtotime($robot['robot_cron_start']);
								$robot['robot_cron_end'] = $robot['robot_cron_end'] == '' ? 0 : strtotime($robot['robot_cron_end']);
							}

							if ($cronCheck) {
								
								$existRobot = $this->robot_model->oneRobotByMarketId($robot['robot_market']);

								if ($existRobot) {

									$result['message'] = '相同交易对的机器人已存在';
								}else{

									//尝试写入
									if ($this->robot_model->insert($robot)) {
										
										$result['status'] = TRUE;
										$result['message'] = '添加成功';
									}
								}
							}else{

								$result['message'] = $cronMessage;
							}
						}else{

							$result['message'] = '最高数量不能小于最低数量';
						}
					}else{

						$result['message'] = '最高价格不能小于最低价格';
					}
				}
			}else{

				$result['message'] = '交易对不存在';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 编辑机器人
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$robot = $this->robot_model->initUpdate($this->input->post());

			$market = $this->market_model->one($robot['robot_market']);

			if ($market) {

				if ($robot['robot_huobi'] == 0 && ($robot['robot_price_float'] == '' || !is_numeric($robot['robot_price_float']))) {
					
					$result['message'] = '火币没有行情时，必须填写价格浮动';
				}else{

					if (bccomp($robot['robot_max_price'], $robot['robot_min_price'], $market['market_decimal']) >= 0) {

						if (bccomp($robot['robot_max_amount'], $robot['robot_min_amount'], $market['market_decimal']) >= 0) {

							//行情计划判断
							$cronCheck = TRUE;
							$cronMessage = '';

							if ($robot['robot_cron'] == 1) {

								if (bccomp($robot['robot_cron_target'], 0, 8) < 0) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器目标价格必须大于0';
								}

								if (bccomp($robot['robot_cron_target'], $robot['robot_min_price'], 8) < 0 || bccomp($robot['robot_cron_target'], $robot['robot_max_price'], 8) > 0) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器目标价格必须在最低价格和最高价格的范围内';
								}

								if ($cronCheck && ($robot['robot_cron_start'] > $robot['robot_cron_end'])) {
									
									$cronCheck = FALSE;
									$cronMessage = '定时器结束时间必须晚于开始时间';
								}

								if ($robot['robot_cron_end'] == '') {
									
									$cronCheck = FALSE;
									$cronMessage = '请填写定时器结束时间';
								}else{

									$robot['robot_cron_end'] = strtotime($robot['robot_cron_end']);
								}

								if ($robot['robot_cron_start'] == '') {
									
									$cronCheck = FALSE;
									$cronMessage = '请填写定时器开始时间';
								}else{

									$robot['robot_cron_start'] = strtotime($robot['robot_cron_start']);
								}
							}else{

								$robot['robot_cron_start'] = $robot['robot_cron_start'] == '' ? 0 : strtotime($robot['robot_cron_start']);
								$robot['robot_cron_end'] = $robot['robot_cron_end'] == '' ? 0 : strtotime($robot['robot_cron_end']);
							}

							if ($cronCheck) {
								
								$existRobot = $this->robot_model->oneRobotByMarketId($robot['robot_market'], $robot['robot_id']);

								if ($existRobot) {

									$result['message'] = '相同交易对的机器人已存在';
								}else{

									//尝试修改
									if ($this->robot_model->update($robot)) {
										
										$result['status'] = TRUE;
										$result['message'] = '修改成功';
									}
								}
							}else{

								$result['message'] = $cronMessage;
							}
						}else{

							$result['message'] = '最高数量不能小于最低数量';
						}
					}else{

						$result['message'] = '最高价格不能小于最低价格';
					}
				}
			}else{

				$result['message'] = '交易对不存在';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 获取单个机器人的信息
	 */
	public function one(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试',
				'robot'	=> array()
			);
			
			$robotId = $this->input->post('robot_id');

			if ($robotId) {

				$robot = $this->robot_model->one($robotId);

				if ($robot) {

					$robot['robot_min_price'] = floatval($robot['robot_min_price']);
					$robot['robot_max_price'] = floatval($robot['robot_max_price']);
					$robot['robot_min_amount'] = floatval($robot['robot_min_amount']);
					$robot['robot_max_amount'] = floatval($robot['robot_max_amount']);
					$robot['robot_price_float'] = floatval($robot['robot_price_float']);
					$robot['robot_cron_target'] = floatval($robot['robot_cron_target']);
					
					$robot['robot_cron_start'] = $robot['robot_cron_start'] > 0 ? date('Y-m-d H:i:s', $robot['robot_cron_start']) : '';
					$robot['robot_cron_end'] = $robot['robot_cron_end'] > 0 ? date('Y-m-d H:i:s', $robot['robot_cron_end']) : '';

					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['robot'] = $robot;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 删除机器人
	 */
	public function delete(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$robotId = $this->input->post('market_id');

			if ($robotId) {

				//尝试删除
				if ($this->robot_model->delete($robotId)) {
					
					$result['status'] = TRUE;
					$result['message'] = '删除成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
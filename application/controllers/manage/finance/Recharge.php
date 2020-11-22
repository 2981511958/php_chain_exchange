<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台充值记录控制器
 */
class Recharge extends CI_Controller {


	/**
	 * 每页数量
	 */
	private $pageSize = 20;


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//载入模型
		$this->load->model('recharge_model');
		$this->load->model('asset_model');
		$this->load->model('user_model');
	}


	/**
	 * 充值记录页面
	 */
	public function index($pageIndex = 1){

		$search = isset($_GET['search']) ? trim($_GET['search']) : '';
		$searchUserIdList = FALSE;

		if ($search != '') {
			
			$searchUserIdList = $this->user_model->searchUserIdList($search);
		}

		$rechargeCount = $this->recharge_model->countAllRecharge($searchUserIdList);

		$pagingInfo = getPagingInfo($rechargeCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/finance/recharge/index/'));

		$rechargeList = $this->recharge_model->getAllRecharge($pagingInfo['pageindex'], $this->pageSize, $searchUserIdList);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'rechargeList'	=> $rechargeList,
			'search' => $search
		);

		$this->load->view('manage/finance/recharge_index', $data);
	}


	public function download(){

		$agentList = $this->user_model->getAgentList(FALSE, FALSE);

		if ($agentList && count($agentList)) {
			
			$agentList = array_column($agentList, NULL, 'user_id');

			$rechargeList = $this->recharge_model->getAllRecharge(FALSE, FALSE);

			if ($rechargeList && count($rechargeList)) {

				$noAgentRechargeList = array();
				
				foreach ($rechargeList as $rechargeItem) {
					
					if (isset($agentList[$rechargeItem['recharge_user_parent']])) {
						
						$agentList[$rechargeItem['recharge_user_parent']]['data'][] = $rechargeItem;
					}else{

						$noAgentRechargeList[] = $rechargeItem;
					}
				}

				$fileContent = "代理商,用户名,到帐时间,币种,充值数量,业务流水号\n";

				foreach ($agentList as $agentItem) {
					
					if (isset($agentItem['data'])) {
						
						$fileContent .= " , , , , , \n";

						foreach ($agentItem['data'] as $rechargeItem) {
							
							$fileContent .= 
								$rechargeItem['recharge_user_parent_name'] . "\t," .
								$rechargeItem['recharge_user_name'] . "\t," .
								date('Y-m-d H:i', $rechargeItem['recharge_time']) . "\t," .
								$rechargeItem['recharge_coin_symbol'] . "\t," .
								$rechargeItem['recharge_amount'] . "\t," .
								$rechargeItem['recharge_trade_id'] . "\t\n";
						}
					}
				}

				if (count($noAgentRechargeList)) {
					
					$fileContent .= " , , , , , \n";

					foreach ($noAgentRechargeList as $rechargeItem) {
						
						$fileContent .= 
							"无代理商," .
							$rechargeItem['recharge_user_name'] . "\t," .
							date('Y-m-d H:i', $rechargeItem['recharge_time']) . "\t," .
							$rechargeItem['recharge_coin_symbol'] . "\t," .
							$rechargeItem['recharge_amount'] . "\t," .
							$rechargeItem['recharge_trade_id'] . "\t\n";
					}
				}

			    echo $fileContent;
			    exit;
			}
		}
	}
}
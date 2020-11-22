<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台提现记录控制器
 */
class Withdraw extends CI_Controller {


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
		$this->load->model('withdraw_model');
		$this->load->model('asset_model');
		$this->load->model('wallet_model');
		$this->load->model('user_model');
	}


	/**
	 * 提现记录页面
	 */
	public function index($pageIndex = 1){

		$search = isset($_GET['search']) ? trim($_GET['search']) : '';
		$searchUserIdList = FALSE;

		if ($search != '') {
			
			$searchUserIdList = $this->user_model->searchUserIdList($search);
		}

		$withdrawCount = $this->withdraw_model->countAllWithdraw($searchUserIdList);

		$pagingInfo = getPagingInfo($withdrawCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/finance/withdraw/index/'));

		$withdrawList = $this->withdraw_model->getAllWithdraw($pagingInfo['pageindex'], $this->pageSize, $searchUserIdList);

		$data = array(

			'pagingInfo' => $pagingInfo,
			'withdrawList'	=> $withdrawList,
			'search' => $search
		);

		$this->load->view('manage/finance/withdraw_index', $data);
	}


	/**
	 * 编辑提现记录
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$withdraw = $this->withdraw_model->oneWithdraw($this->input->post('withdraw_id'));

			if ($withdraw) {

				//通过，并转发到钱包
				if (intval($this->input->post('action'))) {

				//拒绝，需要解除冻结
				}else{

					//解除冻结已封装进方法
					if ($this->withdraw_model->refuseWithdraw($withdraw)) {
						
						$result['status'] = TRUE;
						$result['message'] = '提现已拒绝';
					}
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	public function download(){

		$agentList = $this->user_model->getAgentList(FALSE, FALSE);

		if ($agentList && count($agentList)) {
			
			$agentList = array_column($agentList, NULL, 'user_id');

			$withdrawList = $this->withdraw_model->getAllWithdraw(FALSE, FALSE, FALSE, TRUE);

			if ($withdrawList && count($withdrawList)) {

				$noAgentwithdrawList = array();
				
				foreach ($withdrawList as $withdrawItem) {
					
					if (isset($agentList[$withdrawItem['withdraw_user_parent']])) {
						
						$agentList[$withdrawItem['withdraw_user_parent']]['data'][] = $withdrawItem;
					}else{

						$noAgentwithdrawList[] = $withdrawItem;
					}
				}

				$fileContent = "上级代理商,用户名,提交时间,币种,提现数量,实际到帐,业务编号\n";

				foreach ($agentList as $agentItem) {
					
					if (isset($agentItem['data'])) {
						
						$fileContent .= " , , , , , , \n";

						foreach ($agentItem['data'] as $withdrawItem) {
							
							$fileContent .= 
								$withdrawItem['withdraw_user_parent_name'] . "\t," .
								$withdrawItem['withdraw_user_name'] . "\t," .
								date('Y-m-d H:i', $withdrawItem['withdraw_time']) . "\t," .
								$withdrawItem['withdraw_chain_symbol'] . "\t," .
								$withdrawItem['withdraw_amount'] . "\t," .
								$withdrawItem['withdraw_finally_amount'] . "\t," .
								$withdrawItem['withdraw_no'] . ($withdrawItem['withdraw_local'] ? ' (内部)' : '') . "\t\n";
						}
					}
				}

				if (count($noAgentwithdrawList)) {
					
					$fileContent .= " , , , , , , \n";

					foreach ($noAgentwithdrawList as $withdrawItem) {
						
						$fileContent .= 
							"无代理商," .
							$withdrawItem['withdraw_user_name'] . "\t," .
							date('Y-m-d H:i', $withdrawItem['withdraw_time']) . "\t," .
							$withdrawItem['withdraw_chain_symbol'] . "\t," .
							$withdrawItem['withdraw_amount'] . "\t," .
							$withdrawItem['withdraw_finally_amount'] . "\t," .
							$withdrawItem['withdraw_no'] . ($withdrawItem['withdraw_local'] ? ' (内部)' : '') . "\t\n";
					}
				}

			    echo $fileContent;
			    exit;
			}
		}
	}
}
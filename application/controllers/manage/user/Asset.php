<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台用户资产控制器
 */
class Asset extends CI_Controller {


	/**
	 * 资产流水每页数量
	 */
	private $assetLogPageSize = 20;


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//检测管理员登陆
		$this->load->model('admin_model');
		$this->admin_model->checkLogin();

		//设置资产计算保留的小数位精度
        bcscale($this->config->item('ex_asset_scale'));

		//载入模型
		$this->load->model('user_model');
		$this->load->model('asset_model');
		$this->load->model('coin_model');
	}


	/**
	 * 用户资产页面
	 */
	public function user_asset($userId = 0, $plateId = 1){

		if ($userId > 0) {
			
			$user = $this->user_model->one($userId);

			//用户存在
			if ($user && is_array($user) && count($user)) {

				//资产信息容器
				$userAsset = $this->asset_model->getUserAsset($userId);
				$userDmAsset = $this->asset_model->getUserDmAsset($userId);
				
				$data = array(

					'user' => $user,
					'userAsset' => $userAsset,
					'userDmAsset' => $userDmAsset,
					'plateId' => $plateId
				);

				$this->load->view('manage/user/user_asset', $data);
			}
		}
	}


	/**
	 * 变动用户的币种资产
	 */
	public function changeUserCoinAsset(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//获取变动信息
			$change = $this->input->post();

			//判断变动金额是否为大于0的数字
			if (is_numeric($change['change_amount']) && $change['change_amount'] > 0) {

				//尝试变动
				
				//币币帐户
				if ($change['change_plate'] == 1) {
					
					$changeResult = $this->asset_model->assetChange($change['change_user'], $change['change_coin_symbol'], $change['change_amount'], $change['change_action'], $change['change_remark']);

					if ($changeResult['status']) {
						
						$result['status'] = TRUE;
						$result['message'] = '操作成功';
					}else{

						$result['message'] = $changeResult['message'];
					}
				}

				//合约帐户
				if ($change['change_plate'] == 4) {

					if ($change['change_action'] == 6) {
						
						$change['change_amount'] = bcsub(0, $change['change_amount']);
					}
					
					$dmAsset = $this->asset_model->oneAssetByUserAndCoinAndPlate($change['change_user'], $change['change_coin_id'], 4);

					$changeResult = FALSE;
					
					if ($dmAsset && count($dmAsset)) {
					    
					    $dmAsset['asset_active'] = bcadd($change['change_amount'], $dmAsset['asset_active']);
					    $dmAsset['asset_total'] = bcadd($dmAsset['asset_frozen'], $dmAsset['asset_active']);

					    // $dmAsset['asset_active'] = bccomp($dmAsset['asset_active'], 0) < 0 ? 0 : $dmAsset['asset_active'];
					    // $dmAsset['asset_total'] = bccomp($dmAsset['asset_total'], 0) < 0 ? 0 : $dmAsset['asset_total'];
					    // $dmAsset['asset_frozen'] = bccomp($dmAsset['asset_frozen'], 0) < 0 ? 0 : $dmAsset['asset_frozen'];

					    $changeResult = $this->asset_model->update($dmAsset);
					}else{

					    $dmAsset = $this->asset_model->fieldsArray;

					    $dmAsset['asset_plate'] = 4;
					    $dmAsset['asset_user'] = $change['change_user'];
					    $dmAsset['asset_coin'] = $change['change_coin_id'];
					    $dmAsset['asset_active'] = $change['change_amount'];
					    $dmAsset['asset_total'] = $change['change_amount'];
					    $dmAsset['asset_frozen'] = 0;

					    // $dmAsset['asset_active'] = bccomp($dmAsset['asset_active'], 0) < 0 ? 0 : $dmAsset['asset_active'];
					    // $dmAsset['asset_total'] = bccomp($dmAsset['asset_total'], 0) < 0 ? 0 : $dmAsset['asset_total'];
					    // $dmAsset['asset_frozen'] = bccomp($dmAsset['asset_frozen'], 0) < 0 ? 0 : $dmAsset['asset_frozen'];

					    $changeResult = $this->asset_model->insert($dmAsset);
					}

					if ($changeResult) {
						
						$result['status'] = TRUE;
						$result['message'] = '操作成功';
					}
				}
				
			}else{

				$result['message'] = '变动额度必须是大于0的数字';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
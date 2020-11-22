<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户资产模型
 */
class Asset_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_asset';


    /**
     * 构造函数,初始化
     */
    public function __construct(){

        parent::__construct();

        //设置资产计算保留的小数位精度
        bcscale($this->config->item('ex_asset_scale'));

        $this->load->model('coin_model');
        $this->load->model('market_model');
        $this->load->model('asset_log_model');
    }


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'asset_id' => 0,
        'asset_plate' => 0,
        'asset_user' => 0,
        'asset_coin' => 0,
        'asset_total' => '0.00000000',
        'asset_active' => '0.00000000',
        'asset_frozen' => '0.00000000',
        'asset_status' => 1,
    );


    /**
     * 变动用户某个币种的资产
     * @param  array  $user_id
     * @param  float  $amount 变动金额,大于0的数字
     * @param  int    $action 约定的对应资产变动操作ID
     * @param  string $remark 资产变动说明
     * @return array          返回变动结果数组,array(
     *                                            'status' => bool,变动成功为TRUE，变动失败为False,
     *                                            'message'=> 提示文字
     *                                        )
     */
    public function assetChange($user_id, $coin_symbol, $amount, $action, $remark = FALSE){

        $result = array(

            'status' => FALSE,
            'message' => '操作失败'
        );

        //初始化
        $action = intval($action);

        //判断资产操作是否在约定范围
        if (in_array($action, array_keys($this->config->item('ex_asset_action_list')))) {

            //判断金额的合法性
            if (is_numeric($amount) && $amount > 0) {
                
                //根据操作判断是该加还是该减
                if ($action === 2 || $action === 4 || $action === 6) {
                    
                    $amount = bcsub(0, $amount);
                }

                $detail = array(

                    'time' => APP_TIME,
                    'action' => $action
                );

                if ($remark) {
                    
                    $detail['remark'] = $remark;
                }
            }else{

                $result['message'] = '金额不合法';
            }
        }else{

            $result['message'] = '非法操作';
        }

        return $result;
    }


    /**
     * 通过用户ID、币种ID、版块ID获取资产记录
     * @param  int    $userId  用户ID
     * @param  int    $coinId  币种标识
     * @return array           返回资产对象,若不存在,构建一条新的资产对象返回
     */
    public function oneAssetByUserAndCoinAndPlate($userId, $coinId, $plateId){

        $where = '`asset_user`=' . $userId . ' AND `asset_coin`=' . $coinId . ' AND `asset_plate`=' . $plateId;

        return $this->one(FALSE, $where);
    }


    public function listAssetByUserAndCoinAndPlate($userId, $plateId){

        $where = '`asset_user`=' . $userId . ' AND `asset_plate`=' . $plateId;

        return $this->get(FALSE, FALSE, $where);
    }


    /**
     * 获取用户币币资产列表
     * @param  int     $userId    用户ID
     * @param  int     $coin_symbol   币种
     * @return array              返回若干个用户资产组成的数组
     */
    public function getUserAsset($userId, $coin_symbol = FALSE){

        $asset = array();

        $assetList = array();

        if ($coin_symbol) {
            
            if (isset($assetList[$coin_symbol])) {

                $asset = array(

                    'asset_active' => bcadd($assetList[$coin_symbol]['available'], 0),
                    'asset_frozen' => bcadd($assetList[$coin_symbol]['freeze'], 0),
                    'asset_total' => bcadd($assetList[$coin_symbol]['available'], $assetList[$coin_symbol]['freeze'])
                );
            }else{

                $asset = array(

                    'asset_active' => '0.00000000',
                    'asset_frozen' => '0.00000000',
                    'asset_total' => '0.00000000'
                );
            }

            $coin = $this->coin_model->oneActiveCoinBySymbol($coin_symbol);

            if ($coin && count($coin)) {

                $userCoinAsset = $this->oneAssetByUserAndCoinAndPlate($userId, $coin['coin_id'], 1);

                if ($userCoinAsset) {
                    
                    $asset['asset_total'] = bcadd($asset['asset_total'], $userCoinAsset['asset_frozen']);
                    $asset['asset_frozen'] = bcadd($asset['asset_frozen'], $userCoinAsset['asset_frozen']);
                }
            }
        }else{

            //获取币种列表
            $coinList = $this->coin_model->getAllCoinList();

            //资产信息容器
            $asset = array_column($coinList, NULL, 'coin_symbol');

            $userCoinAsset = $this->listAssetByUserAndCoinAndPlate($userId, 1);

            foreach ($asset as $coin) {
                
                if (isset($assetList[$coin['coin_symbol']])) {
                    
                    $asset[$coin['coin_symbol']]['asset_active'] = bcadd($assetList[$coin['coin_symbol']]['available'], 0);
                    $asset[$coin['coin_symbol']]['asset_frozen'] = bcadd($assetList[$coin['coin_symbol']]['freeze'], 0);
                    $asset[$coin['coin_symbol']]['asset_total']  = bcadd($assetList[$coin['coin_symbol']]['available'], $assetList[$coin['coin_symbol']]['freeze']);
                }else{

                    $asset[$coin['coin_symbol']]['asset_active'] = '0.00000000';
                    $asset[$coin['coin_symbol']]['asset_frozen'] = '0.00000000';
                    $asset[$coin['coin_symbol']]['asset_total'] = '0.00000000';
                }

                if ($userCoinAsset) {

                    foreach ($userCoinAsset as $assetItem) {
                        
                        if ($assetItem['asset_coin'] == $coin['coin_id']) {
                            
                            $asset[$coin['coin_symbol']]['asset_total'] = bcadd($asset[$coin['coin_symbol']]['asset_total'], $assetItem['asset_frozen']);
                            $asset[$coin['coin_symbol']]['asset_frozen'] = bcadd($asset[$coin['coin_symbol']]['asset_frozen'], $assetItem['asset_frozen']);
                        }
                    }
                }
            }
        }

        return $asset;
    }


    /**
     * 资产划转
     * @param  int    $userId     用户ID
     * @param  int    $fromPlate  从哪个版块划出
     * @param  int    $toPlate    划入到哪个版块
     * @param  int    $coinId     币种ID
     * @param  string $coinSymbol 币种标识
     * @param  float  $count      数量
     * @return bool               返回操作结果，划转成功返回TRUE，划转失败返回FALSE
     */
    public function asset_move($userId, $fromPlate, $toPlate, $coinId, $coinSymbol, $count){

        $result = FALSE;

        $this->db->trans_start();

        switch ($fromPlate . '_' . $toPlate) {

            //币币划转到合约
            case '1_4':
                
                //先扣币币
                if ($this->assetChange($userId, $coinSymbol, $count, 4)['status']) {

                    //再加合约
                    $resultTemp = FALSE;
                    $asset = $this->oneAssetByUserAndCoinAndPlate($userId, $coinId, 4);

                    if ($asset && count($asset)) {
                        
                        $asset['asset_active'] = bcadd($count, $asset['asset_active']);
                        $asset['asset_total'] = bcadd($asset['asset_active'], $asset['asset_frozen']);

                        $resultTemp = $this->update($asset);
                    }else{

                        $asset = $this->fieldsArray;

                        $asset['asset_plate'] = 4;
                        $asset['asset_user'] = $userId;
                        $asset['asset_coin'] = $coinId;
                        $asset['asset_active'] = $count;
                        $asset['asset_total'] = $count;

                        $resultTemp = $this->insert($asset);
                    }
                    
                    if ($resultTemp) {
                        
                        //币币转出记录
                        $assetLogOut = $this->asset_log_model->fieldsArray;

                        $assetLogOut['asset_log_plate'] = 1;
                        $assetLogOut['asset_log_user'] = $userId;
                        $assetLogOut['asset_log_coin'] = $coinId;
                        $assetLogOut['asset_log_action'] = 4;
                        $assetLogOut['asset_log_time'] = APP_TIME;
                        $assetLogOut['asset_log_amount'] = $count;
                        $assetLogOut['asset_log_remark'] = 4;

                        //合约转入记录
                        $assetLogIn = $this->asset_log_model->fieldsArray;

                        $assetLogIn['asset_log_plate'] = 4;
                        $assetLogIn['asset_log_user'] = $userId;
                        $assetLogIn['asset_log_coin'] = $coinId;
                        $assetLogIn['asset_log_action'] = 3;
                        $assetLogIn['asset_log_time'] = APP_TIME;
                        $assetLogIn['asset_log_amount'] = $count;
                        $assetLogIn['asset_log_remark'] = 1;

                        if ($this->asset_log_model->insert($assetLogOut) && $this->asset_log_model->insert($assetLogIn)) {
                            
                            $result = TRUE;
                        }
                    }
                }
            break;

            //合约划转到币币
            case '4_1':
                
                //先加币币
                if ($this->assetChange($userId, $coinSymbol, $count, 3)['status']) {

                    //再减合约
                    $asset = $this->oneAssetByUserAndCoinAndPlate($userId, $coinId, 4);

                    if ($asset && count($asset)) {
                        
                        $asset['asset_active'] = bcsub($asset['asset_active'], $count);
                        $asset['asset_total'] = bcadd($asset['asset_active'], $asset['asset_frozen']);

                        if ($this->update($asset)) {
                            
                            //合约转出记录
                            $assetLogOut = $this->asset_log_model->fieldsArray;

                            $assetLogOut['asset_log_plate'] = 4;
                            $assetLogOut['asset_log_user'] = $userId;
                            $assetLogOut['asset_log_coin'] = $coinId;
                            $assetLogOut['asset_log_action'] = 4;
                            $assetLogOut['asset_log_time'] = APP_TIME;
                            $assetLogOut['asset_log_amount'] = $count;
                            $assetLogOut['asset_log_remark'] = 1;

                            //币币转入记录
                            $assetLogIn = $this->asset_log_model->fieldsArray;

                            $assetLogIn['asset_log_plate'] = 1;
                            $assetLogIn['asset_log_user'] = $userId;
                            $assetLogIn['asset_log_coin'] = $coinId;
                            $assetLogIn['asset_log_action'] = 3;
                            $assetLogIn['asset_log_time'] = APP_TIME;
                            $assetLogIn['asset_log_amount'] = $count;
                            $assetLogIn['asset_log_remark'] = 4;

                            if ($this->asset_log_model->insert($assetLogOut) && $this->asset_log_model->insert($assetLogIn)) {
                                
                                $result = TRUE;
                            }
                        }
                    }
                }
            break;
        }

        $this->db->trans_complete();

        return $result;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 提现记录模型
 */
class Withdraw_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_withdraw';


    /**
     * 构造函数,初始化
     */
    public function __construct(){

        parent::__construct();

        //设置资产计算保留的小数位精度
        bcscale($this->config->item('ex_asset_scale'));

        $this->load->model('coin_model');
        $this->load->model('asset_model');
        $this->load->model('asset_log_model');
    }


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'withdraw_id' => 0,
        'withdraw_user' => 0,
        'withdraw_coin' => 0,
        'withdraw_time' => APP_TIME,
        'withdraw_to_address' => '',
        'withdraw_to_address_memo' => '',
        'withdraw_amount' => 0,
        'withdraw_fee' => 0,
        'withdraw_finally_amount' => 0,
        'withdraw_no' => '',
        'withdraw_txid' => '',
        'withdraw_trade_id' => '',
        'withdraw_local' => 0,
        'withdraw_chain' => 0,
        'withdraw_contract' => '',
        'withdraw_chain_symbol' => '',
        'withdraw_status' => 0
    );


    public $joinTemplate = array(

        //与币种表联表
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'withdraw_coin',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询交易币种标识
                'coin_symbol' => 'withdraw_coin_symbol'
            )
        ),
        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'withdraw_user',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'withdraw_user_name',
                'user_parent' => 'withdraw_user_parent'
            )
        ),
        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'withdraw_user_parent',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'withdraw_user_parent_name'
            )
        )
    );


    public function initInsert($source){

        $withdraw = parent::initInsert($source);

        $withdraw['withdraw_no'] = 'WD' . APP_TIME . rand(1000, 9999) . rand(1000, 9999);

        return $withdraw;
    }


    //在插入提现记录之前，要先保证币币已扣款
    public function insert($withdraw){

        $result = FALSE;

        $userCoinAsset = $this->asset_model->oneAssetByUserAndCoinAndPlate($withdraw['withdraw_user'], $withdraw['withdraw_coin'], 1);

        $this->db->trans_start();

        if ($userCoinAsset) {
            
            $userCoinAsset['asset_frozen'] = bcadd($userCoinAsset['asset_frozen'], $withdraw['withdraw_amount'], 8);

            $result = $this->asset_model->update($userCoinAsset);
        }else{

            $userCoinAsset = $this->asset_model->fieldsArray;

            $userCoinAsset['asset_plate'] = 1;
            $userCoinAsset['asset_user'] = $withdraw['withdraw_user'];
            $userCoinAsset['asset_coin'] = $withdraw['withdraw_coin'];
            $userCoinAsset['asset_frozen'] = $withdraw['withdraw_amount'];

            $result = $this->asset_model->insert($userCoinAsset);
        }

        if ($result) {
            
            $result = parent::insert($withdraw);
        }

        $this->db->trans_complete();

        return $result;
    }


    



    public function getTodayWithdraw(){

        $where = '`withdraw_time` >=' . strtotime(date('Y-m-d', time()) . ' 00:00:00');

        $order = '`withdraw_time` DESC';

        return $this->get(FALSE, FALSE, $where, $order);
    }


    public function oneWithdrawByNo($withdrawNo){

        $where = '`withdraw_no`=' . $this->db->escape($withdrawNo);

        return $this->one(FALSE, $where, $this->joinTemplate);
    }


    public function getUserWithdraw($pageIndex, $pageSize, $user_id, $coin_id = FALSE){

        $where = '`withdraw_user`=' . $user_id;

        if ($coin_id) {
            
            $where .= ' AND `withdraw_coin`=' . $coin_id;
        }

        $order = '`withdraw_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function countUserWithdraw($user_id, $coin_id = FALSE){

        $where = '`withdraw_user`=' . $user_id;

        if ($coin_id) {
            
            $where .= ' AND `withdraw_coin`=' . $coin_id;
        }

        return $this->count($where);
    }


    public function oneWithdraw($withdraw_id){

        $where = '`withdraw_id`=' . $withdraw_id;

        return $this->one(FALSE, $where, $this->joinTemplate);
    }


    public function getAllWithdraw($pageIndex = 1, $pageSize = 10, $userIdList = FALSE, $success = FALSE){

        $where = FALSE;

        if ($userIdList) {
            
            $where = '`withdraw_user` IN (' . implode(',', $userIdList) . ')';
        }

        if ($success) {
            
            if ($where) {
                
                $where .= ' AND `withdraw_status`=6';
            }else{

                $where = '`withdraw_status`=6';
            }
        }

        $order = '`withdraw_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order, $this->joinTemplate);
    }


    public function countAllWithdraw($userIdList = FALSE){

        $where = FALSE;

        if ($userIdList) {
            
            $where = '`withdraw_user` IN (' . implode(',', $userIdList) . ')';
        }

        return $this->count($where);
    }
}

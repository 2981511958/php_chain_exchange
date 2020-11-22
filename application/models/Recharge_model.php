<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 充值记录模型
 */
class Recharge_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_recharge';


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
        'recharge_id' => 0,
        'recharge_user' => 0,
        'recharge_coin' => 0,
        'recharge_time' => APP_TIME,
        'recharge_from_address' => '',
        'recharge_amount' => 0,
        'recharge_no' => '',
        'recharge_txid' => '',
        'recharge_trade_id' => '',
        'recharge_coin_symbol' => '',
        'recharge_memo' => '',
        'recharge_status' => 1
    );


    public function insert($recharge){

        $result = FALSE;

        $this->db->trans_start();

        $coin = $this->coin_model->one($recharge['recharge_coin']);

        if ($coin) {

            if ($assetResult['status']) {

                //写入资产记录
                $result = parent::insert($recharge);

                $recharge['recharge_id'] = $this->db->insert_id();

                if ($result) {

                    //尝试修改
                    if ($this->asset_log_model->insertRecharge($recharge)) {
                        
                        $result = TRUE;
                    }
                }
            }
        }

        $this->db->trans_complete();

        return $result;
    }


    //通用联表模板
    public $joinTemplate = array(

        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'recharge_user',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'recharge_user_name',
                'user_parent' => 'recharge_user_parent'
            )
        ),
        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'recharge_user_parent',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'recharge_user_parent_name',
            )
        )
    );


    public function oneRechargeByTxId($txId){

        $where = '`recharge_txid`=' . $this->db->escape($txId);

        return $this->one(FALSE, $where, $this->joinTemplate);
    }


    public function oneRechargeByTradeId($tradeId){

        $where = '`recharge_trade_id`=' . $this->db->escape($tradeId);

        return $this->one(FALSE, $where, $this->joinTemplate);
    }


    public function getTodayRecharge(){

        $where = '`recharge_time` >=' . strtotime(date('Y-m-d', time()) . ' 00:00:00');

        $order = '`recharge_time` DESC';

        return $this->get(FALSE, FALSE, $where, $order);
    }


    public function getUserRecharge($pageIndex, $pageSize, $user_id, $coin_id = FALSE){

        $where = '`recharge_user`=' . $user_id;

        if ($coin_id) {
            
            $where .= ' AND `recharge_coin`=' . $coin_id;
        }

        $order = '`recharge_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function countUserRecharge($user_id, $coin_id = FALSE){

        $where = '`recharge_user`=' . $user_id;

        if ($coin_id) {
            
            $where .= ' AND `recharge_coin`=' . $coin_id;
        }

        return $this->count($where);
    }


    public function oneRecharge($recharge_id){

        $where = '`recharge_id`=' . $recharge_id;

        return $this->one(FALSE, $where, $this->joinTemplate);
    }


    public function getAllRecharge($pageIndex = 1, $pageSize = 10, $userIdList = FALSE){

        $where = FALSE;

        if ($userIdList) {
            
            $where = '`recharge_user` IN (' . implode(',', $userIdList) . ')';
        }

        $order = '`recharge_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order, $this->joinTemplate);
    }


    public function countAllRecharge($userIdList = FALSE){

        $where = FALSE;

        if ($userIdList) {
            
            $where = '`recharge_user` IN (' . implode(',', $userIdList) . ')';
        }

        return $this->count($where);
    }
}

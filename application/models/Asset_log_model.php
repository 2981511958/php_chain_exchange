<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户资产流水模型
 */
class Asset_log_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_asset_log';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'asset_log_id' => 0,
        'asset_log_plate' => 1,
        'asset_log_user' => 0,
        'asset_log_coin' => 0,
        'asset_log_action' => 0,
        'asset_log_time' => APP_TIME,
        'asset_log_amount' => '0.00000000',
        'asset_log_remark' => '',
        'asset_log_status' => 1
    );


    //通用联表模板
    public $joinTemplate = array(

        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'asset_log_user',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'asset_log_user_name'
            )
        ),

        //与币种表联表
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'asset_log_coin',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询交易币种标识
                'coin_symbol' => 'asset_log_coin_symbol'
            )
        )
    );


    /**
     * 获取用户资产记录数量
     * @param  int     $userId 用户ID
     * @param  int     $coinId 币种ID
     * @param  int     $plate  版块ID
     * @return int             返回数量
     */
    public function countUserAssetLog($userId, $coinId = 0, $plate = 1){

        $where = '`asset_log_user`=' . $userId . ' AND `asset_log_plate`=' . $plate;

        if ($coinId) {
            
            $where .= ' AND `asset_log_coin`=' . $coinId;
        }

        return $this->count($where);
    }


    /**
     * 获取用户资产记录
     * @param  int     $pageIndex 当前页码
     * @param  int     $pageSize  每页数量
     * @param  int     $userId    用户ID
     * @param  int     $coinId    币种ID
     * @param  int     $plate     版块ID
     * @return array              返回资产记录
     */
    public function getUserAssetLog($pageIndex, $pageSize, $userId, $coinId = 0, $plate = 1){

        $where = '`asset_log_user`=' . $userId . ' AND `asset_log_plate`=' . $plate;

        if ($coinId) {
            
            $where .= ' AND `asset_log_coin`=' . $coinId;
        }

        $order = '`asset_log_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    /**
     * 插入提币记录
     * @param  array  $withdraw 提币对象
     * @return bool             返回操作结果，操作成功返回true，操作失败返回false
     */
    public function insertWithdraw($withdraw){

        $assetLog = $this->fieldsArray;

        $assetLog['asset_log_user'] = $withdraw['withdraw_user'];
        $assetLog['asset_log_coin'] = $withdraw['withdraw_coin'];
        $assetLog['asset_log_action'] = 2;
        $assetLog['asset_log_time'] = APP_TIME;
        $assetLog['asset_log_amount'] = $withdraw['withdraw_amount'];
        $assetLog['asset_log_remark'] = $withdraw['withdraw_id'];

        return $this->insert($assetLog);
    }


    /**
     * 插入充值记录
     * @param  array  $recharge 充值对象
     * @return bool             返回操作结果，操作成功返回true，操作失败返回false
     */
    public function insertRecharge($recharge){

        $assetLog = $this->fieldsArray;

        $assetLog['asset_log_user'] = $recharge['recharge_user'];
        $assetLog['asset_log_coin'] = $recharge['recharge_coin'];
        $assetLog['asset_log_action'] = 1;
        $assetLog['asset_log_time'] = APP_TIME;
        $assetLog['asset_log_amount'] = $recharge['recharge_amount'];
        $assetLog['asset_log_remark'] = $recharge['recharge_id'];

        return $this->insert($assetLog);
    }


    /**
     * 插入合约扣除后续费记录
     * @param  array  $dm 合约订单对象数组
     * @return bool       返回操作结果，操作成功返回true，操作失败返回false
     */
    public function insertDmFee($dm){

        $assetLog = $this->fieldsArray;

        $assetLog['asset_log_plate'] = 4;
        $assetLog['asset_log_user'] = $dm['dm_user'];
        $assetLog['asset_log_coin'] = $dm['dm_coin'];
        $assetLog['asset_log_action'] = 8;
        $assetLog['asset_log_time'] = time();
        $assetLog['asset_log_amount'] = '-' . $dm['dm_fee'];
        $assetLog['asset_log_remark'] = $dm['dm_id'];

        return $this->insert($assetLog);
    }


    /**
     * 插入合约结算记录
     * @param  array  $dm 合约订单对象数组
     * @return bool       返回操作结果，操作成功返回true，操作失败返回false
     */
    public function insertDmSettlement($dm){

        $assetLog = $this->fieldsArray;

        $assetLog['asset_log_plate'] = 4;
        $assetLog['asset_log_user'] = $dm['dm_user'];
        $assetLog['asset_log_coin'] = $dm['dm_coin'];
        $assetLog['asset_log_action'] = bccomp($dm['dm_profit'], 0) >= 0 ? 7 : 9;
        $assetLog['asset_log_time'] = time();
        $assetLog['asset_log_amount'] = $dm['dm_profit'];
        $assetLog['asset_log_remark'] = $dm['dm_id'];

        return $this->insert($assetLog);
    }
}

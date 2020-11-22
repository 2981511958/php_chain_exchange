<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 货币模型
 */
class Coin_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_coin';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'coin_id' => 0,
        'coin_name' => '',
        'coin_symbol' => '',
        'coin_info' => '',
        'coin_icon' => '',
        'coin_decimal' => 0,
        'coin_token_status' => 0,
        'coin_token_address' => '',
        'coin_recharge_status' => 0,
        'coin_recharge_min_amount' => 0,
        'coin_recharge_static_address_status' => 0,
        'coin_recharge_static_address' => '',
        'coin_withdraw_status' => 0,
        'coin_withdraw_amount' => 0.00,
        'coin_withdraw_fee' => 0.00,
        'coin_index' => 0,
        'coin_chain' => 0,
        'coin_contract' => '',
        'coin_memo' => '',
        'coin_otc' => '',
        'coin_otc_index' => 0,
        'coin_usd' => 0,
        'coin_status' => 1,
    );


    /**
     * 获取插入数据
     * @param  array  $source 货币对象数组
     * @return array          返回货币对象数组
     */
    public function initInsert($source){

        $coin = parent::initInsert($source);

        $coin['coin_symbol'] = strtoupper($coin['coin_symbol']);

        return $coin;
    }


    /**
     * 获取更新数据
     * @param  array  $source 货币对象数组
     * @return array          返回货币对象数组
     */
    public function initUpdate($source){

        $coin = parent::initUpdate($source);

        if (isset($coin['coin_symbol'])) {
            
            $coin['coin_symbol'] = strtoupper($coin['coin_symbol']);
        }

        return $coin;
    }


    /**
     * 后台获取所有币种列表
     * @return array 返回所有币种数组
     */
    public function getAllCoinList($order = 'coin_index'){

        $order = '`' . $order . '` DESC';

        return $this->get(FALSE, FALSE, FALSE, $order);
    }


    /**
     * 获取启用的币种列表
     * @return array 返回状态为启用的币种数组
     */
    public function getActiveCoinList(){

        $where = '`coin_status`=1';

        $order = '`coin_index` DESC';

        return $this->get(FALSE, FALSE, $where, $order);
    }


    /**
     * 通过货币名和货币标识获取货币信息
     * @param  string $coinName 货币对象
     * @param  bool             是否排除自己，可选，默认不排除
     * @return array            返回货币对象数组
     */
    public function oneCoinByNameOrSymbol($coin, $noSelf = FALSE){

        $where = '(`coin_symbol`=' . $this->db->escape($coin['coin_symbol']) . ')';

        if ($noSelf) {
            
            $where .= ' AND (`coin_id`<>' . $this->db->escape($coin['coin_id']) . ')';
        }

        return $this->one(FALSE, $where);
    }


    public function oneActiveCoinBySymbol($coin_symbol){

        $where = '`coin_status`=1 AND`coin_symbol`=' . $this->db->escape($coin_symbol);

        return $this->one(FALSE, $where);
    }


    public function oneActiveCoinByChainAndContract($coinChain, $coinContract){

        $where = '`coin_status`=1 AND`coin_chain`=' . $this->db->escape($coinChain) . ' AND `coin_contract`=' . $this->db->escape($coinContract);

        return $this->one(FALSE, $where);
    }


    public function getActiveCoinByChain($coinChain){

        $where = '`coin_status`=1 AND`coin_chain`=' . $this->db->escape($coinChain);

        return $this->get(FALSE, FALSE, $where);
    }
}

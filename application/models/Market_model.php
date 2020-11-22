<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 交易市场模型
 */
class Market_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_market';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'market_id' => 0,
        'market_plate' => 0,
        'market_stock_coin' => 0,
        'market_money_coin' => 0,
        'market_decimal' => 0,
        'market_min_amount' => 0.0001,
        'market_taker_fee' => 0.0001,
        'market_maker_fee' => 0.0001,
        'market_index' => 0,
        'market_dm_status' => 1,
        'market_dm_fee' => 0,
        'market_dm_min_amount' => 0,
        'market_status' => 1
    );


    /**
     * 通用联表模板
     */
    private $joinTemp =  array(

        //与币种表联表
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'market_stock_coin',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询交易币种标识
                'coin_symbol' => 'market_stock_symbol',
                'coin_icon' => 'market_stock_icon'
            )
        ),
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'market_money_coin',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询结算币种标识
                'coin_symbol' => 'market_money_symbol'
            )
        )
    );


    public function one($initId, $where = FALSE, $join = FALSE){

        return parent::one($initId, $where, $this->joinTemp);
    }


    /**
     * 后台获取交易市场列表
     * @return array              返回所有交易市场数组
     */
    public function getAllMarketList($market_money_coin = 0){

        $where = FALSE;

        if ($market_money_coin) {
            
            $where = '`market_money_coin`=' . $market_money_coin;
        }

        $order = '`market_index` DESC';

        return $this->get(FALSE, FALSE, $where, $order, $this->joinTemp);
    }


    public function getAllActiveMarketList(){

        $where = '`market_status`=1';

        $order = '`market_index` DESC';

        return $this->get(FALSE, FALSE, $where, $order, $this->joinTemp);
    }


    public function getAllActiveDmMarketList(){

        $where = '`market_status`=1 && `market_dm_status`=1 AND `market_money_coin`=' . $this->config->item('dm_money_coin');

        $order = '`market_index` DESC';

        return $this->get(FALSE, FALSE, $where, $order, $this->joinTemp);
    }


    public function getAllActiveMarketListByStockCoinId($stock = 0){

        $where = '`market_status`=1 AND `market_stock_coin`=' . $stock;

        $order = '`market_index` DESC';

        return $this->get(FALSE, FALSE, $where, $order, $this->joinTemp);
    }


    /**
     * 通过交易市场名和交易市场标识获取交易市场信息
     * @param  string $marketName 交易市场对象
     * @param  bool             是否排除自己，可选，默认不排除
     * @return array            返回交易市场对象数组
     */
    public function oneExistsMarketByStockMoney($market, $noSelf = FALSE){

        $where = '(`market_stock_coin`=' . $this->db->escape($market['market_stock_coin']) . ' AND `market_money_coin`=' . $this->db->escape($market['market_money_coin']) . ') OR (`market_stock_coin`=' . $this->db->escape($market['market_money_coin']) . ' AND `market_money_coin`=' . $this->db->escape($market['market_stock_coin']) . ')';

        if ($noSelf) {
            
            $where = '`market_id`<>' . $market['market_id'] . ' AND (' . $where . ')';
        }

        return $this->one(FALSE, $where, $this->joinTemp);
    }


    public function oneDmMarketByStock($market_stock_coin){

        $where = '`market_stock_coin`= ' . $market_stock_coin . ' AND `market_money_coin`=' . $this->config->item('dm_money_coin') . ' AND `market_dm_status`=1 AND `market_status`=1';

        return $this->one(FALSE, $where, $this->joinTemp);
    }
}

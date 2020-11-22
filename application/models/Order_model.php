<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 交易市场模型
 */
class order_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_order';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'order_id' => 0,
        'order_stock' => 0,
        'order_money' => 0,
        'order_no' => 0,
        'order_source' => '',
        'order_side' => 0,
        'order_type' => 0,
        'order_maker_fee' => 0,
        'order_ctime' => 0,
        'order_user' => 0,
        'order_ftime' => 0,
        'order_price' => 0,
        'order_count' => 0,
        'order_deal_stock' => 0,
        'order_taker_fee' => 0,
        'order_deal_money' => 0,
        'order_deal_fee' => 0,
        'order_left' => 0,
        'order_finished' => 0
    );


    /**
     * 通用联表模板
     */
    private $joinTemp =  array(

        //与用户表联表
        array(

            'table'         => 'ex_user',
            'on_left'       => 'order_user',
            'on_right'      => 'user_id',
            'fields'        => array(

                //查询交易币种标识
                'user_name' => 'order_user_name'
            )
        ),
        //与币种表联表
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'order_stock',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询交易币种标识
                'coin_symbol' => 'order_stock_symbol'
            )
        ),
        //与币种表联表
        array(

            'table'         => 'ex_coin',
            'on_left'       => 'order_money',
            'on_right'      => 'coin_id',
            'fields'        => array(

                //查询交易币种标识
                'coin_symbol' => 'order_money_symbol'
            )
        )
    );


    public function getAllOrder($orderType, $pageIndex, $pageSize){

        $where = '`order_finished`=' . $orderType;

        $order = '';

        if ($orderType == 1) {
            
            $order = '`order_ftime` DESC';
        }else{

            $order = '`order_ctime` DESC';
        }

        return $this->get($pageIndex, $pageSize, $where, $order, $this->joinTemp);
    }


    public function countAllOrder($orderType){

        $where = '`order_finished`=' . $orderType;

        return $this->count($where);
    }


    public function batchInsertDeal($dealArray){

        $result = FALSE;

        if (count($dealArray)) {
            
            $this->db->trans_start();

            $orderNoArray = array_column($dealArray, 'order_no');

            if ($this->deleteDealByNo($orderNoArray)) {
                
                if ($this->batchInsert($dealArray)) {
                    
                    $result = TRUE;
                }
            }

            $this->db->trans_complete();
        }

        return $result;
    }


    public function deleteDealByNo($orderNoArray){

        $result = FALSE;

        if (count($orderNoArray)) {
            
            $where = '`order_no` IN (' . implode(', ', $orderNoArray) . ')';

            if ($this->delete(FALSE, $where)) {
                
                $result = TRUE;
            }
        }

        return $result;
    }
}

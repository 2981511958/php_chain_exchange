<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 机器人模型
 */
class Robot_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_robot';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'robot_id' => 0,
        'robot_market' => 0,
        'robot_huobi' => 0,
        'robot_huobi_symbol' => 0,
        'robot_price_float' => 0,
        'robot_min_price' => 0,
        'robot_max_price' => 0,
        'robot_min_amount' => 0,
        'robot_max_amount' => 0,
        'robot_cron' => 0,
        'robot_cron_start' => 0,
        'robot_cron_end' => 0,
        'robot_cron_from' => 0,
        'robot_cron_target' => 0,
        'robot_status' => 0
    );


    public function oneRobotByMarketId($market_id, $noId = FALSE){

        $where = '`robot_market`=' . $market_id;

        if ($noId) {
            
            $where .= ' AND `robot_id`<>' . $noId;
        }

        return $this->one(FALSE, $where);
    }
}

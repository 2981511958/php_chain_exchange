<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 钱包模型
 */
class Wallet_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_wallet';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'wallet_id' => 0,
        'wallet_user' => 0,
        'wallet_value' => '',
        'wallet_chain' => 0
    );


    public function oneWallet($user_id, $wallet_chain){

        $where = "`wallet_user`=" . $user_id . " AND `wallet_chain`=" . $wallet_chain;

        return $this->one(FALSE, $where);
    }


    public function oneWalletByChainAndAddress($wallet_chain, $wallet_address){

        $where = '`wallet_chain`=' . $wallet_chain . ' AND `wallet_value`=' . $this->db->escape($wallet_address);

        return $this->one(FALSE, $where);
    }
}

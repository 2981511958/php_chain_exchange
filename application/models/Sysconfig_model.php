<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户模型
 */
class Sysconfig_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_sysconfig';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'sysconfig_id'      => 0,       /*配置ID*/
        'sysconfig_name'    => '',      /*配置名称，用作索引*/
        'sysconfig_value'   => '',      /*配置值*/
        'sysconfig_title'   => '',      /*配置标题*/
        'sysconfig_comment' => '',      /*配置标题*/
        'sysconfig_status'  => 0        /*状态，1为正常，0为失效*/
    );


    /**
     * 获取格式化的系统配置项
     * @return array 返回以配置名称为键的数组
     */
    public function getFormatSysconfig(){

        return array_column($this->getSysconfig(), 'sysconfig_value', 'sysconfig_name');
    }


    /**
     * 获取系统设置
     * @return array 返回以配置名称为索引的二维数组
     */
    public function getSysconfig(){

        $where = '`sysconfig_status`=1';

        return array_column($this->get(FALSE, FALSE, $where), NULL, 'sysconfig_name');
    }


    /**
     * 检查项目是否开启
     */
    public function checkAppSwitch(){

        if ($_SESSION['SYSCONFIG']['sysconfig_site_switch'] === '0') {
            
            
            exit();
        }
    }


    /**
     * 更新系统设置
     * @param  array  $sysconfigArr 每一行的 sysconfig_name => sysconfig_value 组成的数组
     * @return bool                 返回操作执行结果，更新成功返回TRUE，更新失败返回FALSE
     */
    public function updateSysconfig($sysconfig){

        $sysconfigArr = array();

        foreach ($sysconfig as $sysconfigName => $sysconfigValue) {
            
            $sysconfigTemp = array();
            $sysconfigTemp['sysconfig_name'] = $sysconfigName;
            $sysconfigTemp['sysconfig_value'] = $sysconfigValue;

            $sysconfigArr[] = $sysconfigTemp;
        }

        return $this->batchUpdate($sysconfigArr, 'sysconfig_name');
    }
}

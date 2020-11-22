<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 基础模型扩展类
 */
class MY_Model extends CI_Model {


    /**
     * 数据表名
     */
    public $table = '';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array();


    /**
     * 表字段数组
     */
    public $fields = array();


    /**
     * 构造函数
     */
    public function __construct(){

        parent::__construct();

        //初始化字段数组
        $this->fields = array_keys($this->fieldsArray);
    }


    /**
     * 从指定来源获取新实例
     * @param  array  $source 包含信息字段的来源数组
     * @return array          array(
     *                            字段...
     *                        )
     */
    public function initInsert($source){

        $init = array();

        foreach ($this->fieldsArray as $field => $default) {
            
            $init[$field] = isset($source[$field]) ? $source[$field] : $default;
        }

        return $init;
    }


    /**
     * 从指定来源获取需要更新的实例
     * @param  array  $source 包含信息字段的来源数组
     * @return array          array(
     *                            字段...
     *                        )
     */
    public function initUpdate($source){

        $init = array();

        foreach ($source as $key => $value) {
            
            if (in_array($key, $this->fields)) {
                
                $init[$key] = $value;
            }
        }

        return $init;
    }


    /**
     * 添加
     * @param  array $init array(
     *                         字段...
     *                     )
     * @return bool  返回操作结果，添加成功返回insert_id,添加失败返回false
     */
    public function insert($init){

        $result = $this->db->insert($this->table, $init);

        return $result ? $this->db->insert_id() : FALSE;
    }


    /**
     * 批量添加
     * @param  array  $initArray 多个init组成的数组
     * @return bool              返回操作结果，添加成功返回插入行数，添加失败返回false
     */
    public function batchInsert($initArray){

        return $this->db->insert_batch($this->table, $initArray) === FALSE ? FALSE : TRUE;
    }


    /**
     * 更新信息
     * @param  array  $init     array(
     *                              字段...                     
     *                          )
     * @param  array  $where    条件补充，关键词WHERE后的条件语句，可选，如无该参数或该参数为false，取主键作为条件
     * @return bool             返回操作结果，更新成功返回true，更新失败返回false
     */
    public function update($init, $where = FALSE){

        $result = FALSE;

        $sql = 'UPDATE `' . $this->table . '` SET';

        foreach ($this->fields as $field) {
            
            if (isset($init[$field])) {
                
                $sql .= ' `' . $field . '`=' . $this->db->escape($init[$field]) . ', ';
            }
        }

        //判断是否有where，没有取主键作为条件
        $sql = mb_substr($sql, 0, mb_strlen($sql) - 2) . ' WHERE ' . ($where === FALSE ? ('`' . $this->fields[0] . '`=' . $this->db->escape($init[$this->fields[0]])) : $where);

        $result = $this->db->query($sql);

        return $result;
    }


    /**
     * 批量修改
     * @param  array   $initArray 包含多个实例的数组，每一个实例的字段数与字段名必须一致
     * @param  string  $field     基准字段，即批量修改时以哪一个字段作为基准，可选，默认为主键
     * @return int                返回修改结果，修改成功返回true，修改失败返回false
     */
    public function batchUpdate($initArray, $field = FALSE){

        return $this->db->update_batch($this->table, $initArray, $field === FALSE ? $this->fields[0] : $field) === FALSE ? FALSE : TRUE;
    }


    /**
     * 删除
     * @param  int    $initId ID
     * @param  array  $where  条件补充，关键词WHERE后的条件语句，可选，如无该参数或该参数为false，取主键$initId作为条件
     * @return bool           返回操作结果，删除成功返回true，删除失败返回false
     */
    public function delete($initId, $where = FALSE){

        $sql = 'DELETE FROM `' . $this->table . '` WHERE ' . ($where === FALSE ? ('`' . $this->fields[0] . '`=' . $this->db->escape($initId)) : $where);

        return $this->db->query($sql);
    }


    /**
     * 批量删除
     * @param  array   $valueArr  一个字段的多个值组成的数组
     * @param  int     $field     指定$valueArr是哪个字段，可选，默认为主键
     * @return bollean            返回操作结果，删除成功返回true，删除失败返回false
     */
    public function batchDelete($valueArr, $field = FALSE){

        $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . ($field === FALSE ? $this->fields[0] : $field) . '` in (' . implode(', ', $valueArr) . ')';

        return $this->db->query($sql);
    }


    /**
     * 获取单个
     * @param  int    $initId ID
     * @param  array  $where  条件补充，关键词WHERE后的条件语句，可选，如无该参数或该参数为false，取主键$initId作为条件
     * @param  array  $join   补充联表查询，由多个数组组成，一个数组一个LEFT JOIN，格式如下：
     *                        array(
     *                            array(
     *                                'table'   => '右表名'
     *                                'left_on' => 'on条件的左边字段'
     *                                'right_on => 'on条件的右边字段'
     *                                'fields'  => array(    //需要查询右表的字段
     *                                    '原始字段' => '新字段名',
     *                                    ...
     *                                )
     *                            ),
     *                            ...
     *                        )
     * @return array          array(
     *                            字段...
     *                        )
     */
    public function one($initId, $where = FALSE, $join = FALSE){

        $sql = 'SELECT ' . $this->selectFieldsStr() . ' FROM `' . $this->table . '` WHERE ' . ($where === FALSE ? ('`' . $this->fields[0] . '`=' . $this->db->escape($initId)) : $where);

        if ($join) {

            $sql = $this->doJoin($sql, $join);
        }

        return $this->db->query($sql)->row_array();
    }


    /**
     * 获取数量
     * @param  array  $where   条件补充，关键词WHERE后的条件语句，可选
     * @return bool            返回操作结果，删除成功返回true，删除失败返回false
     */
    public function count($where = FALSE){

        $sql = 'SELECT COUNT(`' . $this->fields[0] . '`) AS `num` FROM `' . $this->table . '`';

        if ($where) {
            
            $sql .= ' WHERE ' . $where;
        }

        return (INT)$this->db->query($sql)->row_array()['num'];
    }


    /**
     * 获取列表
     * @param  int     $pageIndex 页码
     * @param  int     $pageSize  每页数量
     * @param  string  $where     补充条件，关键词WHERE后的条件语句
     * @param  string  $order     补充排序，关键词ORDER后的排序语句
     * @param  array   $join      补充联表查询，由多个数组组成，一个数组一个LEFT JOIN，格式如下：
     *                            array(
     *                                array(
     *                                    'table'   => '右表名'
     *                                    'left_on' => 'on条件的左边字段'
     *                                    'right_on => 'on条件的右边字段'
     *                                    'fields'  => array(    //需要查询右表的字段
     *                                        '原始字段' => '新字段名',
     *                                        ...
     *                                    )
     *                                ),
     *                                ...
     *                            )
     * @param  string  $queryFields     查询的字段，默认查询所有字段
     * @return array              返回若干对象组成的数组
     */
    public function get($pageIndex = FALSE, $pageSize = FALSE, $where = FALSE, $order = FALSE, $join = FALSE, $queryFields = FALSE){

        $sql = 'SELECT ' . ($queryFields === FALSE ? $this->selectFieldsStr() : $queryFields) . ' FROM `' . $this->table . '`';

        if ($where) {
            
            $sql .= ' WHERE ' . $where;
        }

        if ($order) {
            
            $sql .= ' ORDER BY ' . $order;
        }

        if ($pageIndex && $pageSize) {
            
            $sql .= ' LIMIT ' . (($pageIndex - 1) * $pageSize) . ', ' . $pageSize;
        }

        if ($join) {

            $sql = $this->doJoin($sql, $join);
        }

        return $this->db->query($sql)->result_array();
    }


    /**
     * 获取查询所有字段的SQL查询拼接
     * @param  string 补充表名
     * @param  array  补充字段列表，可选，如果为数组，则使用该数组中的字段，如果为FALSE，则使用默认字段列表中的字段
     * @return string 返回查询所有字段的SQL查询拼接
     */
    public function selectFieldsStr($tableName = '', $fieldsArr = FALSE){

        $result = '';

        if (! $fieldsArr) {
            
            $fieldsArr = $this->fields;
        }

        if ($tableName === '') {
            
            $result = '`' . implode('`, `', $fieldsArr) . '`';
        }else{

            $result = '`' . $tableName . '`.`' . implode('`, `' . $tableName . '`.`', $fieldsArr) . '`';
        }

        return $result;
    }


    /**
     * 根据JOIN联表配置，构建LEFT JOIN联表语句
     * @param  string $sourceSql  原始无JOIN的sql字符串
     * @param  array  $joinConfig JOIN配置数组
     * @return string             返回构建好JOIN的sql字符串
     */
    public function doJoin($sourceSql, $joinConfig, $fieldsArr = FALSE){

        $fieldsArr = $fieldsArr ? $fieldsArr : $this->fields;

        foreach ($joinConfig as $tableIndex => $join) {
            
            $tableName = 'TABLE' . $tableIndex;

            $joinSql = 'SELECT ' . $this->selectFieldsStr($tableName, $fieldsArr) . ', ';

            foreach ($join['fields'] as $field => $asName) {
                
                $joinSql .= '`' . $join['table'] . '`.`' . $field . '` AS `' . $asName . '`, ';
                $fieldsArr[] = $asName;
            }

            $sourceSql = mb_substr($joinSql, 0, mb_strlen($joinSql) - 2) . ' FROM (' . $sourceSql . ') AS `' . $tableName . '` LEFT JOIN `' . $join['table'] . '` ON `' . $tableName . '`.`' . $join['on_left'] . '`=`' . $join['table'] . '`.`' . $join['on_right'] . '`';
        }

        return $sourceSql;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文章内容模型
 */
class Article_model extends MY_Model {


    /**
     * 数据表名
     */
    public $table = 'ex_article';


    /**
     * 数据表字段缺省值数组，首个元素必须为主键字段
     */
    public $fieldsArray = array(

        //字段 => 缺省值
        'article_id' => 0,
        'article_type' => 0,
        'article_time' => APP_TIME,
        'article_title' => '',
        'article_content' => '',
        'article_token' => '',
        'article_lang' => '',
        'article_plate' => 0,
        'article_status' => 1,
    );


    public function initInsert($source){

        $article = parent::initInsert($source);

        $article['article_token']  = base64_encode(pwd_encode(APP_TIME . rand(100, 999) . rand(100, 999) . rand(100, 999)));

        return $article;
    }


    public function initUpdate($source){

        $article = parent::initUpdate($source);

        return $article;
    }


    public function countArticleByType($type = 2, $lang = FALSE){

        $where = '`article_type`=' . $type;

        if ($lang !== FALSE) {
            
            $where .= ' AND `article_lang`=' . $this->db->escape($lang);
        }

        return $this->count($where);
    }


    public function listArticleByType($pageIndex, $pageSize, $type = 2, $lang = FALSE){

        $where = '`article_type`=' . $type;

        if ($lang !== FALSE) {
            
            $where .= ' AND `article_lang`=' . $this->db->escape($lang);
        }

        $order = '`article_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function listActiveArticleByType($pageIndex, $pageSize , $type, $lang = FALSE){

        $where = '`article_type`=' . $type . ' AND `article_status`=1';

        if ($lang !== FALSE) {
            
            $where .= ' AND `article_lang`=' . $this->db->escape($lang);
        }

        $order = '`article_time` DESC';

        return $this->get($pageIndex, $pageSize, $where, $order);
    }


    public function countActiveArticleByType($type, $lang = FALSE){

        $where = '`article_type`=' . $type . ' AND `article_status`=1';

        if ($lang !== FALSE) {
            
            $where .= ' AND `article_lang`=' . $this->db->escape($lang);
        }

        return $this->count($where);
    }


    public function oneActiveArticleByToken($token, $lang = FALSE){

        $where = '`article_token`=' . $this->db->escape($token) . ' AND `article_status`=1';

        if ($lang !== FALSE) {
            
            $where .= ' AND `article_lang`=' . $this->db->escape($lang);
        }

        return $this->one(FALSE, $where);
    }
}

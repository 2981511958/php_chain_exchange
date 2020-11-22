<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 前台文章页面控制器
 */
class Article extends MY_Controller {


    private $type_symbol = array(

        1 => 'message',
        2 => 'terms',
        3 => 'support',
        4 => 'service',
        5 => 'tools'
    );


	/**
	 * 构造函数，初始化
	 */
	public function __construct(){

		parent::__construct();

		//载入模型
		$this->load->model('article_model');
	}


    public function index(){

        $this->message();
    }


    public function message($pageIndex = 1){

        $this->article_list(1, $pageIndex);
    }


    public function terms($pageIndex = 1){

        $this->article_list(2, $pageIndex);
    }


    public function support($pageIndex = 1){

        $this->article_list(3, $pageIndex);
    }


    public function service($pageIndex = 1){

        $this->article_list(4, $pageIndex);
    }


    public function tools($pageIndex = 1){

        $this->article_list(5, $pageIndex);
    }


    public function detail($article_token = 0){

        $article = $this->article_model->oneActiveArticleByToken($article_token, $_SESSION['_language']);

        if ($article && $article['article_status']) {
            
            $data = array(

                'article_type' => $article['article_type'],
                'article' => $article,
                'type_symbol' => $this->type_symbol[$article['article_type']]
            );

            $this->load->view($this->viewPath . '/article/article_detail', $data);
        }else{

            $this->message();
        }
    }


    private function article_list($article_type, $pageIndex = 1){

        $pageSize = 20;

        if (isset($this->config->item('article_type')[$article_type])) {

            $articleCount = $this->article_model->countActiveArticleByType($article_type, $_SESSION['_language']);

            $pagingInfo = getPagingInfo($articleCount, $pageIndex, $pageSize, $this->config->item('home_page'), base_url('/article/' . $this->type_symbol[$article_type] . '/'));
            
            $articleList = $this->article_model->listActiveArticleByType($pagingInfo['pageindex'], $pageSize, $article_type, $_SESSION['_language']);

            $data = array(

                'article_type' => $article_type,
                'articleList' => $articleList,
                'pagingInfo' => $pagingInfo,
                'pageSize' => $pageSize,
                'articleCount' => $articleCount
            );

            $this->load->view($this->viewPath . '/article/article_list', $data);
        }
    }
}

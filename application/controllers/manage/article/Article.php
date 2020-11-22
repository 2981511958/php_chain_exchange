<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台文章控制器
 */
class Article extends CI_Controller {


	/**
	 * 每页数量
	 */
	private $pageSize = 20;


	/**
	 * 构造函数
	 */
	public function __construct(){

		parent::__construct();

		//载入模型
		$this->load->model('article_model');
	}


	/**
	 * 文章页面
	 */
	public function index($article_type = 1, $lang = FALSE, $pageIndex = 1){

		$langList = $this->config->item('_language_list');

		if ($lang === FALSE) {
			
			$lang = $this->config->item('_lang');
		}

		$articleCount = $this->article_model->countArticleByType($article_type, $lang);

		$pagingInfo = getPagingInfo($articleCount, $pageIndex, $this->pageSize, $this->config->item('manage_page'), base_url('/manage/article/article/index/' . $article_type . '/' . $lang . '/'));

		$articleList = $this->article_model->listArticleByType($pagingInfo['pageindex'], $this->pageSize, $article_type, $lang);


		$data = array(

			'pagingInfo' => $pagingInfo,
			'articleList'	=> $articleList,
			'article_type' => $article_type,
			'langList' => $langList,
			'lang' => $lang
		);

		$this->load->view('manage/article/article_index', $data);
	}


	/**
	 * 添加文章
	 */
	public function add(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			//初始化文章信息
			$article = $this->article_model->initInsert($this->input->post());

			//尝试写入
			if ($this->article_model->insert($article)) {
				
				$result['status'] = TRUE;
				$result['message'] = '添加成功';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 编辑文章
	 */
	public function edit(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$article = $this->article_model->initUpdate($this->input->post());

			//尝试修改
			if ($this->article_model->update($article)) {
				
				$result['status'] = TRUE;
				$result['message'] = '修改成功';
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 获取单个文章的信息
	 */
	public function one(){

		if ($_POST) {

			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试',
				'article'	=> array()
			);
			
			$articleId = $this->input->post('article_id');

			if ($articleId) {

				$article = $this->article_model->one($articleId);

				if ($article) {
					
					$result['status'] = TRUE;
					$result['message'] = '数据读取成功';
					$result['article'] = $article;
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}


	/**
	 * 删除文章
	 */
	public function delete(){

		if ($_POST) {
			
			$result = array(

				'status' 	=> FALSE,
				'message' 	=> '网络繁忙，请稍后再试'
			);

			$articleId = $this->input->post('article_id');

			if ($articleId) {

				//尝试删除
				if ($this->article_model->delete($articleId)) {
					
					$result['status'] = TRUE;
					$result['message'] = '删除成功';
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
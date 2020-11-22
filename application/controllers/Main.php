<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * 前台首页控制器
	 */
    public function index(){

    	$this->load->model('market_model');
        $this->load->model('article_model');

    	$marketGroup = array();
        $marketSymbolList = array();

    	$marketList = $this->market_model->getAllActiveMarketList();

        if ($marketList && count($marketList)) {

            foreach ($marketList as $marketItem) {
                
                $marketGroup[$marketItem['market_money_symbol']][] = $marketItem;
                $marketSymbolList[] = $marketItem['market_stock_symbol'] . $marketItem['market_money_symbol'];
            }
            
            $marketList = array_slice($marketList, 0, 6);
        }

        $newsList = $this->article_model->listActiveArticleByType(1, 3, 1, $_SESSION['_language']);
        $imageList = $this->article_model->listActiveArticleByType(1, 10, 0, $_SESSION['_language']);

    	$data = array(

            'marketGroup' => $marketGroup,
    		'marketList' => $marketList,
            'newsList' => $newsList,
            'marketSymbolList' => $marketSymbolList,
            'imageList' => $imageList
    	);

    	$this->load->view($this->viewPath . '/index', $data);
    }
}

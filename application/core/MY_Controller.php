<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 基础模型扩展类
 */
class MY_Controller extends CI_Controller {


    /**
     * 视图文件目录名，用来区分PC和手机的视图文件目录，默认PC
     * @var string
     */
    public $viewPath = 'front';

    public $android = FALSE;


	/**
	 * 构造函数,初始化
	 */
    public function __construct(){

        parent::__construct();

        if ($_GET) {
            
            foreach ($_GET as $key => $value) {
                
                $_GET[$key] = trim($this->security->xss_clean($this->input->get($key)));
            }
        }

        if ($_POST) {
            
            foreach ($_POST as $key => $value) {
                
                $_POST[$key] = trim($this->security->xss_clean($this->input->post($key)));
            }
        }

        //判断设备
        $this->load->library('user_agent');

        if ($this->agent->is_mobile()) {
            
            //如果手机端，使用移动视图
            $this->viewPath = 'mobile';

            //安卓需要单独标识
            if ($this->agent->platform() == 'Android') {
                
                $this->android = TRUE;
            }
        }

        //载入系统设置模型
        $this->load->model('sysconfig_model');
        //获取系统设置,赋给变量
        $sysConfig = $this->sysconfig_model->getFormatSysconfig();

        //判断系统设置是否获取成功，如没有获取成功则中断执行
        if ($sysConfig && count($sysConfig)) {
        	
        	$_SESSION['SYSCONFIG'] = $sysConfig;
        }

        //当前语言
        if (! (isset($_SESSION['_language']) && isset($this->config->item('_language_list')[$_SESSION['_language']]))) {
            
            $_SESSION['_language'] = $this->config->item('_lang');
        }

        //载入语言文件
        $this->lang->load('application', $_SESSION['_language']);
        $this->load->helper('language');
    }
}


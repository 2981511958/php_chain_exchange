<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * 前台公共控制器
 */
class Common extends MY_Controller {


    public function __construct(){

        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('article_model');
    }


    /**
     * 生成并获取文字验证码
     * @param  integer $_width  宽
     * @param  integer $_height 高
     */
    public function validate($_width = 0, $_height = 0){

        $this->load->library("validatecode");
        $this->validatecode->doimg($_width, $_height);

        $_SESSION["USER_VALIDATE"] = $this->validatecode->getCode();
    }


    //更换语言
    public function change_language(){

        if ($_POST && isset($_POST['_language']) && in_array($_POST['_language'], array_keys($this->config->item('_language_list')))) {
            
            $_SESSION['_language'] = $_POST['_language'];
        }
    }


    /**
     * 发送短信验证码
     */
    public function user_sms_validate(){

        if ($_POST) {
            
            $result = array(

                "status" => FALSE,
                "message" => lang('controller_common_user_sms_validate_1')
            );

            $this->user_model->checkLogin();

            if ($this->user_model->checkImageValidate($_POST["validate"])) {
                
                $phone = $_SESSION["USER"]["USER_PHONE"];

                $areaCode = $_SESSION["USER"]["USER_PHONE_AREA"];

                $this->load->model("sms_model");

                if ($this->sms_model->smsValidate($phone, $areaCode)) {
                    
                    $result["status"] = TRUE;
                    $result["message"] = lang('controller_common_user_sms_validate_2');
                }
            }else{

                $result["message"] = lang('controller_common_user_sms_validate_3');
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 发送短信验证码
     */
    public function sms_validate(){

        if ($_POST) {
            
            $result = array(

                "status" => FALSE,
                "message" => lang('controller_common_sms_validate_1')
            );

            if ($this->user_model->checkImageValidate($_POST["validate"])) {
                
                $phone = $_POST["phone"];
                $areaCode = $_POST['area_code'];

                if ($phone != '' && $areaCode != '') {
                    
                    $this->load->model("sms_model");

                    if ($this->sms_model->smsValidate($phone, $areaCode)) {
                        
                        $result["status"] = TRUE;
                        $result["message"] = lang('controller_common_sms_validate_2');
                    }
                }else{

                    $result["message"] = lang('controller_common_sms_validate_3');
                }
            }else{

                $result["message"] = lang('controller_common_sms_validate_4');
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 发送邮箱验证码
     */
    public function user_email_validate(){

        if ($_POST) {
            
            $result = array(

                "status" => FALSE,
                "message" => lang('controller_common_user_email_validate_1')
            );

            $this->user_model->checkLogin();

            if ($this->user_model->checkImageValidate($_POST["validate"])) {
                
                $email = $_SESSION["USER"]["USER_EMAIL"];

                if (checkEmailFomat($email)) {
                    
                    
                }else{

                    $result["message"] = lang('controller_common_user_email_validate_3');
                }
            }else{

                $result["message"] = lang('controller_common_user_email_validate_4');
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 发送邮箱验证码
     */
    public function email_validate(){

        if ($_POST) {
            
            $result = array(

                "status" => FALSE,
                "message" => lang('controller_common_email_validate_1')
            );

            if ($this->user_model->checkImageValidate($_POST["validate"])) {
                
                $email = $_POST["email"];

                if (checkEmailFomat($email)) {

                }else{

                    $result["message"] = lang('controller_common_email_validate_3');
                }
            }else{

                $result["message"] = lang('controller_common_email_validate_4');
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 异步上传文件
     * 如果有多个文件同时上传，只要有一个上传失败，则返回失败
     * @param  string $dir 需要保存的分类文件夹名称
     */
    public function upload($dir = ""){

        if ($_FILES && count($_FILES)) {

            $result = array(

                "status"    => FALSE,
                "message"   => '',
                "filename"  => array()
            );
            
            foreach ($_FILES as $file) {
                
                if ($file["error"] == 0) {

                    $fileStr = file_get_contents($file['tmp_name']);

                    if ($this->security->xss_clean($fileStr, TRUE) === FALSE) {
                        
                        $fileName = $this->config->item("upload_path") . ($dir == "" ? "" : ('/' . $dir)) . autoSavePath(APP_TIME, getFileType($file["name"]));

                        if (uploadFile($file, FCPATH . '/' . $fileName)) {
                            
                            $result["status"]       = TRUE;
                            $result["message"]      = lang('controller_common_upload_1');
                            $result["filename"][]   = $fileName;
                        }else{

                            $result["status"] = FALSE;
                            $result["message"] = lang('controller_common_upload_2') . " [ " . $file["name"] . " ] " . lang('controller_common_upload_3');
                            break;
                        }
                    }
                }
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台公共控制器
 */
class Common extends CI_Controller {


	/**
	 * 生成并获取文字验证码
	 */
	public function validate(){

	    $this->load->library('validatecode');
	    $this->validatecode->doimg();

	    $_SESSION['validate'] = $this->validatecode->getCode();
	}


	/**
	 * 异步上传文件
	 * 如果有多个文件同时上传，只要有一个上传失败，则返回失败
	 * @param  string $dir 需要保存的分类文件夹名称
	 */
	public function upload($dir = ''){

		if ($_FILES && count($_FILES)) {

			$result = array(

				'status' 	=> FALSE,
				'message'	=> '文件上传失败，请稍后再试',
				'filename' 	=> array()
			);
			
			foreach ($_FILES as $file) {
				
				if ($file['error'] == 0) {

					$fileName = $this->config->item('upload_path') . ($dir == '' ? '' : ('/' . $dir)) . autoSavePath(APP_TIME, getFileType($file['name']));

					if (uploadFile($file, FCPATH . '/' . $fileName)) {
						
						$result['status'] 		= TRUE;
						$result['message']		= '文件上传成功';
						$result['filename'][] 	= $fileName;
					}else{

						$result['status'] = FALSE;
						$result['message'] = '文件 [ ' . $file['name'] . ' ] 上传失败';
						break;
					}
				}
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
}
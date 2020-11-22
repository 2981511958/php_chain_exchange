<?php

/**
 * 依赖PHPMailer的邮件发送类
 * @author HuangYu
 */
class SendEmail{


	/**
	 * 存放phpmailer实例的容器
	 * @var object
	 */
	private $mail 		= null;

	/**
	 * 状态，在发送之前判断邮件是否检测通过
	 * @var boolean
	 */
	private $checkMail	= false;

	/**
	 * 当邮件不支持html时备用显示，可以省略
	 * @var string
	 */
	private $altBody 	= "To view the message, please use an HTML compatible email viewer!";


	/**
	 * 构造函数
	 * 在实例化类的时候就引入核心类文件
	 */
	public function __construct(){

		//主要功能类
		require dirname(__FILE__) . '/PHPMailer/class.phpmailer.php';

		//邮件接收类，暂时没有做pop接收邮件，所以暂时先不引入pop协议文件
		// require dirname(__FILE__) . '/phpmailer/class.pop3.php';

		//邮件发送类
		require dirname(__FILE__) . '/PHPMailer/class.smtp.php';
	}


	/**
	 * 创建PHPMailer实例
	 */
	private function createMail(){

		if (!($this->mail)) {
			
			$this->mail = new PHPMailer(true);
		}
	}


	/**
	 * 配置邮件
	 * @param  boolean $openSSL  是启用SSL传输通道，默认启用
	 * @param  boolean $isSmtp   是否使用SMTP服务器，默认使用
	 * @param  string  $charSet  邮件的编码，默认UTF-8
	 * @param  integer $wordWrap 设置每行字符串的长度，默认80
	 * @param  boolean $isHtml   设置邮件内容是否是HTML代码，默认是
	 * @return Void
	 */
	public function mailConfig($openSSL = true, $isSmtp = true, $charSet = 'UTF-8', $wordWrap = 80, $isHtml = true){

		$this->createMail();

		$this->mail->SMTPDebug  = 1;

		if ($isSmtp) {
			
			//使用SMTP服务器
			$this->mail->IsSMTP();

			//开启SMTP认证
			$this->mail->SMTPAuth = true;
		}

		//设置邮件的字符编码，这很重要，不然中文乱码
		$this->mail->CharSet = $charSet; 
		
		//部分邮箱需要开启SSL传输
		if ($openSSL) {
			
			$this->mail->SMTPSecure = "ssl";
		}
		
		// 设置每行字符串的长度
		$this->mail->WordWrap = $wordWrap; 

		//设置内容是否是HTML代码
		$this->mail->IsHTML($isHtml);
	}


	/**
	 * 邮件主要内容
	 * @param  String  $mailTitle     邮件主题
	 * @param  String  $mailBody      邮件内容，可以是HTML代码
	 * @param  String  $mailFile      附件，如果只有一个附件，直接传入在服务器本地的绝对地址字符串就可以了，
	 *                                如果是多个附件，则传入多个绝对地址字符串组成的数组即可，如果没有附件，传入False
	 * @param  String  $userName      发件人帐户名
	 * @param  String  $pwd           发件人帐户密码
	 * @param  Int     $serverPort    发件服务器端口
	 * @param  String  $serverHost    发件服务器地址
	 * @param  String  $targetAddress 收件人地址，如果是一个收件人，传入收件邮箱地址字符串，
	 *                                如果是多个收件人，传入多个邮箱地址组成的数组
	 * @param  boolean $replyTo       快速回复人，由 地址 => 名称 格式的数组组成，默认False，回复所有收件人
	 * @param  String  $from          邮件来源地址，默认False，取发件人帐户名
	 * @param  String  $fromName      邮件来源名称，默认False，取发件人帐户名
	 * @param  String  $altBody       当邮件不支持html时备用显示，默认False，取类内部变量$altBody
	 * @return Void
	 */
	public function mail($mailTitle, $mailBody, $mailFile, $userName, $pwd, $serverPort, $serverHost, $targetAddress, $replyTo = false, $from = false, $fromName = false, $altBody = false){

		$this->createMail();

		//配置服务器信息
		$this->mail->Port       = $serverPort;
		$this->mail->Host       = $serverHost;
		$this->mail->Username   = $userName;
		$this->mail->Password   = $pwd;

		//设置收件人
		if (is_array($targetAddress)) {
			
			foreach ($targetAddress as $address) {
				
				$this->mail->AddAddress($address);
			}
		}else{

			$this->mail->AddAddress($targetAddress);
		}

		//设置快速回复对象
		if ($replyTo) {
			
			if (is_array($replyTo)) {
				
				foreach ($replyTo as $reply) {

					if (is_array($reply)) {
						
						$this->mail->AddReplyTo($reply[0], $reply[1]);
					}else{

						$this->mail->AddReplyTo($replyTo[0], $replyTo[1]);
						break;
					}
				}
			}
		}else{

			$this->mail->AddReplyTo($userName, $userName);
		}

		//设置邮件来源
		$this->mail->From     = $from ? $from : $userName;
		$this->mail->FromName = $fromName ? $fromName : $userName;

		//设置邮件内容及主题
		$this->mail->Subject  = $mailTitle;
		$this->mail->Body 	= $mailBody;

		//当邮件不支持html时备用显示，可以省略
		$this->mail->AltBody  = $altBody ? $altBody : $this->altBody; 

		//添加附件
		if ($mailFile) {
			
			if (is_array($mailFile)) {
				
				foreach ($mailFile as $file) {
					
					$this->mail->AddAttachment($file);
				}
			}else{

				$this->mail->AddAttachment($mailFile);
			}
		}

		$this->checkMail = true;
	}


	/**
	 * 发送邮件，在确认对邮件内容和邮件都进行过配置后，可以发送邮件
	 * @return Boolean 返回邮件的发送结果，发送成功返回true，发送失败返回false
	 */
	public function sendMail(){

		$pass = false;

		if ($this->mail) {
			
			if ($this->checkMail) {
				
				$pass = $this->mail->Send();
			}else{

				$pass = false;
			}
		}else{

			$pass = false;
		}

		$this->mail = null;
		return $pass;
	}
}
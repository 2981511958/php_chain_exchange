<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0035)http://cp.yunhosting.com//index.asp -->
<html xmlns="http://www.w3.org/1999/xhtml"><style type="text/css" id="__360se6_success_css"></style><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>会员登录</title>

<link href="<?php echo base_url('/static/manage/login'); ?>/style.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url('/static/manage/login'); ?>/jquery.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo base_url('/static/layui'); ?>/layui.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
$ = jQuery;
function changeAuthCode() {
	var num = 	new Date().getTime();
	var rand = Math.round(Math.random() * 10000);
	num = num + rand;
	$('#ver_code').css('visibility','visible');
	if ($("#vdimgck")[0]) {
		$("#vdimgck")[0].src = "<?php echo base_url('/manage/common/validate'); ?>?tag=" + num;
	}
	return false;	
}
</script>
</head>

<body>
<div class="page">
  <div class="left">
  <img src="<?php echo base_url('/static/manage/login'); ?>/left.jpg" width="450" height="350"> 
  <div class="l_txt">
  	<h1>后台管理登录入口</h1>
  	<p>输入您的账号以及密码，轻松管理交易所。</p>
  </div>
  </div>
  <div class="right">
  	<h1>交易所管理系统</h1>
    <div class="form_box">
   	  <form>
	  
       	  <div class="td_txt">输入您的用户名</div>
          <div class="txt_input"><input name="admin_name" type="text" class="form_01" placeholder="Usename"/></div>
		 
		
	
		 <div class="mm">输入您的密码</div>
          <div class="txt_input"><input name="admin_password" type="password" placeholder="Password" class="form_01"></div>
          <div class="td_txt">
		     </div>
			 
			   <div class="yzm">
		<div class="mm">输入验证码</div>
		<input id="vdcode" type="text" name="validate" class="yzm-1"/><img id="vdimgck" align="absmiddle" onClick="changeAuthCode();" style="cursor: pointer;" alt="看不清？点击更换" src="<?php echo base_url('/manage/common/validate'); ?>"/><a href="#" onClick="changeAuthCode();" style="color:#666;">看不清楚</a>

		  </div>
		  
		  
		
          <div class="txt_input"><input name="提交" type="submit" value="登录" class="form_02"></div>
		<div class="txt_input"><font style="color:#ff0000"></font></div>
        </form>
    </div>
    <div class="help_box">
   	 
    </div>
  </div>
  <div class="clear"></div>
</div>

<script type="text/javascript">
	
	//JavaScript代码区域
	layui.use(['element', 'jquery', 'form', 'layer', 'laydate', 'upload'], function () {

	    var layer   = layui.layer;
	    var layuiLoadIndex = 0;

	    $('form').submit(function(){

	    	var admin_name = $('[name=admin_name]').val();
	    	var admin_password = $('[name=admin_password]').val();
	    	var validate = $('[name=validate]').val();

	    	if (admin_name=='') {

	    		layer.msg('用户名不能为空');
	    		return false;
	    	}

	    	if (admin_password=='') {

	    		layer.msg('密码不能为空');
	    		return false;
	    	}

	    	if (validate=='') {

	    		layer.msg('验证码不能为空');
	    		return false;
	    	}

	    	layuiLoadIndex = layer.load();

	    	$.ajax({

	    	    url: '/manage/main/login',
	    	    type: 'post',
	    	    data: {

	    	        'admin_name' : admin_name,
	    	        'admin_password' : admin_password,
	    	        'validate' : validate
	    	    },
	    	    dataType: 'json',
	    	    success: function (data) {
	    	        
	    	        layer.close(layuiLoadIndex);
	    	        layer.msg(data.message);

	    	        if (data.status) {

	    	            setTimeout(function(){

	    	            	window.parent.location.href = '/manage/main';
	    	            }, 1000);
	    	        }
	    	    },
	    	    error: function(){
	    	        
	    	        layer.close(layuiLoadIndex);
	    	        layer.msg('网络繁忙，请稍后再试');
	    	    }
	    	});

	    	return false;
	    });

	});

</script>

</body></html>
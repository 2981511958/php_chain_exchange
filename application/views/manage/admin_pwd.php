<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/manage'); ?>/style/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/manage'); ?>/style/style.css" />

    <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
    
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('static/manage'); ?>/js/css3.js"></script>
    <script src="<?php echo base_url('static/manage'); ?>/js/html5.js"></script>
    <![endif]-->

    <script src="<?php echo base_url('static/manage'); ?>/js/common.js"></script>
    <script src="<?php echo base_url('static/layui'); ?>/layui.js"></script>
</head>
<body>

    <div class="pagebox">
        
        <div class="pagetitle layui-bg-black">
            修改密码
        </div>

        <style type="text/css">

            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
            .layui-table .editbtn{ position: absolute; top: 5px; right: 90px; }
            .layui-table .delbtn{ position: absolute; top: 5px; right: 10px; }

            .previewitem{ float: left; margin: 10px; width: 110px; height: 110px; border: #CCC solid 1px; text-align: center; vertical-align: middle; position: relative; cursor: pointer; display: flex; align-items: center; justify-content: center; }
            .previewitem:hover{ border: #000 solid 1px; }
            .previewitem img{ max-height: 110px; max-width: 110px; }
            .previewitem .del{ position: absolute; right: 15px; bottom: 5px; }
            .previewitem .modify{ position: absolute; left: 15px; bottom: 5px; margin-left: 0px; }

            .layui-bg-gray{ background: #CCC !important; }
        </style>

        <div class="mainbox">

            <div class="layui-form layui-form-pane">

                <div class="layui-form-item">
                    <label class="layui-form-label">原密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="admin_password_old" placeholder="请输入原密码" class="layui-input" autocomplete='new-password'>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">新密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="admin_password" placeholder="请输入新密码" class="layui-input" autocomplete='new-password'>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">确认新密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="admin_password_check" placeholder="请输入确认新密码" class="layui-input" autocomplete='new-password'>
                    </div>
                </div>

                <button class="layui-btn sublimtbtn">提交修改</button>
            </div>
        </div>
    </div>
    
    <script>
      
        //JavaScript代码区域
        layui.use(['element', 'jquery', 'form', 'layer', 'laydate', 'upload'], function () {

            var element = layui.element;
            var form    = layui.form;
            var layer   = layui.layer;
            var $       = layui.$;

            var layuiOpenIndex = 0;
            var layuiLoadIndex = 0;
            var uploadsIndex = 0;
            var thisUploadsIndex = 0;

            $('.sublimtbtn').click(function(){

                var admin_password_old = $('[name=admin_password_old]').val();
                var admin_password = $('[name=admin_password]').val();
                var admin_password_check = $('[name=admin_password_check]').val();

                if (admin_password_old == '' || admin_password == '' || admin_password_check == '') {

                    layer.msg('密码不能为空');
                    return false;
                }

                if (admin_password != admin_password_check) {

                    layer.msg('两次输入的新密码不一致');
                    return false;
                }

                layuiLoadIndex = layer.load();

                $.ajax({

                    url: '/manage/admin/modifypwd',
                    type: 'post',
                    data: {

                        'admin_password_old' : admin_password_old,
                        'admin_password' : admin_password,
                        'admin_password_check' : admin_password_check
                    },
                    dataType: 'json',
                    success: function (data) {
                        
                        layer.close(layuiLoadIndex);
                        layer.msg(data.message);

                        if (data.status) {

                            setTimeout(function(){

                                window.parent.location.href = '/manage/main/logout';
                            }, 1000);
                        }
                    },
                    error: function(){
                        
                        layer.close(layuiLoadIndex);
                        layer.msg('网络繁忙，请稍后再试');
                    }
                });
            });
        });
    </script>
</body>
</html>

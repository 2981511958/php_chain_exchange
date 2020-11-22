<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_forgot_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel='icon' href='/favicon.ico' type='image/x-ico' />

        <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/front'); ?>/style/style.css" />

        <!--[if lt IE 9]>
        <script src="<?php echo base_url('static/front'); ?>/js/css3.js"></script>
        <script src="<?php echo base_url('static/front'); ?>/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php $this->load->view('front/header'); ?>

        <div class="body_box">

            <style type="text/css">
                
                .body_box .register_box{ width: 400px; margin: 50px auto; border-radius: 5px; background: #1f2126; padding: 0px 50px 40px 50px; }
                .body_box .register_box .box_title{ line-height: 100px; font-size: 20px; text-align: center; color: #d5def2; }
                .body_box .register_box .register_type_tab{ border-bottom: #3f4254 solid 2px; height: 30px; }
                .body_box .register_box .register_type_tab .tab_item{ float: left; font-size: 14px; color: #a7b7c7; line-height: 30px; text-align: center; margin-right: 20px; cursor: pointer; transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; }
                .body_box .register_box .register_type_tab .tab_item:hover{ color: #d5def2; }
                .body_box .register_box .register_type_tab .tab_item.active{ color: #d5def2; line-height: 30px; border-bottom: #357ce1 solid 2px; }

                .body_box .register_box .register_type_box{ display: none; }
                .body_box .register_box .register_type_box.active{ display: block; }
                .body_box .register_box .register_type_box .field_line_item{ margin-top: 20px; }

                .body_box .register_box .register_type_box .field_line_item .input_ele_box{ position: relative; }
                .body_box .register_box .register_type_box .field_line_item .input_ele_box .input_ele{ display: block; line-height: 20px; height: 20px; padding: 25px 15px 8px 15px; border: #697080 solid 1px; border-radius: 5px; caret-color: #357ce1; color: #d5def2; background: #191a1f; width: calc(100% - 32px); z-index: 1; }
                .body_box .register_box .register_type_box .field_line_item .input_ele_box .input_ele_label{ height: 20px; font-size: 12px; color: #697080; position: absolute; left: 15px; top: 20px; z-index: 2; cursor: text; }
                .body_box .register_box .register_type_box .field_line_item .input_ele_box .input_ele:focus{ border-color: #357ce1; }
                .body_box .register_box .register_type_box .field_line_item .input_ele_box .input_ele:focus+label{ top: 8px; }
                .body_box .register_box .register_type_box .field_line_item .input_ele_box .input_ele:not([value=""])+label{ top: 8px; }

                .body_box .register_box .register_type_box .field_line_item .phone_area_num{ float: left; width: calc((100% - 14px) / 2 - 2px); height: 53px; text-align: center; border: #697080 solid 1px; border-radius: 5px; color: #d5def2; font-size: 14px; background: #191a1f; }

                .body_box .register_box .register_type_box .field_line_item .phone_area_num .layui-unselect{ height: 51px; line-height: 51px; text-align: center; background: #191a1f; border: #191a1f solid 1px !important; border-radius: 5px !important; color: #d5def2; }
                .body_box .register_box .register_type_box .field_line_item .phone_area_num .layui-unselect dl{ background: #191a1f; border-color: #697080; width: calc(100% + 4px); left: -2px; }
                .body_box .register_box .register_type_box .field_line_item .phone_area_num .layui-unselect dl dd:hover{ background: rgba(53, 124, 225, 0.21); }
                .body_box .register_box .register_type_box .field_line_item .phone_area_num .layui-unselect dl dd.layui-this{ background: #3B97E9; }
                .body_box .register_box .register_type_box .field_line_item .phone_area_num .layui-select-title i{ color: #697080; }

                .body_box .register_box .register_type_box .field_line_item .phone_num_box{ float: right; width: calc((100% - 14px) / 2 + 2px); }
                .body_box .register_box .register_type_box .field_line_item .phone_validate_box{ float: left; width: calc((100% - 14px) / 2); }
                .body_box .register_box .register_type_box .field_line_item .phone_validate_code{ display: block; float: right; width: calc((100% - 14px) / 2); border: #697080 solid 1px; border-radius: 5px; cursor: pointer; }
                .body_box .register_box .register_type_box .field_line_item .send_btn{ background-color: #357ce1; line-height: 55px; height: 55px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; border-radius: 5px; float: right; width: calc((100% - 14px) / 2 + 2px); }
                .body_box .register_box .register_type_box .field_line_item .send_btn.off{ cursor: not-allowed; background: #4E7FC6 !important; }
                .body_box .register_box .register_type_box .field_line_item .send_btn .btn_load{ display: none; }
                .body_box .register_box .register_type_box .field_line_item .send_btn:hover{ background-color: #2463bd; }
                .body_box .register_box .register_type_box .field_line_item .send_btn:active{ background-color: #1854a9; }
                .body_box .register_box .register_type_box .field_line_item .register_button{ background-color: #357ce1; line-height: 55px; height: 55px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; border-radius: 5px; margin-top: 50px; }
                .body_box .register_box .register_type_box .field_line_item .register_button.off{ cursor: not-allowed; background: #4E7FC6 !important; }
                .body_box .register_box .register_type_box .field_line_item .register_button .btn_load, .body_box .register_box .register_type_box .field_line_item .register_button .btn_success{ display: none; }
                .body_box .register_box .register_type_box .field_line_item .register_button:hover{ background-color: #2463bd; }
                .body_box .register_box .register_type_box .field_line_item .register_button:active{ background-color: #1854a9; }

                .layui-layer-msg{ transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; }

                .body_box .register_box .link_btn{ cursor: pointer; color: #aeb9d8; }
                .body_box .register_box .link_btn:hover{ color: #FFF; }
                .body_box .register_box .left_link_btn{ float: left; }
                .body_box .register_box .right_link_btn{ float: right; }


            </style>

            <div class="register_box">
                <div class="box_title"><?php echo lang('view_account_forgot_2'); ?></div>
                <div class="register_type_tab">
                    <div class="tab_item active" target-content="register_type_box_1"><?php echo lang('view_account_forgot_3'); ?></div>
                    <div class="tab_item" target-content="register_type_box_2"><?php echo lang('view_account_forgot_4'); ?></div>
                    <div class="clear"></div>
                </div>

                <div>
                    <!-- 手机注册 -->
                    <div class="register_type_box active" id="register_type_box_1">
                        <div class="field_line_item">
                            <div class="phone_area_num">
                                <div class="layui-form">
                                    <div class="layui-inline">
                                        <select id="phone_area_code" name="phone_area_code">
                                            <?php foreach($this->config->item('phone_area_code') as $areaItem){ ?>
                                                <option value="<?php echo $areaItem; ?>" <?php echo $defaultAreaCode == $areaItem ? 'selected' : ''; ?>><?php echo $areaItem; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="input_ele_box phone_num_box">
                                <input class="input_ele" type="text" data-value="0" id="user_phone" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_5'); ?></label>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="phone_image_validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_6'); ?></label>
                            </div>
                            <img src="/common/validate/195/54" onclick="javascript: this.src=(this.getAttribute('baseurl') + '?' + (new Date()).getTime());" baseurl="/common/validate/195/54" class="phone_validate_code">
                            <div class="clear"></div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="phone_validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_7'); ?></label>
                            </div>
                            <div class="send_btn send_sms_btn">
                                <sapn class="btn_text"><?php echo lang('view_account_forgot_8'); ?></sapn>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="password" data-value="0" id="phone_password" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_9'); ?></label>
                            </div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="password" data-value="0" id="phone_repassword" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_10'); ?></label>
                            </div>
                        </div>
                        
                        
                        <div class="field_line_item">
                            <div class="register_button phone_forgot_btn">
                                <span class="btn_text"><?php echo lang('view_account_forgot_11'); ?></span>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                                <i class="layui-icon layui-icon-ok btn_success"></i>
                            </div>
                        </div>

                        <div class="field_line_item">
                            <a class="link_btn left_link_btn" href="/account/login"><?php echo lang('view_account_forgot_12'); ?></a>
                            <a class="link_btn right_link_btn" href="/account/register"><?php echo lang('view_account_forgot_13'); ?></a>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <!-- 邮箱注册 -->
                    <div class="register_type_box" id="register_type_box_2">
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="text" data-value="0" id="user_email" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_14'); ?></label>
                            </div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="email_image_validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_15'); ?></label>
                            </div>
                            <img src="/common/validate/195/54" onclick="javascript: this.src=(this.getAttribute('baseurl') + '?' + (new Date()).getTime());" baseurl="/common/validate/195/54" class="phone_validate_code">
                            <div class="clear"></div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="email_validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_16'); ?></label>
                            </div>
                            <div class="send_btn send_email_btn">
                                <sapn class="btn_text"><?php echo lang('view_account_forgot_17'); ?></sapn>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="password" data-value="0" id="email_password" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_18'); ?></label>
                            </div>
                        </div>
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="password" data-value="0" id="email_repassword" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_forgot_19'); ?></label>
                            </div>
                        </div>
                        
                        <div class="field_line_item">
                            <div class="register_button email_forgot_btn">
                                <span class="btn_text"><?php echo lang('view_account_forgot_20'); ?></span>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                                <i class="layui-icon layui-icon-ok btn_success"></i>
                            </div>
                        </div>

                        <div class="field_line_item">
                            <a class="link_btn left_link_btn" href="/account/login"><?php echo lang('view_account_forgot_21'); ?></a>
                            <a class="link_btn right_link_btn" href="/account/register"><?php echo lang('view_account_forgot_22'); ?></a>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <?php $this->load->view('front/footer'); ?>

        <script src="<?php echo base_url('static/layui'); ?>/layui.js"></script>

        <script type="text/javascript">

            //交易窗口切换
            $('.body_box .register_box .register_type_tab .tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            //输入框失去焦点时，将输入框中的值赋为value属性值，配合css，实现有值时lable不下沉
            $('.input_ele_box .input_ele').blur(function(){

                $(this).attr('value', $(this).val());
            });

            //JavaScript代码区域
            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {

                var element = layui.element;
                var form    = layui.form;
                var layer   = layui.layer;

                //点击发送短信验证码
                $('.send_sms_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_phone').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_23'); ?>');
                            return false;
                        }

                        if($('#phone_image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_24'); ?>');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                        $.ajax({
                            url: '/common/sms_validate',
                            type: 'post',
                            data: {
                                'phone' : $('#user_phone').val(),
                                'area_code' : $('#phone_area_code').val(),
                                'validate' : $('#phone_image_validate').val()
                            },
                            dataType: 'json',
                            success: function (data) {

                                if (data.status) {

                                    _msg.success(data.message);

                                    _this.find('.btn_text').show().siblings().hide();

                                    var _validate_wait = 60;
                                    var _setInterval = setInterval(function(){

                                        _validate_wait --;

                                        if (_validate_wait > 0) {

                                            _this.find('.btn_text').text(_validate_wait + ' s');
                                        }else{

                                            clearInterval(_setInterval);
                                            _this.removeClass('off').find('.btn_text').text('<?php echo lang('view_account_forgot_25'); ?>');
                                        }
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_forgot_26'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });

                //点击发送邮箱验证码
                $('.send_email_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_email').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_27'); ?>');
                            return false;
                        }

                        if($('#email_image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_28'); ?>');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').show().siblings().hide();

                        $.ajax({
                            url: '/common/email_validate',
                            type: 'post',
                            data: {
                                'email' : $('#user_email').val(),
                                'validate' : $('#email_image_validate').val()
                            },
                            dataType: 'json',
                            success: function (data) {

                                if (data.status) {

                                    _msg.success(data.message);

                                    _this.find('.btn_text').show().siblings().hide();

                                    var _validate_wait = 60;
                                    var _setInterval = setInterval(function(){

                                        _validate_wait --;

                                        if (_validate_wait > 0) {

                                            _this.find('.btn_text').text(_validate_wait + ' s');
                                        }else{

                                            clearInterval(_setInterval);
                                            _this.removeClass('off').find('.btn_text').text('<?php echo lang('view_account_forgot_29'); ?>');
                                        }
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_forgot_31'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });

                //手机注册
                $('.phone_forgot_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_phone').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_32'); ?>');
                            return false;
                        }

                        if($('#phone_image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_33'); ?>');
                            return false;
                        }

                        if($('#phone_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_34'); ?>');
                            return false;
                        }

                        if($('#phone_password').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_35'); ?>');
                            return false;
                        }

                        if($('#phone_repassword').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_36'); ?>');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                        $.ajax({
                            url: '/account/forgot',
                            type: 'post',
                            data: {
                                'user_phone' : $('#user_phone').val(),
                                'user_phone_area' : $('#phone_area_code').val(),
                                'user_email' : '',
                                'validate' : $('#phone_validate').val(),
                                'user_password' : $('#phone_password').val(),
                                'repassword' : $('#phone_repassword').val()
                            },
                            dataType: 'json',
                            success: function (data) {

                                if (data.status) {

                                    _this.find('.btn_success').css({display:'inline-block'}).siblings().hide();

                                    _msg.success(data.message);

                                    setTimeout(function(){

                                        window.location.href = '/account';
                                    }, 3000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_forgot_37'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });

                //邮箱注册
                $('.email_forgot_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_email').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_38'); ?>');
                            return false;
                        }

                        if($('#email_image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_39'); ?>');
                            return false;
                        }

                        if($('#email_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_40'); ?>');
                            return false;
                        }

                        if($('#email_password').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_41'); ?>');
                            return false;
                        }

                        if($('#email_repassword').val() == ''){

                            _msg.error('<?php echo lang('view_account_forgot_42'); ?>');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                        $.ajax({
                            url: '/account/forgot',
                            type: 'post',
                            data: {
                                'user_phone' : '',
                                'user_phone_area' : $('#phone_area_code').val(),
                                'user_email' : $('#user_email').val(),
                                'validate' : $('#email_validate').val(),
                                'user_password' : $('#email_password').val(),
                                'repassword' : $('#email_repassword').val()
                            },
                            dataType: 'json',
                            success: function (data) {

                                if (data.status) {

                                    _this.find('.btn_success').css({display:'inline-block'}).siblings().hide();

                                    _msg.success(data.message);

                                    setTimeout(function(){

                                        window.location.href = '/account';
                                    }, 3000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_forgot_43'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });
            });

        </script>

    </body>
</html>

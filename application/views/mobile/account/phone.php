<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_phone_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel="icon" href="/favicon.ico" type="image/x-ico" />

        <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("static/mobile"); ?>/style/style.css" />

        <!--[if lt IE 9]>
        <script src="<?php echo base_url("static/mobile"); ?>/js/css3.js"></script>
        <script src="<?php echo base_url("static/mobile"); ?>/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php $this->load->view("mobile/header"); ?>

        <style type="text/css">
            header{ height: 50px; background: #191a1f; padding: 0px 10px; position: relative; }
            header .market_list_btn{ text-align: center; font-size: 17px; color: #d5def2; line-height: 50px; }
            header .back_btn{ display: block; position: absolute; left: 10px; top: 0px; text-align: center; font-size: 17px; color: #d5def2; line-height: 50px; padding-right: 30px; }
        </style>

        <header>
            <div class="market_list_btn"><?php echo lang('view_account_phone_3'); ?></div>
            <a class="back_btn" href="/account">
                <i class="layui-icon layui-icon-left"></i>
            </a>
            <div class="clear"></div>
        </header>

        <style type="text/css">
            .account_box{ margin: 0px auto 0px auto; }
            .account_box .page_title{ background: #191a1f; padding-left: 30px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .account_box .left_box{ float: left; width: 250px; margin-top: 10px; }
            .account_box .right_box{ background: #1f2126; margin-top: 1px; }

            .account_box .right_box .action_title{ color: #697080; font-size: 14px; line-height: 50px; background: #191a1f; padding-left: 20px; }
            .account_box .right_box .action_box{ padding: 20px 20px 50px 20px; border-bottom: #34363f solid 1px; }
            .account_box .right_box .action_box .field_line_item{ margin-top: 20px; }

            .account_box .right_box .action_box .field_line_item .input_ele_box{ position: relative; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele{ display: block; line-height: 20px; height: 20px; padding: 25px 15px 8px 15px; border: #697080 solid 1px; border-radius: 5px; caret-color: #357ce1; color: #d5def2; background: #191a1f; width: calc(100% - 32px); z-index: 1; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele_label{ height: 20px; font-size: 12px; color: #697080; position: absolute; left: 15px; top: 20px; z-index: 2; cursor: text; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:focus{ border-color: #357ce1; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:focus+label{ top: 8px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:not([value=""])+label{ top: 8px; }

            .account_box .right_box .action_box .field_line_item .phone_area_num{ float: left; width: calc((100% - 14px) / 2 - 2px); height: 53px; text-align: center; border: #697080 solid 1px; border-radius: 5px; color: #d5def2; font-size: 14px; background: #191a1f; }

            .account_box .right_box .action_box .field_line_item .phone_area_num .layui-unselect{ height: 51px; line-height: 51px; text-align: center; background: #191a1f; border: #191a1f solid 1px !important; border-radius: 5px !important; color: #d5def2; }
            .account_box .right_box .action_box .field_line_item .phone_area_num .layui-unselect dl{ background: #191a1f; border-color: #697080; width: calc(100% + 4px); left: -2px; }
            .account_box .right_box .action_box .field_line_item .phone_area_num .layui-unselect dl dd:hover{ background: rgba(53, 124, 225, 0.21); }
            .account_box .right_box .action_box .field_line_item .phone_area_num .layui-unselect dl dd.layui-this{ background: #3B97E9; }
            .account_box .right_box .action_box .field_line_item .phone_area_num .layui-select-title i{ color: #697080; }

            .account_box .right_box .action_box .field_line_item .phone_num_box{ float: right; width: calc((100% - 14px) / 2 + 2px); }
            .account_box .right_box .action_box .field_line_item .phone_validate_box{ float: left; width: calc((100% - 14px) / 2); }
            .account_box .right_box .action_box .field_line_item .phone_validate_code{ display: block; float: right; width: calc((100% - 14px) / 2); border: #697080 solid 1px; border-radius: 5px; cursor: pointer; height: 53px; }
            .account_box .right_box .action_box .field_line_item .send_btn{ background-color: #357ce1; line-height: 55px; height: 55px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; border-radius: 5px; float: right; width: calc((100% - 14px) / 2 + 2px); }
            .account_box .right_box .action_box .field_line_item .send_btn.off{ cursor: not-allowed; background: #4E7FC6 !important; }
            .account_box .right_box .action_box .field_line_item .send_btn .btn_load{ display: none; }
            .account_box .right_box .action_box .field_line_item .send_btn:hover{ background-color: #2463bd; }
            .account_box .right_box .action_box .field_line_item .send_btn:active{ background-color: #1854a9; }
            .account_box .right_box .action_box .field_line_item .register_button{ background-color: #357ce1; line-height: 55px; height: 55px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; border-radius: 5px; margin-top: 50px; }
            .account_box .right_box .action_box .field_line_item .register_button.off{ cursor: not-allowed; background: #4E7FC6 !important; }
            .account_box .right_box .action_box .field_line_item .register_button .btn_load, .account_box .right_box .action_box .field_line_item .register_button .btn_success{ display: none; }
            .account_box .right_box .action_box .field_line_item .register_button:hover{ background-color: #2463bd; }
            .account_box .right_box .action_box .field_line_item .register_button:active{ background-color: #1854a9; }

            .account_box .right_box .success{ color: #05c19e; }
            .account_box .right_box .error{ color: #e04545; }
            .account_box .right_box .notice{ color: #D4B533; }

            
        </style>

        <div class="account_box">
            <div class="right_box">
                
                <div class="action_title">
                    <?php if($_SESSION['USER']['USER_PHONE'] == ''){ ?>
                        <span class="error"><?php echo lang('view_account_phone_4'); ?></span>
                    <?php }else{ ?>
                        <span class="success"><?php echo lang('view_account_phone_5'); ?><?php echo $_SESSION['USER']['USER_PHONE_AREA'] . ' ' . $_SESSION['USER']['USER_PHONE']; ?></span>
                    <?php } ?>
                </div>

                <div class="action_box">

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
                            <label class="input_ele_label"><?php echo lang('view_account_phone_6'); ?></label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_line_item">
                        <div class="input_ele_box phone_validate_box">
                            <input class="input_ele" type="text" data-value="0" id="phone_image_validate" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_phone_7'); ?></label>
                        </div>
                        <img src="/common/validate/195/54" onclick="javascript: this.src=(this.getAttribute('baseurl') + '?' + (new Date()).getTime());" baseurl="/common/validate/195/54" class="phone_validate_code">
                        <div class="clear"></div>
                    </div>
                    <div class="field_line_item">
                        <div class="input_ele_box phone_validate_box">
                            <input class="input_ele" type="text" data-value="0" id="phone_validate" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_phone_8'); ?></label>
                        </div>
                        <div class="send_btn send_sms_btn">
                            <sapn class="btn_text"><?php echo lang('view_account_phone_9'); ?></sapn>
                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <input class="input_ele" type="password" data-value="0" id="phone_expassword" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_phone_10'); ?></label>
                        </div>
                    </div>
                    
                    <div class="field_line_item">
                        <div class="register_button phone_register_btn">
                            <span class="btn_text"><?php echo lang('view_account_phone_11'); ?></span>
                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            <i class="layui-icon layui-icon-ok btn_success"></i>
                        </div>
                    </div>
                </div>

                <?php $this->load->view("mobile/account/account_safe_text"); ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("mobile/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.account').addClass('active');

            //输入框失去焦点时，将输入框中的值赋为value属性值，配合css，实现有值时lable不下沉
            $('.input_ele_box .input_ele').blur(function(){

                $(this).attr('value', $(this).val());
            });

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                var element = layui.element;
                var form    = layui.form;
                var layer   = layui.layer;

                //点击发送短信验证码
                $('.send_sms_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_phone').val() == ''){

                            _msg.error('<?php echo lang('view_account_phone_12'); ?>');
                            return false;
                        }

                        if($('#phone_image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_phone_13'); ?>');
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
                                            _this.removeClass('off').find('.btn_text').text('<?php echo lang('view_account_phone_14'); ?>');
                                        }
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_phone_15'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });

                //提交手机
                $('.phone_register_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#user_phone').val() == ''){

                            _msg.error('请输入手机号码');
                            return false;
                        }

                        if($('#phone_image_validate').val() == ''){

                            _msg.error('请输入图形验证码');
                            return false;
                        }

                        if($('#phone_validate').val() == ''){

                            _msg.error('请输入手机验证码');
                            return false;
                        }

                        if($('#phone_expassword').val() == ''){

                            _msg.error('请输入安全密码');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                        $.ajax({
                            url: '/account/phone',
                            type: 'post',
                            data: {
                                'user_phone' : $('#user_phone').val(),
                                'user_phone_area' : $('#phone_area_code').val(),
                                'user_ex_password' : $('#phone_expassword').val(),
                                'validate' : $('#phone_validate').val()
                            },
                            dataType: 'json',
                            success: function (data) {

                                if (data.status) {

                                    _this.find('.btn_success').css({display:'inline-block'}).siblings().hide();

                                    _msg.success(data.message);

                                    setTimeout(function(){

                                        window.location.href = '/account';
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('网络繁忙，请稍后再试');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>

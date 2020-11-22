<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_withdraw_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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
            <div class="market_list_btn"><?php echo lang('view_account_withdraw_3'); ?> / <?php echo lang('view_account_withdraw_4'); ?> <?php echo $coin['coin_symbol']; ?></div>
            <a class="back_btn" href="/account/asset">
                <i class="layui-icon layui-icon-left"></i>
            </a>
            <div class="clear"></div>
        </header>

        <style type="text/css">
            .account_box{ margin: 0px auto; }
            .account_box .page_title{ background: #191a1f; padding-left: 30px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .account_box .left_box{ float: left; width: 250px; background: #191a1f; margin-top: 10px; }
            .account_box .right_box{ background: #1f2126; margin-top: 1px; }

            .account_box .right_box .action_title{ color: #a7b7c7; font-size: 14px; line-height: 50px; background: #191a1f; padding-left: 20px; }
            .account_box .right_box .action_box{ padding: 20px; border-bottom: #34363f solid 1px; }

            .account_box .right_box .action_box .field_line_item{ margin-top: 20px; }

            .account_box .right_box .action_box .field_line_item .input_ele_box{ position: relative; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele{ display: block; line-height: 20px; height: 20px; padding: 25px 15px 8px 15px; border: #697080 solid 1px; border-radius: 5px; caret-color: #357ce1; color: #d5def2; background: #191a1f; width: calc(100% - 32px); z-index: 1; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele_label{ height: 20px; font-size: 12px; color: #697080; position: absolute; left: 15px; top: 20px; z-index: 2; cursor: text; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:focus{ border-color: #357ce1; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:focus+label{ top: 8px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_ele:not([value=""])+label{ top: 8px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .input_title{ color: #a7b7c7; font-size: 16px; margin-bottom: 10px; }

            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box{  }
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_content{ float: left; line-height: 40px; height: 40px; background: #697080; color: #FFF; width: 400px; text-align: center; font-size: 14px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_btn{ float: left; background-color: #357ce1; line-height: 40px; height: 40px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; width: 100px; margin-left: 10px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_btn:hover{ background-color: #2463bd; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_btn:active{ background-color: #1854a9; }

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

            .account_box .right_box .asset_list{ width: 100%; }
            .account_box .right_box .asset_list td{ color: #a7b7c7; font-size: 12px; line-height: 60px; height: 60px; border-bottom: #34363f solid 1px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .account_box .right_box .asset_list .item_line:hover{ background: rgba(53, 124, 225, 0.21); }
            .account_box .right_box .asset_list .title_line{ background: #191a1f; }
            .account_box .right_box .asset_list .title_line td{ color: #697080; font-size: 12px; line-height: 50px; }
            .account_box .right_box .asset_list .hold{ width: 10px; }
            .account_box .right_box .asset_list .action_td{ text-align: right; }
            .account_box .right_box .asset_list .action_td .action_btn{ color: #3B97E9; font-size: 12px; cursor: pointer; margin-left: 10px; }
            .account_box .right_box .asset_list .action_td .action_btn:hover{ color: #357ce1; }
            .account_box .right_box .asset_list .action_td .action_btn.off{ cursor: not-allowed; color: #697080; }
            .account_box .right_box .asset_list .coin_icon{ width: 30px; }
            .account_box .right_box .asset_list .coin_icon .coin_icon_img{ display: block; width: 20px; height: 20px; }

            .account_box .right_box .recharge_info{ color: #a7b7c7; font-size: 16px; margin-bottom: 10px; line-height: 30px; }
            .account_box .back_link{ float: right; margin-right: 50px; }
            .account_box .back_link:hover{ color: #FFF; }

            .account_box .get_wallet{ background-color: #357ce1; line-height: 50px; height: 50px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; width: 400px; border-radius: 5px; }
            .account_box .get_wallet:hover{ background-color: #2463bd; }
            .account_box .get_wallet:active{ background-color: #1854a9; }
            .account_box .get_wallet .btn_load, .account_box .get_wallet .btn_success{ display: none; }
            .account_box .get_wallet.off{ background-color: #1854a9; cursor: not-allowed; }
            .account_box .get_wallet.off .btn_text{ display: none; }
            .account_box .get_wallet.off .btn_load{ display: inline-block; }
            .account_box .get_wallet.off.success .btn_load{ display: none; }
            .account_box .get_wallet.off.success .btn_success{ display: inline-block; }

            .account_box .recharge_address_qrcode_box{ background: #FFF; padding: 20px; width: 200px; opacity: .8; }
            .account_box .recharge_address_qrcode{ width: 200px; height: 200px; }

            .account_box .wallet_tab_box{ margin-top: 30px; }
            .account_box .wallet_tab_box .wallet_tab_item_box{  }
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item{ float: left; color: #3B97E9; font-size: 14px; line-height: 40px; cursor: pointer; width: 50%; box-sizing: border-box; text-align: center; border: #3B97E9 solid 1px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item:hover{ color: #357ce1; border: #357ce1 solid 1px; }
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item.active{ color: #FFF; border: #357ce1 solid 1px; background: #357ce1; }
            .account_box .wallet_tab_box .wallet_tab_content_box{  }
            .account_box .wallet_tab_box .wallet_tab_content_box .wallet_tab_item_content{ display: none; }
            .account_box .wallet_tab_box .wallet_tab_content_box .wallet_tab_item_content.active{ display: block; }

            .account_box .input_title.amount_text{ font-size: 14px !important; }

            .account_box .right_box .success_text{ color: #05c19e; }
            .account_box .right_box .error_text{ color: #e04545; }
            .account_box .right_box .notice_text{ color: #D4B533; }
        </style>

        <div class="account_box">
            <div class="right_box">
                
                <div class="action_title">
                    <?php echo lang('view_account_withdraw_6'); ?> <?php echo $coin['coin_symbol']; ?>
                </div>

                <div class="action_box">

                    <div class="recharge_info">
                        <?php echo lang('view_account_withdraw_7'); ?> <?php echo floatval($coin['coin_withdraw_amount']); ?> <?php echo $coin['coin_symbol']; ?><br />
                        <?php echo lang('view_account_withdraw_8'); ?> <?php echo floatval($coin['coin_withdraw_fee']); ?> <?php echo $coin['coin_symbol']; ?> <?php echo lang('view_account_withdraw_9'); ?><br />
                    </div>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <div class="input_title"><?php echo lang('view_account_withdraw_10'); ?></div>
                        </div>
                    </div>

                    <?php if($coin['coin_chain'] == -1 && $coinChainList && count($coinChainList)){ ?>

                        <div class="wallet_tab_box">
                            <div class="wallet_tab_item_box">
                                <?php $i = 0; foreach($coinChainList as $walletSymbol){ ?>
                                    <div class="wallet_tab_item <?php echo $i == 0 ? 'active' : ''; ?>" data-value="<?php echo $walletSymbol; ?>"><?php echo $walletSymbol; ?></div>
                                <?php $i++; } ?>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <input type="hidden" id="wallet_symbol" value="<?php echo $coinChainList[0]; ?>">

                    <?php }else{ ?>

                        <input type="hidden" id="wallet_symbol" value="<?php echo $coin['coin_symbol']; ?>">
                    <?php } ?>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <input class="input_ele" type="text" data-value="0" id="withdraw_address" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_withdraw_11'); ?></label>
                        </div>
                    </div>

                    <?php if($coin['coin_chain'] == 144 || $coin['coin_chain'] == 194){ ?>
                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <input class="input_ele" type="text" data-value="0" id="withdraw_address_memo" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_withdraw_12'); ?></label>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <input type="hidden" id="withdraw_address_memo" value="<?php echo $coin['coin_symbol']; ?>">
                    <?php } ?>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <input class="input_ele" type="text" data-value="0" id="withdraw_amount" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_withdraw_13'); ?></label>
                        </div>
                    </div>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <div class="input_title amount_text"><?php echo lang('view_account_withdraw_14'); ?> <?php echo $coinAsset['asset_active']; ?> <?php echo $coin['coin_symbol']; ?></div>
                            <div class="input_title amount_text"><?php echo lang('view_account_withdraw_15'); ?> <?php echo $coin['coin_withdraw_fee']; ?> <?php echo $coin['coin_symbol']; ?></div>
                            <div class="input_title amount_text"><?php echo lang('view_account_withdraw_16'); ?> <?php echo $coin['coin_withdraw_amount']; ?> <?php echo $coin['coin_symbol']; ?></div>
                        </div>
                    </div>

                    <div class="field_line_item">
                        <div class="input_ele_box phone_validate_box">
                            <input class="input_ele" type="text" data-value="0" id="image_validate" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_withdraw_17'); ?></label>
                        </div>
                        <img src="/common/validate/195/54" onclick="javascript: this.src=(this.getAttribute('baseurl') + '?' + (new Date()).getTime());" baseurl="/common/validate/195/54" class="phone_validate_code">
                        <div class="clear"></div>
                    </div>

                    <div class="field_line_item">

                        <?php if($user['user_phone'] == ''){ ?>
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_withdraw_18'); ?></label>
                            </div>
                            <div class="send_btn send_validate_btn" attr-action="email">
                                <sapn class="btn_text"><?php echo lang('view_account_withdraw_19'); ?></sapn>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            </div>
                        <?php }else{ ?>
                            <div class="input_ele_box phone_validate_box">
                                <input class="input_ele" type="text" data-value="0" id="validate" value="">
                                <label class="input_ele_label"><?php echo lang('view_account_withdraw_20'); ?></label>
                            </div>
                            <div class="send_btn send_validate_btn" attr-action="sms">
                                <sapn class="btn_text"><?php echo lang('view_account_withdraw_21'); ?></sapn>
                                <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            </div>
                        <?php } ?>

                        
                        <div class="clear"></div>
                    </div>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <input class="input_ele" type="password" data-value="0" id="expassword" value="">
                            <label class="input_ele_label"><?php echo lang('view_account_withdraw_22'); ?></label>
                        </div>
                    </div>
                    
                    <div class="field_line_item">
                        <div class="register_button withdraw_btn">
                            <span class="btn_text"><?php echo lang('view_account_withdraw_23'); ?></span>
                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                            <i class="layui-icon layui-icon-ok btn_success"></i>
                        </div>
                    </div>

                </div>

                <div class="action_title">
                    <div class="input_title"><?php echo lang('view_account_withdraw_24'); ?></div>
                </div>

                <div class="action_box">

                    <div>
                        <table class="asset_list" cellpadding="0" cellspacing="0" border="0">
                            <tr class="title_line">
                                <td class="hold"></td>
                                <td><?php echo lang('view_account_withdraw_25'); ?></td>
                                <td><?php echo lang('view_account_withdraw_26'); ?></td>
                                <td><?php echo lang('view_account_withdraw_27'); ?></td>
                                <td class="action_td"><?php echo lang('view_account_withdraw_28'); ?></td>
                                <td class="hold"></td>
                            </tr>

                            <?php if($withdrawList && count($withdrawList)){ foreach($withdrawList as $withdraw){ ?>
                            <tr class="item_line">
                                <td class="hold"></td>
                                <td><?php echo date('m/d H:i', $withdraw['withdraw_time']); ?></td>
                                <td><?php echo $withdraw['withdraw_chain_symbol']; ?></td>
                                <td><?php echo $withdraw['withdraw_amount']; ?></td>
                                <td class="action_td">
                                    <span class="
                                        <?php switch($withdraw['withdraw_status']){

                                            case 0:
                                                echo 'notice_text';
                                            break;

                                            case 1:
                                                echo 'notice_text';
                                            break;

                                            case 2:
                                                echo 'error_text';
                                            break;

                                            case 3:
                                                echo 'notice_text';
                                            break;

                                            case 4:
                                                echo 'notice_text';
                                            break;

                                            case 5:
                                                echo 'notice_text';
                                            break;

                                            case 6:
                                                echo 'success_text';
                                            break;

                                            case 7:
                                                echo 'notice_text';
                                            break;
                                        } ?>
                                    ">
                                        <?php switch($withdraw['withdraw_status']){

                                            case 0:
                                                echo lang('view_account_withdraw_29');
                                            break;

                                            case 1:
                                                echo lang('view_account_withdraw_31');
                                            break;

                                            case 2:
                                                echo lang('view_account_withdraw_32');
                                            break;

                                            case 3:
                                                echo lang('view_account_withdraw_33');
                                            break;

                                            case 4:
                                                echo lang('view_account_withdraw_34');
                                            break;

                                            case 5:
                                                echo lang('view_account_withdraw_35');
                                            break;

                                            case 6:
                                                echo lang('view_account_withdraw_36');
                                            break;

                                            case 7:
                                                echo lang('view_account_withdraw_37');
                                            break;
                                        } ?>
                                    </span>
                                </td>
                                <td class="hold"></td>
                            </tr>
                            <?php }} ?>
                        </table>
                    </div>

                    <div style="height: 30px;"></div>

                    <div class="page_paging_box">
                        <!-- 通用分页 -->
                        <?php
                            if($withdrawCount > $pageSize){
                                $this->load->view('mobile/paging');
                            }
                        ?>
                    </div>
                </div>

                <?php $this->load->view("mobile/account/account_safe_text"); ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("mobile/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>
        <script src="<?php echo base_url('static/mobile'); ?>/js/jquery-qrcode.js" ></script>
        <script src="<?php echo base_url('static/mobile'); ?>/js/clipboard.js" ></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.account, .asset_box .account_menu .account_menu_item.exchange').addClass('active');

            //输入框失去焦点时，将输入框中的值赋为value属性值，配合css，实现有值时lable不下沉
            $('.input_ele_box .input_ele').blur(function(){

                $(this).attr('value', $(this).val());
            });

            //多通道切换
            $('.account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#wallet_symbol').val(_this.attr('data-value'));
                }
            });

            $('#withdraw_amount').keyup(function(){

                format_input_num($(this)[0]);
            });

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {

                //点击发送验证码
                $('.send_validate_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if($('#image_validate').val() == ''){

                            _msg.error('<?php echo lang('view_account_withdraw_38'); ?>');
                            return false;
                        }

                        _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                        $.ajax({
                            url: '/common/user_' + _this.attr('attr-action') + '_validate',
                            type: 'post',
                            data: {
                                'validate' : $('#image_validate').val()
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
                                            _this.removeClass('off').find('.btn_text').text('<?php echo lang('view_account_withdraw_39'); ?>');
                                        }
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_withdraw_40'); ?>');
                                _this.removeClass('off').find('.btn_text').show().siblings().hide();
                            }
                        });
                    }
                });


                //提交认证
                $('.withdraw_btn').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        if (! _this.hasClass('off')) {

                            if($('#withdraw_address').val() == ''){

                                _msg.error('<?php echo lang('view_account_withdraw_41'); ?>');
                                return false;
                            }

                            if($('#withdraw_address_memo').val() == ''){

                                _msg.error('<?php echo lang('view_account_withdraw_42'); ?>');
                                return false;
                            }

                            if($('#withdraw_amount').val() == ''){

                                _msg.error('<?php echo lang('view_account_withdraw_43'); ?>');
                                return false;
                            }

                            if($('#validate').val() == ''){

                                _msg.error('<?php echo lang('view_account_withdraw_44'); ?>');
                                return false;
                            }

                            if($('#expassword').val() == ''){

                                _msg.error('<?php echo lang('view_account_withdraw_45'); ?>');
                                return false;
                            }

                            _this.addClass('off').find('.btn_load').css({display:'inline-block'}).siblings().hide();

                            $.ajax({
                                url: '/account/withdraw/<?php echo $coin['coin_symbol']; ?>',
                                type: 'post',
                                data: {
                                    'wallet_symbol' : $('#wallet_symbol').val(),
                                    'withdraw_address' : $('#withdraw_address').val(),
                                    'withdraw_address_memo' : $('#withdraw_address_memo').val(),
                                    'withdraw_amount' : $('#withdraw_amount').val(),
                                    'validate' : $('#validate').val(),
                                    'expassword' : $('#expassword').val()
                                },
                                dataType: 'json',
                                success: function (data) {

                                    if (data.status) {

                                        _this.find('.btn_success').css({display:'inline-block'}).siblings().hide();

                                        _msg.success(data.message);

                                        setTimeout(function(){

                                            location.reload();
                                        }, 1000);
                                    }else{

                                        _msg.error(data.message);
                                        _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                    }
                                },
                                error: function(){

                                    _msg.error('<?php echo lang('view_account_withdraw_46'); ?>');
                                    _this.removeClass('off').find('.btn_text').show().siblings().hide();
                                }
                            });
                        }
                    }
                });
            });
        </script>
    </body>
</html>

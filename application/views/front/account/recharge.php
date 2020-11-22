<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_recharge_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel="icon" href="/favicon.ico" type="image/x-ico" />

        <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("static/front"); ?>/style/style.css" />

        <!--[if lt IE 9]>
        <script src="<?php echo base_url("static/front"); ?>/js/css3.js"></script>
        <script src="<?php echo base_url("static/front"); ?>/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php $this->load->view("front/header"); ?>

        <style type="text/css">
            .account_box{ width: 1200px; margin: 30px auto 100px auto; }
            .account_box .page_title{ background: #191a1f; padding-left: 30px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .account_box .left_box{ float: left; width: 250px; background: #191a1f; margin-top: 10px; }
            .account_box .right_box{ float: right; width: 940px; background: #1f2126; margin-top: 10px; }

            .account_box .right_box .action_title{ color: #a7b7c7; font-size: 14px; line-height: 50px; background: #191a1f; padding-left: 50px; }
            .account_box .right_box .action_box{ padding: 30px 50px 50px 50px; border-bottom: #34363f solid 1px; }

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

            .account_box .right_box .asset_list{ width: 100%; }
            .account_box .right_box .asset_list td{ color: #a7b7c7; font-size: 12px; line-height: 60px; height: 60px; border-bottom: #34363f solid 1px; }
            .account_box .right_box .asset_list .item_line:hover{ background: rgba(53, 124, 225, 0.21); }
            .account_box .right_box .asset_list .title_line{ background: #191a1f; }
            .account_box .right_box .asset_list .title_line td{ color: #697080; font-size: 12px; line-height: 50px; }
            .account_box .right_box .asset_list .hold{ width: 50px; }
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
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item{ float: left; color: #3B97E9; font-size: 14px; line-height: 40px; margin-right: 15px; cursor: pointer; padding: 0px 20px; border: #3B97E9 solid 1px; }
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item:hover{ color: #357ce1; border: #357ce1 solid 1px; }
            .account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item.active{ color: #FFF; border: #357ce1 solid 1px; background: #357ce1; }
            .account_box .wallet_tab_box .wallet_tab_content_box{  }
            .account_box .wallet_tab_box .wallet_tab_content_box .wallet_tab_item_content{ display: none; }
            .account_box .wallet_tab_box .wallet_tab_content_box .wallet_tab_item_content.active{ display: block; }
        </style>

        <div class="account_box">
            <div class="page_title">
                <?php echo lang('view_account_recharge_2'); ?> / <?php echo lang('view_account_recharge_3'); ?> / <?php echo lang('view_account_recharge_4'); ?> <?php echo $coin['coin_symbol']; ?>    
                <a class="back_link" href="/account/asset"><< <?php echo lang('view_account_recharge_5'); ?></a>
            </div>
            <div class="right_box">
                
                <div class="action_title">
                    <?php echo lang('view_account_recharge_6'); ?> <?php echo $coin['coin_symbol']; ?>
                </div>

                <div class="action_box">

                    <div class="recharge_info">
                        <?php echo lang('view_account_recharge_7'); ?> <?php echo floatval($coin['coin_recharge_min_amount']); ?> <?php echo $coin['coin_symbol']; ?><br />
                        <?php echo lang('view_account_recharge_8'); ?> <?php echo floatval($coin['coin_recharge_min_amount']); ?> <?php echo $coin['coin_symbol']; ?> <?php echo lang('view_account_recharge_9'); ?><br />
                    </div>

                    <?php if($coin['coin_chain'] == -1){ ?>

                        <div class="wallet_tab_box">
                            <div class="wallet_tab_item_box">
                                <?php if($userWallet && count($userWallet)){ $i = 0; foreach($userWallet as $walletSymbol => $walletItem){ ?>
                                    <div class="wallet_tab_item <?php echo $i == 0 ? 'active' : ''; ?>" target-content="wallet_tab_item_content_<?php echo $walletSymbol; ?>"><?php echo $walletSymbol; ?></div>
                                <?php $i++; }} ?>
                                <div class="clear"></div>
                            </div>
                            <div class="wallet_tab_content_box">
                                <?php if($userWallet && count($userWallet)){ $i = 0; foreach($userWallet as $walletSymbol => $walletItem){ ?>
                                    <div class="wallet_tab_item_content <?php echo $i == 0 ? 'active' : ''; ?>" id="wallet_tab_item_content_<?php echo $walletSymbol; ?>">

                                        <?php if($walletItem){ ?>
                                            <div class="field_line_item">
                                                <div class="input_ele_box">
                                                    <div class="input_title"><?php echo lang('view_account_recharge_10'); ?></div>

                                                    <div class="text_bar_box">
                                                        <div class="text_content recharge_address recharge_address_<?php echo $walletSymbol; ?>"><?php echo $userWallet[$walletSymbol]['wallet_value']; ?></div>
                                                        <div class="text_btn copy_code copy_code_<?php echo $walletSymbol; ?>"><?php echo lang('view_account_recharge_11'); ?></div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="field_line_item">
                                                <div class="input_ele_box">
                                                    
                                                    <div class="text_bar_box">
                                                        <div class="recharge_address_qrcode_box">
                                                            <div class="recharge_address_qrcode recharge_address_qrcode_<?php echo $walletSymbol; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="field_line_item">
                                                <div class="input_ele_box">
                                                    <div class="input_title"><?php echo lang('view_account_recharge_12'); ?></div>

                                                    <div class="text_bar_box">
                                                        <div class="get_wallet" data-coin="<?php echo $coin['coin_symbol']; ?>" data-wallet-symbol="<?php echo $walletSymbol; ?>">
                                                            <span class="btn_text"><?php echo lang('view_account_recharge_13'); ?> <?php echo $walletSymbol; ?> <?php echo lang('view_account_recharge_14'); ?></span>
                                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                                                            <i class="layui-icon layui-icon-ok btn_success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php $i++; }} ?>
                            </div>
                        </div>

                    <?php }elseif($coin['coin_chain'] == 144 || $coin['coin_chain'] == 194){ ?>

                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <div class="input_title"><?php echo lang('view_account_recharge_15'); ?></div>

                                <div class="text_bar_box">
                                    <div class="text_content recharge_address_1"><?php echo $userWallet[$coin['coin_symbol']][0]; ?></div>
                                    <div class="text_btn copy_code_1"><?php echo lang('view_account_recharge_16'); ?></div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

                        <div class="field_line_item">
                            <div class="input_ele_box">
                                
                                <div class="text_bar_box">
                                    <div class="recharge_address_qrcode_box">
                                        <div class="recharge_address_qrcode"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field_line_item">
                            <div class="input_ele_box">
                                <div class="input_title"><?php echo lang('view_account_recharge_17'); ?></div>

                                <div class="text_bar_box">
                                    <div class="text_content recharge_address_2"><?php echo $userWallet[$coin['coin_symbol']][1]; ?></div>
                                    <div class="text_btn copy_code_2"><?php echo lang('view_account_recharge_18'); ?></div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

                    <?php }else{ ?>

                        <?php if($userWallet[$coin['coin_symbol']] && count($userWallet[$coin['coin_symbol']])){ ?>

                            <div class="field_line_item">
                                <div class="input_ele_box">
                                    <div class="input_title"><?php echo lang('view_account_recharge_19'); ?></div>

                                    <div class="text_bar_box">
                                        <div class="text_content recharge_address"><?php echo $userWallet[$coin['coin_symbol']]['wallet_value']; ?></div>
                                        <div class="text_btn copy_code"><?php echo lang('view_account_recharge_20'); ?></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="field_line_item">
                                <div class="input_ele_box">
                                    
                                    <div class="text_bar_box">
                                        <div class="recharge_address_qrcode_box">
                                            <div class="recharge_address_qrcode"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            
                            <div class="field_line_item">
                                <div class="input_ele_box">
                                    <div class="input_title"><?php echo lang('view_account_recharge_21'); ?></div>

                                    <div class="text_bar_box">
                                        <div class="get_wallet" data-coin="<?php echo $coin['coin_symbol']; ?>" data-wallet-symbol="<?php echo $this->config->item('udun_chain')[$coin['coin_chain']]; ?>">
                                            <span class="btn_text"><?php echo lang('view_account_recharge_22'); ?> <?php echo $coin['coin_symbol']; ?> <?php echo lang('view_account_recharge_23'); ?></span>
                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                                            <i class="layui-icon layui-icon-ok btn_success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>

                <div class="action_title">
                    <div class="input_title"><?php echo lang('view_account_recharge_24'); ?></div>
                </div>

                <div class="action_box">

                    <div>
                        <table class="asset_list" cellpadding="0" cellspacing="0" border="0">
                            <tr class="title_line">
                                <td class="hold"></td>
                                <td><?php echo lang('view_account_recharge_25'); ?></td>
                                <td><?php echo lang('view_account_recharge_26'); ?></td>
                                <td class="action_td"><?php echo lang('view_account_recharge_27'); ?></td>
                                <td class="hold"></td>
                            </tr>

                            <?php if($rechargeList && count($rechargeList)){ foreach($rechargeList as $recharge){ ?>
                            <tr class="item_line">
                                <td class="hold"></td>
                                <td><?php echo date('Y-m-d H:i:s', $recharge['recharge_time']); ?></td>
                                <td><?php echo $recharge['recharge_coin_symbol']; ?></td>
                                <td class="action_td"><?php echo $recharge['recharge_amount']; ?></td>
                                <td class="hold"></td>
                            </tr>
                            <?php }} ?>
                        </table>
                    </div>

                    <div style="height: 30px;"></div>

                    <div class="page_paging_box">
                        <!-- 通用分页 -->
                        <?php
                            if($rechargeCount > $pageSize){
                                $this->load->view('front/paging');
                            }
                        ?>
                    </div>
                </div>

                <?php $this->load->view("front/account/account_safe_text"); ?>
            </div>
            <div class="left_box">
                <?php $this->load->view("front/account/asset_menu"); ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("front/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>
        <script src="<?php echo base_url('static/front'); ?>/js/jquery-qrcode.js" ></script>
        <script src="<?php echo base_url('static/front'); ?>/js/clipboard.js" ></script>

        <script type="text/javascript">

            //当前栏目
            $('header .left_box .nav_box .nav_item.asset').addClass('active');
            $('.account_menu_item.exchange').addClass('active');

            //多充值通道切换
            $('.account_box .wallet_tab_box .wallet_tab_item_box .wallet_tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {

                //获取地址
                $('.get_wallet').click(function(){

                    var _this = $(this);

                    if (! _this.hasClass('off')) {

                        _this.addClass('off');

                        $.ajax({
                            url: '/account/get_wallet',
                            type: 'post',
                            data: {
                                'coin' : _this.attr('data-coin'),
                                'wallet_symbol' : _this.attr('data-wallet-symbol')
                            },
                            dataType: 'json',
                            success: function (data) {
                                
                                if (data.status) {

                                    _msg.success(data.message);
                                    _this.addClass('success');

                                    setTimeout(function(){

                                        location.reload();
                                    }, 1000);
                                }else{

                                    _msg.error(data.message);
                                    _this.removeClass('off');
                                }
                            },
                            error: function(){

                                _msg.error('<?php echo lang('view_account_recharge_28'); ?>');
                                _this.removeClass('off');
                            }
                        });
                    }
                });

                <?php if($coin['coin_chain'] == -1){ ?>

                    <?php if($userWallet && count($userWallet)){ $i = 0; foreach($userWallet as $walletSymbol => $walletItem){ ?>
                        
                        //复制
                        var clipboard_<?php echo $i; ?> = new ClipboardJS('.copy_code_<?php echo $walletSymbol; ?>', {
                            text: function() {
                                return $('.recharge_address_<?php echo $walletSymbol; ?>').text();
                            }
                        });
                        clipboard_<?php echo $i; ?>.on('success', function(e) {
                            _msg.success('<?php echo lang('view_account_recharge_29'); ?>');
                        });
                        
                        //二维码
                        $('.recharge_address_qrcode_<?php echo $walletSymbol; ?>').qrcode({
                            render: "canvas", //table方式
                            width: 200,
                            height: 200,
                            text: $('.recharge_address_<?php echo $walletSymbol; ?>').text() //任意内容
                        });
                    <?php $i++; }} ?>

                <?php }elseif($coin['coin_chain'] == 144 || $coin['coin_chain'] == 194){ ?>

                    //复制
                    var clipboard_1 = new ClipboardJS('.copy_code_1', {
                        text: function() {
                            return $('.recharge_address_1').text();
                        }
                    });
                    clipboard_1.on('success', function(e) {
                        _msg.success('<?php echo lang('view_account_recharge_31'); ?>');
                    });

                    //复制
                    var clipboard_2 = new ClipboardJS('.copy_code_2', {
                        text: function() {
                            return $('.recharge_address_2').text();
                        }
                    });
                    clipboard_2.on('success', function(e) {
                        _msg.success('<?php echo lang('view_account_recharge_32'); ?>');
                    });
                    
                    //二维码
                    $('.recharge_address_qrcode').qrcode({
                        render: "canvas", //table方式
                        width: 200,
                        height: 200,
                        text: $('.recharge_address_1').text() //任意内容
                    });
                <?php }else{ ?>

                    //复制
                    var clipboard = new ClipboardJS('.copy_code', {
                        text: function() {
                            return $('.recharge_address').text();
                        }
                    });
                    clipboard.on('success', function(e) {
                        _msg.success('<?php echo lang('view_account_recharge_33'); ?>');
                    });
                    
                    //二维码
                    $('.recharge_address_qrcode').qrcode({
                        render: "canvas", //table方式
                        width: 200,
                        height: 200,
                        text: $('.recharge_address').text() //任意内容
                    });
                <?php } ?>
            });
        </script>
    </body>
</html>

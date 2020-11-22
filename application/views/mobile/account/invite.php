<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_invite_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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
            <div class="market_list_btn"><?php echo lang('view_account_invite_3'); ?></div>
            <a class="back_btn" href="/account">
                <i class="layui-icon layui-icon-left"></i>
            </a>
            <div class="clear"></div>
        </header>

        <style type="text/css">
            .account_box{ margin: 0px auto 100px auto; }
            .account_box .page_title{ background: #191a1f; padding-left: 30px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .account_box .left_box{ float: left; width: 250px; margin-top: 1px; }
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
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_content{ line-height: 40px; height: 40px; background: #697080; color: #FFF; width: 100%; text-align: center; font-size: 12px; }
            .account_box .right_box .action_box .field_line_item .input_ele_box .text_bar_box .text_btn{ background-color: #357ce1; line-height: 40px; height: 40px; color: #FFF; font-size: 16px; cursor: pointer; text-align: center; }
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

            .account_box .right_box .success{ color: #05c19e; }
            .account_box .right_box .error{ color: #e04545; }
            .account_box .right_box .notice{ color: #D4B533; }


            .account_box .right_box .asset_list{ width: 100%; }
            .account_box .right_box .asset_list td{ color: #a7b7c7; font-size: 12px; line-height: 60px; height: 60px; border-bottom: #34363f solid 1px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .account_box .right_box .asset_list .item_line:hover{ background: rgba(53, 124, 225, 0.21); }
            .account_box .right_box .asset_list .title_line{ background: #191a1f; }
            .account_box .right_box .asset_list .title_line td{ color: #697080; font-size: 12px; line-height: 50px; }
            .account_box .right_box .asset_list .hold{ width: 20px; }
            .account_box .right_box .asset_list .action_td{ text-align: right; }
            .account_box .right_box .asset_list .action_td .action_btn{ color: #3B97E9; font-size: 12px; cursor: pointer; margin-left: 10px; }
            .account_box .right_box .asset_list .action_td .action_btn:hover{ color: #357ce1; }
            .account_box .right_box .asset_list .action_td .action_btn.off{ cursor: not-allowed; color: #697080; }
            .account_box .right_box .asset_list .coin_icon{ width: 30px; }
            .account_box .right_box .asset_list .coin_icon .coin_icon_img{ display: block; width: 20px; height: 20px; }

            
        </style>

        <div class="account_box">
            <div class="right_box">
                
                <div class="action_title">
                    <?php echo lang('view_account_invite_4'); ?>
                </div>

                <div class="action_box">
                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <div class="input_title"><?php echo lang('view_account_invite_5'); ?></div>
                            <div class="text_bar_box">
                                <div class="text_content invite_code"><?php echo $user['user_invite_code']; ?></div>
                                <div class="text_btn copy_code"><?php echo lang('view_account_invite_6'); ?></div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>

                    <div class="field_line_item">
                        <div class="input_ele_box">
                            <div class="input_title"><?php echo lang('view_account_invite_7'); ?></div>
                            <div class="text_bar_box">
                                <div class="text_content invite_link"><?php echo base_url('/account/register'); ?>?i=<?php echo $user['user_invite_code']; ?></div>
                                <div class="text_btn copy_link"><?php echo lang('view_account_invite_8'); ?></div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action_title">
                    <div class="input_title"><?php echo lang('view_account_invite_9'); ?><?php echo $user['user_invite_count']; ?></div>
                </div>

                <div class="action_box">

                    <div>
                        <table class="asset_list" cellpadding="0" cellspacing="0" border="0">
                            <tr class="title_line">
                                <td class="hold"></td>
                                <td>帐户</td>
                                <td class="action_td"><?php echo lang('view_account_invite_10'); ?></td>
                                <td class="hold"></td>
                            </tr>

                            <?php if($inviteList && count($inviteList)){ foreach($inviteList as $invite){ ?>
                            <tr class="item_line">
                                <td class="hold"></td>
                                <td><?php echo substr($invite['user_email'], 0, 4) . '******' . substr($invite['user_email'], -4); ?></td>
                                <td class="action_td"><?php echo date('Y-m-d', $invite['user_register_time']); ?></td>
                                <td class="hold"></td>
                            </tr>
                            <?php }} ?>
                        </table>
                    </div>

                    <div style="height: 30px;"></div>

                    <div class="page_paging_box">
                        <!-- 通用分页 -->
                        <?php
                            if($user['user_invite_count'] > $pageSize){
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
        <script src="<?php echo base_url('static/mobile'); ?>/js/clipboard.js" ></script>

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

                //复制
                var clipboard =  new ClipboardJS('.copy_code', {
                    text: function() {
                        return $('.invite_code').text();
                    }
                });
                clipboard.on('success', function(e) {
                    _msg.success('<?php echo lang('view_account_invite_11'); ?>');
                });

                var clipboard_2 =  new ClipboardJS('.copy_link', {
                    text: function() {
                        return $('.invite_link').text();
                    }
                });
                clipboard_2.on('success', function(e) {
                    _msg.success('<?php echo lang('view_account_invite_12'); ?>');
                });
            });
        </script>
    </body>
</html>

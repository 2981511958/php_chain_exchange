<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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
            .account_box{  margin: 0px auto; }
            .account_box .page_title{ background: #191a1f; padding-left: 30px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .account_box .left_box{  }
            .account_box .right_box{ background: #1f2126; }

            .account_box .right_box .account_info_list{ width: 100%; }
            .account_box .right_box .account_info_list td{ color: #a7b7c7; font-size: 12px; line-height: 60px; height: 60px; border-bottom: #34363f solid 1px; }
            .account_box .right_box .account_info_list .item_line:hover{ background: rgba(53, 124, 225, 0.21); }
            .account_box .right_box .account_info_list .title_line{ background: #191a1f; }
            .account_box .right_box .account_info_list .title_line td{ color: #697080; font-size: 18px; height: 84px; padding: 20px 0px; }
            .account_box .right_box .account_info_list .title_line td .account_info_title{ padding-left: 70px; background-image: url('/static/mobile/images/account_title_icon.png'); background-repeat: no-repeat; background-position: left center; background-size: 60px 60px; line-height: 30px; padding-top: 4px; font-size: 12px; }
            .account_box .right_box .account_info_list .title_line td .account_info_title span{ font-size: 20px; color: #a7b7c7; }
            .account_box .right_box .account_info_list .hold{ width: 20px; }
            .account_box .right_box .account_info_list .action_td{ text-align: right; }
            .account_box .right_box .account_info_list .action_td .action_btn{ color: #3B97E9; font-size: 12px; cursor: pointer; margin-left: 10px; }
            .account_box .right_box .account_info_list .action_td .action_btn:hover{ color: #357ce1; }
            .account_box .right_box .account_info_list .action_td .action_btn.off{ cursor: not-allowed; color: #697080; }
            .account_box .right_box .account_info_list .coin_icon{ width: 30px; }
            .account_box .right_box .account_info_list .coin_icon i{ font-weight: bold; }
            .account_box .right_box .account_info_list .success{ color: #05c19e; }
            .account_box .right_box .account_info_list .error{ color: #e04545; }
            .account_box .right_box .account_info_list .notice{ color: #D4B533; }

            
        </style>

        <div class="account_box">
            <div class="right_box">
                <table class="account_info_list" cellpadding="0" cellspacing="0" border="0">
                    <tr class="title_line">
                        <td class="hold"></td>
                        <td colspan="4">
                            <div class="account_info_title">
                                <span><?php echo $_SESSION["USER"]["USER_NAME"]; ?></span><br />
                                <?php echo lang('view_account_4'); ?>
                            </div>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon <?php echo $_SESSION['USER']['USER_PHONE'] == '' ? 'layui-icon-close error' : 'layui-icon-ok success'; ?>"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_5'); ?></td>
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn" href="/account/phone"><?php echo $_SESSION['USER']['USER_PHONE'] == '' ? lang('view_account_7') : lang('view_account_8'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon <?php echo $_SESSION['USER']['USER_EMAIL'] == '' ? 'layui-icon-close error' : 'layui-icon-ok success'; ?>"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_9'); ?></td>
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn" href="/account/email"><?php echo $_SESSION['USER']['USER_EMAIL'] == '' ? lang('view_account_11') : lang('view_account_12'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">

                            <i class="layui-icon <?php echo $user['user_auth'] == 0 ? 'layui-icon-close error' : ($user['user_auth'] == 1 ? 'layui-icon-help notice' : ($user['user_auth'] == 2 ? 'layui-icon-close error' : 'layui-icon-ok success')); ?>"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_13'); ?></td>
                        <td style=""></td>
                        <td class="action_td">

                            <?php if($user['user_auth'] != 3){ ?>
                                <a class="action_btn" href="/account/auth"><?php echo $user['user_auth'] == 0 ? lang('view_account_18') : lang('view_account_19'); ?></a>
                            <?php } ?>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon layui-icon-ok success"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_20'); ?></td>
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn" href="/account/repass"><?php echo lang('view_account_22'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon layui-icon-ok success"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_23'); ?></td>
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn" href="/account/reexpass"><?php echo lang('view_account_25'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <?php if($user['user_agent'] == 1){ ?>
                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon layui-icon-ok success"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_26'); ?></td>
                        <input type="hidden" class="invite_link" value="<?php echo base_url('/account/register'); ?>?i=<?php echo $user['user_invite_code']; ?>">
                        <input type="hidden" class="invite_code" value="<?php echo $user['user_invite_code']; ?>">
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn copy_code"><?php echo lang('view_account_27'); ?></a>
                            <a class="action_btn copy_link"><?php echo lang('view_account_28'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>

                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon">
                            <i class="layui-icon <?php echo $user['user_invite_count'] == 0 ? 'layui-icon-close error' : 'layui-icon-ok success'; ?>"></i>
                        </td>
                        <td style=""><?php echo lang('view_account_29'); ?></td>
                        <td style=""></td>
                        <td class="action_td">
                            <a class="action_btn" href="/account/invite"><?php echo lang('view_account_31'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>
                    <?php } ?>

                </table>

                <?php $this->load->view("mobile/account/account_safe_text"); ?>

                <style type="text/css">
                    .account_menu_logout{ display: block; margin: 20px; background: #e04545; color: #FFF; line-height: 40px; text-align: center; font-size: 16px; }
                </style>
                <a class="account_menu_logout" href="/account/logout">
                    <?php echo lang('view_account_menu_8'); ?>
                </a>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("mobile/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>
        <script src="<?php echo base_url('static/mobile'); ?>/js/clipboard.js" ></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.account').addClass('active');

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {

                var element = layui.element;
                var form    = layui.form;
                var layer   = layui.layer;
                
                //复制
                var clipboard =  new ClipboardJS('.copy_code', {
                    text: function() {
                        return $('.invite_code').val();
                    }
                });
                clipboard.on('success', function(e) {
                    _msg.success('<?php echo lang('view_account_32'); ?>');
                });

                var clipboard_2 =  new ClipboardJS('.copy_link', {
                    text: function() {
                        return $('.invite_link').val();
                    }
                });
                clipboard_2.on('success', function(e) {
                    _msg.success('<?php echo lang('view_account_33'); ?>');
                });
            });
        </script>
    </body>
</html>

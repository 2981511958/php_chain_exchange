<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo lang('view_account_asset_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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
            .account_box .right_box .asset_total{ background: #191a1f; color: #a7b7c7; line-height: 100px; border-bottom: #34363f solid 1px; padding-left: 50px; font-size: 20px; }
        </style>

        <div class="account_box">
            <div class="page_title"><?php echo lang('view_account_asset_2'); ?> / <?php echo lang('view_account_asset_3'); ?></div>
            <div class="right_box">

                <div class="asset_total">
                    <?php echo lang('asset_convert_total_text'); ?> <?php echo $userAssetUsdTotal; ?> USD
                </div>

                <table class="asset_list" cellpadding="0" cellspacing="0" border="0">
                    <tr class="title_line">
                        <td class="hold"></td>
                        <td class="coin_icon"></td>
                        <td style="width: 100px;"><?php echo lang('view_account_asset_4'); ?></td>
                        <td style="width: 150px;"><?php echo lang('view_account_asset_5'); ?></td>
                        <td style="width: 150px;"><?php echo lang('view_account_asset_6'); ?></td>
                        <td style="width: 150px;"><?php echo lang('view_account_asset_7'); ?></td>
                        <td style="width: 120px;"><?php echo lang('asset_convert_text'); ?>(USD)</td>
                        <td class="action_td"><?php echo lang('view_account_asset_8'); ?></td>
                        <td class="hold"></td>
                    </tr>

                    <?php if($userAsset && count($userAsset)){ foreach($userAsset as $asset){ ?>
                    <tr class="item_line">
                        <td class="hold"></td>
                        <td class="coin_icon"><img class="coin_icon_img" src="<?php echo $asset["coin_icon"]; ?>"></td>
                        <td style="width: 100px;"><?php echo $asset["coin_symbol"]; ?></td>
                        <td style="width: 150px;"><?php echo $asset["asset_total"]; ?></td>
                        <td style="width: 150px;"><?php echo $asset["asset_active"]; ?></td>
                        <td style="width: 150px;"><?php echo $asset["asset_frozen"]; ?></td>
                        <td style="width: 120px;"><?php echo $asset["asset_usd"]; ?></td>
                        <td class="action_td">
                            <?php if($asset['coin_recharge_status'] == '1'){ ?>
                                <a class="action_btn" href="/account/recharge/<?php echo strtolower($asset['coin_symbol']); ?>"><?php echo lang('view_account_asset_9'); ?></a>
                            <?php }else{ ?>
                                <a class="action_btn off"><?php echo lang('view_account_asset_10'); ?></a>
                            <?php } ?>

                            <?php if($asset['coin_withdraw_status'] == '1'){ ?>
                                <a class="action_btn" href="/account/withdraw/<?php echo strtolower($asset['coin_symbol']); ?>"><?php echo lang('view_account_asset_11'); ?></a>
                            <?php }else{ ?>
                                <a class="action_btn off"><?php echo lang('view_account_asset_12'); ?></a>
                            <?php } ?>
                            
                            <a class="action_btn" href="/account/record/<?php echo strtolower($asset['coin_symbol']); ?>"><?php echo lang('view_account_asset_13'); ?></a>
                        </td>
                        <td class="hold"></td>
                    </tr>
                    <?php }} ?>
                </table>

                <?php $this->load->view("front/account/account_safe_text"); ?>
            </div>
            <div class="left_box">
                <?php $this->load->view("front/account/asset_menu"); ?>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("front/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>

        <script type="text/javascript">

            //当前栏目
            $('header .left_box .nav_box .nav_item.asset').addClass('active');
            $('.account_menu_item.exchange').addClass('active');

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                
            });
        </script>
    </body>
</html>

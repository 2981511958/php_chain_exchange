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

            .asset_box{  }
            .asset_box .asset_item{ padding: 20px; border-bottom: #34363f solid 1px; }
            .asset_box .asset_item .asset_name{ position: relative; color: #d5def2; font-weight: bold; font-size: 22px; line-height: 40px; padding-bottom: 10px; }
            .asset_box .asset_item .asset_name img{ display: block; position: absolute; left: 0px; top: 7px; width: 25px; height: 25px; }
            .asset_box .asset_item .asset_left{ float: left; width: calc(100% / 3); font-size: 12px; text-align: left; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #aeb9d8; line-height: 25px; }
            .asset_box .asset_item .asset_center{ float: left; width: calc(100% / 3); font-size: 12px; text-align: left; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #aeb9d8; line-height: 25px; }
            .asset_box .asset_item .asset_right{ float: left; width: calc(100% / 3); font-size: 12px; text-align: right; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #aeb9d8; line-height: 25px; }
            .asset_box .asset_item .title_item{ color: #697080; }
            .asset_box .asset_item .action_btn{ display: block; float: left; line-height: 40px; padding-right: 20px; margin-right: 20px; margin-top: 10px; font-size: 14px; color: #357ce1; }
            .asset_box .asset_item .action_btn.off{ color: #697080; }

            .asset_box .account_safe_text{ padding: 20px; color: #697080; font-size: 14px; line-height: 25px; }
            .asset_box .account_safe_text i{ font-size: 14px; padding-right: 10px; font-weight: bold; }

            .asset_total{ background: #191a1f; color: #a7b7c7; line-height: 50px; border-top: #34363f solid 1px; text-align: center; font-size: 16px; }
            .asset_box .asset_usd{ color: #697080; font-size: 12px; margin-top: 5px; }
        </style>

        <header>
            <div class="market_list_btn"><?php echo lang('view_account_asset_3'); ?></div>
            <div class="clear"></div>
        </header>

        <div class="asset_box">

            <div class="asset_total">
                <?php echo lang('asset_convert_total_text'); ?> <?php echo $userAssetUsdTotal; ?> USD
            </div>

            <?php $this->load->view("mobile/account/asset_menu"); ?>

            <?php if($userAsset && count($userAsset)){ foreach($userAsset as $asset){ ?>
            <div class="asset_item">
                <div class="asset_name">
                    <?php echo $asset["coin_symbol"]; ?>
                </div>
                <div class="asset_left title_item"><?php echo lang('view_account_asset_5'); ?></div>
                <div class="asset_center title_item"><?php echo lang('view_account_asset_6'); ?></div>
                <div class="asset_right title_item"><?php echo lang('view_account_asset_7'); ?></div>
                <div class="clear"></div>
                <div class="asset_left"><?php echo $asset["asset_total"]; ?></div>
                <div class="asset_center"><?php echo $asset["asset_active"]; ?></div>
                <div class="asset_right"><?php echo $asset["asset_frozen"]; ?></div>
                <div class="clear"></div>
                <div class="asset_usd"><?php echo lang('asset_convert_text'); ?>: <?php echo $asset["asset_usd"]; ?> USD</div>
                <div class="clear"></div>

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

                <div class="clear"></div>
            </div>
            <?php }} ?>

            <?php $this->load->view("front/account/account_safe_text"); ?>
        </div>

        



        <?php $this->load->view("mobile/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.asset, .asset_box .account_menu .account_menu_item.exchange').addClass('active');

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                
            });
        </script>
    </body>
</html>

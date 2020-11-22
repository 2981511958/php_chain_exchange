<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo $assetSymbolText; ?> <?php echo lang('view_account_asset_record_1'); ?> - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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

            .account_box .back_link{ float: right; margin-right: 50px; }
            .account_box .back_link:hover{ color: #FFF; }

            .account_box .content_box{ min-height: 300px; border-bottom: #34363f solid 1px; }
            .account_box .page_paging_box{ padding: 50px 0px 0px 50px; }
        </style>

        <div class="account_box">
            <div class="page_title">
                <?php echo lang('view_account_asset_record_2'); ?> / <?php echo $assetSymbolText; ?> / <?php echo $coin['coin_symbol']; ?> <?php echo lang('view_account_asset_record_3'); ?>
                <a class="back_link" href="<?php echo $backUrl; ?>"><< <?php echo lang('view_account_asset_record_4'); ?></a>
            </div>
            <div class="right_box">
                <div class="content_box">
                    
                    <table class="asset_list" cellpadding="0" cellspacing="0" border="0">
                        <tr class="title_line">
                            <td class="hold"></td>
                            <td><?php echo lang('view_account_asset_record_5'); ?></td>
                            <td><?php echo lang('view_account_asset_record_6'); ?></td>
                            <td class="action_td"><?php echo lang('view_account_asset_record_7'); ?></td>
                            <td class="hold"></td>
                        </tr>

                        <?php if($recordList && count($recordList)){ foreach($recordList as $record){ ?>
                        <tr class="item_line">
                            <td class="hold"></td>
                            <td><?php echo date('Y-m-d H:i:s', $record["asset_log_time"]); ?></td>
                            <td>
                                <?php switch($record['asset_log_action']){

                                    case 1:
                                        echo lang('view_account_asset_record_8');
                                    break;

                                    case 2:
                                        echo lang('view_account_asset_record_9');
                                    break;

                                    case 3:
                                        echo lang('view_account_asset_record_10');
                                    break;

                                    case 4:
                                        echo lang('view_account_asset_record_11');
                                    break;

                                    case 5:
                                        echo lang('view_account_asset_record_12');
                                    break;

                                    case 6:
                                        echo lang('view_account_asset_record_13');
                                    break;

                                    case 7:
                                        echo lang('view_account_asset_record_14');
                                    break;

                                    case 8:
                                        echo lang('view_account_asset_record_15');
                                    break;

                                    case 9:
                                        echo lang('view_account_asset_record_16');
                                    break;

                                } ?>
                            </td>
                            <td class="action_td"><?php echo bccomp($record["asset_log_amount"], 0) > 0 ? ('+' . $record["asset_log_amount"]) : $record["asset_log_amount"]; ?></td>
                            <td class="hold"></td>
                        </tr>
                        <?php }} ?>
                    </table>

                    <div class="page_paging_box">
                        <!-- 通用分页 -->
                        <?php
                            if($recordCount > $pageSize){
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

        <script type="text/javascript">

            //当前栏目
            $('header .left_box .nav_box .nav_item.asset').addClass('active');
            $('.account_menu_item.<?php echo $assetSymbol; ?>').addClass('active');

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                
            });
        </script>
    </body>
</html>

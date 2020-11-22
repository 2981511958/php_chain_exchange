<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo $market['market_stock_symbol'] . '/' . $market['market_money_symbol'] . ' - ' . $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel='icon' href='/favicon.ico' type='image/x-ico' />

        <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/front'); ?>/style/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/front'); ?>/style/tv.css" />

        <!--[if lt IE 9]>
        <script src="<?php echo base_url('static/front'); ?>/js/css3.js"></script>
        <script src="<?php echo base_url('static/front'); ?>/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php $this->load->view('front/header'); ?>

        <div class="body_box">

            <style type="text/css">
                
                .body_box .exchange_box{ margin: 6px auto; width: 100%; min-width: 1300px; height: 800px; }
                .body_box .exchange_box .exchange_left_box{ height: 100%; float: left; box-sizing: border-box; width: 305px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box{ height: 100%; background: #1f2126; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_title{ background: #191a1f; height: 50px; font-size: 14px; overflow: hidden; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_title .money_list{ padding: 15px 0px 15px 10px; width: 300px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_title .money_list .money_item{ float: left; cursor: pointer; font-size: 12px; line-height: 20px; box-sizing: border-box; padding: 0px 5px; border: #191a1f solid 1px; color: #a7b7c7; margin-right: 5px; border-radius: 3px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_title .money_list .money_item:hover{ background: rgba(52,54,63,.7); color: #d5def2; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_title .money_list .money_item.active{ background: #357ce1; color: #FFF; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content{ height: 750px; overflow-x: hidden; overflow-y: auto; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_title{ padding: 0px 16px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_title .coin_symbol{ font-size: 12px; color: #697080; line-height: 30px; text-align: left; float: left; width: 20%; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_title .coin_price{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 45%; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_title .coin_rate{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 35%; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list{ display: none; height: 720px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list.active{ display: block; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item{ display: block; height: 28px; padding: 0px 16px; cursor: pointer; transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item.active, .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item:hover{ /*background: rgba(52,54,63,.5);*/ background: rgba(53, 124, 225, 0.21); }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item.active .coin_symbol{ color: #357ce1; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item .coin_symbol{ float: left; width: 20%; line-height: 28px; text-align: left; color: #a7b7c7; font-size: 12px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item .coin_price{ float: left; width: 45%; line-height: 28px; text-align: right; font-size: 12px; color: #a7b7c7; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item .coin_rate{ float: left; width: 35%; line-height: 28px; text-align: right; font-size: 12px; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item .price_up{ color: #05c19e; }
                .body_box .exchange_box .exchange_left_box .exchange_market_box .box_content .market_list .market_item .price_down{ color: #e04545; }

                @media screen and (min-width: 1700px) {
                    .body_box .exchange_box .exchange_center_box{ height: 100%; float: left; box-sizing: border-box; width: calc(100% - 983px); margin-left: 6px; }
                }

                @media screen and (max-width: 1700px) {
                    .body_box .exchange_box .exchange_center_box{ height: 100%; float: left; box-sizing: border-box; width: calc(100% - 647px); margin-left: 6px; }
                }
                .body_box .exchange_box .exchange_center_box .exchange_kline_box{ height: 494px; background: #1f2126; }
                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar{ background: #191a1f; padding-left: 10px; }
                
                .body_box .exchange_box .exchange_center_box .exchange_trade_box{ height: 300px; background: #1f2126; margin-top: 6px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_type_list{ background: #191a1f; font-size: 14px; color: #d5def2; padding: 0px 16px; height: 50px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_type_list .trade_item{ float: left; line-height: 50px; margin-right: 20px; color: #a7b7c7; cursor: pointer; height: 50px; box-sizing: border-box; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_type_list .trade_item:hover{ color: #d5def2; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_type_list .trade_item.active{ color: #d5def2; height: 40px; border-bottom: #357ce1 solid 2px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item{ display: none; height: 250px; overflow: hidden; position: relative; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item.active{ display: block; }
                
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .center_line{ height: 200px; width: 0px; border-left: dashed #697080 1px; position: absolute; left: 50%; top: 25px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box{ padding-top: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_center_box{ padding: 0px 16px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_balance_box{ height: 30px; margin-bottom: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_balance_box .trade_balance_label{ line-height: 30px; text-align: left; width: 50px; float: left; color: #697080; font-size: 12px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_balance_box .trade_balance_value{ line-height: 30px; float: left; text-align: left; color: #d5def2; font-size: 14px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box{ height: 30px; overflow: hidden; margin-bottom: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_label{ color: #697080; font-size: 12px; line-height: 30px; float: left; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box{ float: right; width: calc(100% - 50px); position: relative; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box .trade_input_ele{ display: block; font-size: 12px; line-height: 20px; border: #3f4254 solid 1px; border-radius: 2px; height: 20px; padding: 4px 0px 4px 8px; background: rgba(25,26,31,.2); color: #d5def2; width: calc(100% - 10px); caret-color: #357ce1; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box .trade_input_ele.disabled{ border: #191a1f solid 1px; background: #191a1f; -moz-user-select:none; -webkit-user-select:none; -ms-user-select:none; -khtml-user-select:none; user-select:none; cursor: not-allowed; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box .trade_input_ele.disabled::placeholder{ color: #697080; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box .trade_input_ele:focus{ border-color: #357ce1; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_input_box .trade_input_ele_box .trade_input_unit{ color: #697080; font-size: 12px; line-height: 30px; position: absolute; right: 0px; top: 0px; padding-right: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_rate_box{ margin-left: 50px; width: calc(100% - 40px); }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_rate_box .trade_amount_rate_item{ float: left; font-size: 12px; color: #3f4254; line-height: 20px; border: #3f4254 solid 1px; border-radius: 2px; margin-right: 10px; width: calc((100% - 48px) / 4); text-align: center; cursor: pointer;}
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_rate_box .trade_amount_rate_item:hover{ color: #FFF; border-color: #357ce1; background: #357ce1; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_total_box{ height: 30px; margin-top: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_total_box .trade_amount_total_label{ line-height: 30px; text-align: left; width: 50px; float: left; color: #697080; font-size: 12px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_amount_total_box .trade_amount_total_value{ line-height: 30px; float: left; text-align: left; color: #d5def2; font-size: 14px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .trade_type_box .trade_button{ display: block; line-height: 30px; height: 30px; text-align: center; color: #FFF; border-radius: 3px; cursor: pointer; margin-top: 10px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item.market_trade .trade_type_box .trade_button{ margin-top: 50px; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box{ width: calc(50% - 1px); float: left; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button{ background: #05c19e; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button:hover{ background: #0ca678; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button:active{ background: #099268; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button .trade_btn_load{ display: none; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button.off{ background: #099268 !important; cursor: not-allowed; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button.off .trade_btn_load{ display: inline-block; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .ask_box .trade_button.off .trade_btn_text{ display: none; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box{ width: 50%; float: right; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button{ background: #e04545; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button:hover{ background: #f03e3e; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button:active{ background: #e03131; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button .trade_btn_load{ display: none; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button.off{ background: #e03131 !important; cursor: not-allowed; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button.off .trade_btn_load{ display: inline-block; }
                .body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_content_item .bid_box .trade_button.off .trade_btn_text{ display: none; }

                

            </style>
            
            <div class="exchange_box">
                <div class="exchange_left_box">
                    <div class="exchange_market_box">
                        <div class="box_title">
                            <div class="money_list">

                                <?php if($marketGroup && count($marketGroup)){ foreach($marketGroup as $money => $marketsItem){ ?>
                                <div class="money_item <?php echo $market['market_money_symbol'] == $money ? 'active' : ''; ?>" target-content="exchange_market_content_<?php echo $money; ?>"><?php echo $money; ?></div>
                                <?php }} ?>

                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="box_content">
                            <div class="market_title">
                                <div class="coin_symbol"><?php echo lang('view_exchange_1'); ?></div>
                                <div class="coin_price"><?php echo lang('view_exchange_2'); ?></div>
                                <div class="coin_rate"><?php echo lang('view_exchange_3'); ?></div>
                                <div class="clear"></div>
                            </div>

                            <?php if($marketGroup && count($marketGroup)){ foreach($marketGroup as $money => $marketsItem){ ?>
                            <div class="market_list <?php echo $market['market_money_symbol'] == $money ? 'active' : ''; ?>" id="exchange_market_content_<?php echo $money; ?>">

                                <?php foreach($marketsItem as $marketItem){ ?>
                                <a id="exchange_market_line_item_<?php echo $marketItem['market_stock_symbol']; ?><?php echo $marketItem['market_money_symbol']; ?>" href="/exchange/<?php echo strtolower($marketItem['market_stock_symbol']); ?>/<?php echo strtolower($marketItem['market_money_symbol']); ?>" class="market_item <?php echo $marketItem['market_id'] == $market['market_id'] ? 'active' : ''; ?>">
                                    <div class="coin_symbol"><?php echo $marketItem['market_stock_symbol']; ?></div>
                                    <div class="coin_price">--</div>
                                    <div class="coin_rate price_up">--</div>
                                    <div class="clear"></div>
                                </a>
                                <?php } ?>
                            </div>
                            <?php }} ?>
                            
                        </div>
                    </div>
                </div>
                <div class="exchange_center_box">
                    <div class="exchange_kline_box">
                        <div class="market_info_bar">

                            <style type="text/css">

                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail{ min-width: 643px; max-height: 50px; overflow: hidden; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail td{ padding-right: 20px; text-align: left; font-size: 12px; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail td span{ font-size: 12px; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .current_market_info_title{ color: #697080; vertical-align: bottom; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .current_market_info_value{ color: #a7b7c7; vertical-align: top; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .price_up{ color: #05c19e; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .price_down{ color: #e04545; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .current_market_name{ color: #d5def2; font-size: 16px; line-height: 50px; }
                                .body_box .exchange_box .exchange_center_box .exchange_kline_box .market_info_bar .market_detail .current_market_price{ font-size: 16px; line-height: 50px; }

                            </style>
                            <div class="market_detail">

                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td rowspan="2" class="current_market_name"><?php echo $market['market_stock_symbol']; ?>/<?php echo $market['market_money_symbol']; ?></td>
                                        <td rowspan="2" class="current_market_price price_up">--</td>
                                        <td class="current_market_info_title"><?php echo lang('view_exchange_4'); ?></td>
                                        <td class="current_market_info_title"><?php echo lang('view_exchange_5'); ?></td>
                                        <td class="current_market_info_title"><?php echo lang('view_exchange_6'); ?></td>
                                        <td class="current_market_info_title"><?php echo lang('view_exchange_7'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="current_market_info_value current_market_rate price_up">--</td>
                                        <td class="current_market_info_value current_market_24_high">--</td>
                                        <td class="current_market_info_value current_market_24_low">--</td>
                                        <td class="current_market_info_value">
                                            <span class="current_market_24_vol">--</span> <?php echo $market['market_stock_symbol']; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <style type="text/css">
                            
                            .body_box .exchange_box .exchange_center_box .exchange_kline_box .tv_box{ height: 444px; overflow: hidden; }

                        </style>

                        <div class="tv_box">
                            
                            <div class="main-wrapper black">
                                <div class="tv-wrapper ">
                                    <div class="tv-top-bar">
                                        <ul class="tv-interval-list border-right" id="intervalWrapper">
                                            <li class="interval-item border-right" data-interval="1" data-chartType="3">Time</li>
                                            <li class="interval-item" data-interval="1" data-chartType="1">1min</li>
                                            <li class="interval-item active" data-interval="5" data-chartType="1">5min</li>
                                            <li class="interval-item" data-interval="15" data-chartType="1">15min</li>
                                            <li class="interval-item" data-interval="30" data-chartType="1">30min</li>
                                            <li class="interval-item" data-interval="60" data-chartType="1">1hour</li>
                                            <li class="interval-item" data-interval="240" data-chartType="1">4hour</li>
                                            <li class="interval-item" data-interval="D" data-chartType="1">1day</li>
                                            <li class="interval-item" data-interval="W" data-chartType="1">1week</li>
                                        </ul>
                                        <div class="tv-more-btn-wrapper">
                                            <span class="tv-more-btn indicator-btn border-left" id="indicator"></span>
                                            <span class="tv-more-btn setting-btn border-left" id="tvSetting"></span>
                                            <span class="tv-more-btn fullscreen-btn border-left" id="fullscreen"></span>
                                        </div>
                                    </div>
                                    <div class="TradingView">
                                        <div id="tv-container"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="exchange_trade_box">
                        <div class="trade_type_list">
                            <div class="trade_item" target-content="exchange_trade_content_box_1"><?php echo lang('view_exchange_8'); ?></div>
                            <div class="trade_item active" target-content="exchange_trade_content_box_2"><?php echo lang('view_exchange_9'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <!-- 限价交易 -->
                        <div class="trade_content_item limit_trade" id="exchange_trade_content_box_1">
                            <div class="trade_type_box ask_box">
                                <div class="trade_center_box">
                                    <div class="trade_balance_box">
                                        <div class="trade_balance_label"><?php echo lang('view_exchange_11'); ?></div>
                                        <div class="trade_balance_value"><span class="<?php echo $market['market_money_symbol']; ?>_balance trade_balance_item">0.00000000</span> <?php echo $market['market_money_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_12'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="limit_buy_price" data-compute="1" autocomplete="off" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">
                                            <div class="trade_input_unit"><?php echo $market['market_money_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_13'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="limit_buy_count" data-compute="1" autocomplete="off" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">
                                            <div class="trade_input_unit"><?php echo $market['market_stock_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_rate_box">
                                        <div class="trade_amount_rate_item" data-rate="0.25" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">25%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.50" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">50%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.75" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">75%</div>
                                        <div class="trade_amount_rate_item" data-rate="1" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount">100%</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_total_box">
                                        <div class="trade_amount_total_label"><?php echo lang('view_exchange_14'); ?></div>
                                        <div class="trade_amount_total_value"><span id="limit_buy_amount">0.00000000</span> <?php echo $market['market_money_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>

                                    <?php if(isset($_SESSION['USER'])){ ?>
                                        <div class="trade_button limit_trade_btn" data-price="#limit_buy_price" data-count="#limit_buy_count" data-amount="#limit_buy_amount" data-trade-type="limit" data-type="buy">
                                            <span class="trade_btn_text"><?php echo lang('view_exchange_15'); ?> <?php echo $market['market_stock_symbol']; ?></span>
                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop trade_btn_load"></i>
                                        </div>
                                    <?php }else{ ?>
                                        <a class="trade_button" href="/account/login"><?php echo lang('view_exchange_16'); ?></a>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                            <div class="trade_type_box bid_box">
                                <div class="trade_center_box">
                                    <div class="trade_balance_box">
                                        <div class="trade_balance_label"><?php echo lang('view_exchange_17'); ?></div>
                                        <div class="trade_balance_value"><span class="<?php echo $market['market_stock_symbol']; ?>_balance trade_balance_item">0.00000000</span> <?php echo $market['market_stock_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_18'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="limit_sell_price" data-compute="1" autocomplete="off" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">
                                            <div class="trade_input_unit"><?php echo $market['market_money_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_19'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="limit_sell_count" data-compute="1" autocomplete="off" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">
                                            <div class="trade_input_unit"><?php echo $market['market_stock_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_rate_box">
                                        <div class="trade_amount_rate_item" data-rate="0.25" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">25%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.50" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">50%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.75" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">75%</div>
                                        <div class="trade_amount_rate_item" data-rate="1" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount">100%</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_total_box">
                                        <div class="trade_amount_total_label"><?php echo lang('view_exchange_20'); ?></div>
                                        <div class="trade_amount_total_value"><span id="limit_sell_amount">0.00000000</span> <?php echo $market['market_money_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>

                                    <?php if(isset($_SESSION['USER'])){ ?>
                                        <div class="trade_button limit_trade_btn" data-price="#limit_sell_price" data-count="#limit_sell_count" data-amount="#limit_sell_amount" data-trade-type="limit" data-type="sell">
                                            <span class="trade_btn_text"><?php echo lang('view_exchange_21'); ?> <?php echo $market['market_stock_symbol']; ?></span>
                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop trade_btn_load"></i>
                                        </div>
                                    <?php }else{ ?>
                                        <a class="trade_button" href="/account/login"><?php echo lang('view_exchange_22'); ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="center_line"></div>
                        </div>
                        <div class="trade_content_item market_trade active" id="exchange_trade_content_box_2">
                            <div class="trade_type_box ask_box">
                                <div class="trade_center_box">
                                    <div class="trade_balance_box">
                                        <div class="trade_balance_label"><?php echo lang('view_exchange_23'); ?></div>
                                        <div class="trade_balance_value"><span class="<?php echo $market['market_money_symbol']; ?>_balance trade_balance_item">0.00000000</span> <?php echo $market['market_money_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_24'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele disabled" autocomplete="off" placeholder="<?php echo lang('view_exchange_25'); ?>" disabled>
                                            <div class="trade_input_unit"><?php echo $market['market_money_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_26'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="market_buy_amount" data-compute="0" autocomplete="off">
                                            <div class="trade_input_unit"><?php echo $market['market_money_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_rate_box">
                                        <div class="trade_amount_rate_item" data-rate="0.25">25%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.50">50%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.75">75%</div>
                                        <div class="trade_amount_rate_item" data-rate="1">100%</div>
                                        <div class="clear"></div>
                                    </div>

                                    <?php if(isset($_SESSION['USER'])){ ?>
                                        <div class="trade_button market_trade_btn" data-trade-type="market" data-type="buy" data-input="#market_buy_amount">
                                            <span class="trade_btn_text"><?php echo lang('view_exchange_27'); ?> <?php echo $market['market_stock_symbol']; ?></span>
                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop trade_btn_load"></i>
                                        </div>
                                    <?php }else{ ?>
                                        <a class="trade_button" href="/account/login"><?php echo lang('view_exchange_28'); ?></a>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                            <div class="trade_type_box bid_box">
                                <div class="trade_center_box">
                                    <div class="trade_balance_box">
                                        <div class="trade_balance_label"><?php echo lang('view_exchange_29'); ?></div>
                                        <div class="trade_balance_value"><span class="<?php echo $market['market_stock_symbol']; ?>_balance trade_balance_item">0.00000000</span> <?php echo $market['market_stock_symbol']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_30'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele disabled" autocomplete="off" placeholder="<?php echo lang('view_exchange_31'); ?>" disabled>
                                            <div class="trade_input_unit"><?php echo $market['market_money_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_input_box">
                                        <div class="trade_input_label"><?php echo lang('view_exchange_32'); ?></div>
                                        <div class="trade_input_ele_box">
                                            <input type="text" class="trade_input_ele" id="market_sell_count" data-compute="0" autocomplete="off">
                                            <div class="trade_input_unit"><?php echo $market['market_stock_symbol']; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="trade_amount_rate_box">
                                        <div class="trade_amount_rate_item" data-rate="0.25">25%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.50">50%</div>
                                        <div class="trade_amount_rate_item" data-rate="0.75">75%</div>
                                        <div class="trade_amount_rate_item" data-rate="1">100%</div>
                                        <div class="clear"></div>
                                    </div>
                                    
                                    <?php if(isset($_SESSION['USER'])){ ?>
                                        <div class="trade_button market_trade_btn" data-trade-type="market" data-type="sell" data-input="#market_sell_count">
                                            <span class="trade_btn_text"><?php echo lang('view_exchange_33'); ?> <?php echo $market['market_stock_symbol']; ?></span>
                                            <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop trade_btn_load"></i>
                                        </div>
                                    <?php }else{ ?>
                                        <a class="trade_button" href="/account/login"><?php echo lang('view_exchange_34'); ?></a>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="center_line"></div>
                        </div>
                    </div>
                </div>

                <style type="text/css">

                    @media screen and (min-width: 1700px) {
                        .body_box .exchange_box .exchange_right_box{ height: 100%; float: right; box-sizing: border-box; width: 666px; position: relative; }
                    }
                    @media screen and (max-width: 1700px) {
                        .body_box .exchange_box .exchange_right_box{ height: 100%; float: right; box-sizing: border-box; width: 330px; position: relative; }
                    }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box{ height: 100%; width: 330px; float: right; background: #1f2126; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .box_title{ background: #191a1f; font-size: 14px; color: #d5def2; padding: 0px 15px; line-height: 50px; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_title{ padding: 0px 16px; height: 30px; overflow: hidden; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_title .deal_time{ font-size: 12px; color: #697080; line-height: 30px; text-align: left; float: left; width: 20%; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_title .deal_price{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 35%; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_title .deal_amount{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 45%; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list{ height: 720px; overflow: hidden; padding: 0px 16px 0px 15px; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item{ cursor: pointer; transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item:hover{ background: rgba(52,54,63,.5); }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item .deal_time{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: left; float: left; width: 20%; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item .deal_price{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 35%; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item .deal_price.price_up{ color: #05c19e; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item .deal_price.price_down{ color: #e04545; }
                    .body_box .exchange_box .exchange_right_box .exchange_deal_box .deal_list .deal_item .deal_amount{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 45%; }

                    @media screen and (min-width: 1700px) {
                        .body_box .exchange_box .exchange_right_box .exchange_price_box{ display: block !important; height: 100%; width: 330px; float: left; background: #1f2126; }
                    }
                    @media screen and (max-width: 1700px) {
                        .body_box .exchange_box .exchange_right_box .exchange_price_box{ height: 100%; width: 330px; background: #1f2126; position: absolute; top: 0px; right: 0px; }
                    }
                    
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .box_title{ background: #191a1f; font-size: 14px; color: #d5def2; padding: 0px 15px; line-height: 50px; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .price_title{  }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .price_title{ padding: 0px 16px; height: 30px; overflow: hidden; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .price_title .price_text{ font-size: 12px; color: #697080; line-height: 30px; text-align: left; float: left; width: 30%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .price_title .amount_text{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 30%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .price_title .amount_sum_text{ font-size: 12px; color: #697080; line-height: 30px; text-align: right; float: left; width: 40%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list{ height: 340px; overflow: hidden; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item{ cursor: pointer; padding: 0px 16px; height: 20px; transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; position: relative; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item:hover{ background: rgba(52,54,63,.5); }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item .price_text{ font-size: 12px; color: #e04545; line-height: 20px; text-align: left; float: left; width: 20%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item .amount_text{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 40%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item .amount_sum_text{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 40%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .bid_price_list .bid_price_item .amount_sum_rate_shadow{ height: 20px; position: absolute; top: 0px; right: 0px; background: rgba(212, 48, 42, .1); max-width: 100% !important; transition: none; -moz-transition: none; -webkit-transition: none; -o-transition: none; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .current_price_info{ height: 40px; box-sizing: border-box; border-top: #191a1f solid 2px; border-bottom: #191a1f solid 2px; padding-left: 16px; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .current_price_info .current_price{ font-size: 18px; line-height: 40px; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .current_price_info .current_price.price_up{ color: #05c19e; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .current_price_info .current_price.price_down{ color: #e04545; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .current_price_info .current_cny_price{ color: #697080; font-size: 14px; line-height: 40px; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item{ cursor: pointer; padding: 0px 16px; height: 20px; transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; position: relative; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item:hover{ background: rgba(52,54,63,.5); }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item .price_text{ font-size: 12px; color: #05c19e; line-height: 20px; text-align: left; float: left; width: 20%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item .amount_text{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 40%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item .amount_sum_text{ font-size: 12px; color: #a7b7c7; line-height: 20px; text-align: right; float: left; width: 40%; }
                    .body_box .exchange_box .exchange_right_box .exchange_price_box .ask_price_list .ask_price_item .amount_sum_rate_shadow{ height: 20px; position: absolute; top: 0px; right: 0px; background: rgba(5, 193, 158, .1); max-width: 100% !important; transition: none; -moz-transition: none; -webkit-transition: none; -o-transition: none; }


                    @media screen and (min-width: 1700px) {
                        
                    }
                    @media screen and (max-width: 1700px) {
                        
                    }

                </style>
                <div class="exchange_right_box">
                    <div class="exchange_deal_box">
                        <div class="box_title"><?php echo lang('view_exchange_35'); ?></div>
                        <div class="deal_position">
                            <div class="deal_title">
                                <div class="deal_time"><?php echo lang('view_exchange_36'); ?></div>
                                <div class="deal_price"><?php echo lang('view_exchange_37'); ?>(<?php echo $market['market_money_symbol']; ?>)</div>
                                <div class="deal_amount"><?php echo lang('view_exchange_38'); ?>(<?php echo $market['market_stock_symbol']; ?>)</div>
                                <div class="clear"></div>
                            </div>
                            <div class="deal_list">
                                
                                <!-- <div class="deal_item">
                                    <div class="deal_time">18:33:41</div>
                                    <div class="deal_price price_up">9365.83</div>
                                    <div class="deal_amount">3.4815</div>
                                    <div class="clear"></div>
                                </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="exchange_price_box">
                        <div class="box_title"><?php echo lang('view_exchange_39'); ?></div>
                        <div class="price_title">
                            <div class="price_text"><?php echo lang('view_exchange_40'); ?></div>
                            <div class="amount_text"><?php echo lang('view_exchange_41'); ?>(<?php echo $market['market_money_symbol']; ?>)</div>
                            <div class="amount_sum_text"><?php echo lang('view_exchange_42'); ?>(<?php echo $market['market_stock_symbol']; ?>)</div>
                            <div class="clear"></div>
                        </div>
                        <div class="bid_price_list">
                            <div class="bid_price_item">
                                <div id="bid_price_item_16">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>17</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_15">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>16</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_14">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>15</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_13">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>14</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_12">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>13</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_11">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>12</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_10">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>11</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_9">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>10</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_8">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>9</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_7">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>8</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_6">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>7</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_5">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>6</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_4">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>5</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_3">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>4</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_2">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>3</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_1">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>2</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="bid_price_item">
                                <div id="bid_price_item_0">
                                    <div class="price_text"><?php echo lang('view_exchange_43'); ?>1</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="current_price_info">
                            <span class="current_price price_up">--</span>
                        </div>

                        <div class="ask_price_list">
                            <div class="ask_price_item">
                                <div id="ask_price_item_0">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>1</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_1">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>2</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_2">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>3</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_3">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>4</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_4">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>5</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_5">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>6</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_6">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>7</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_7">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>8</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_8">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>9</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_9">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>10</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_10">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>11</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_11">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>12</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_12">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>13</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_13">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>14</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_14">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>15</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_15">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>16</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                            <div class="ask_price_item">
                                <div id="ask_price_item_16">
                                    <div class="price_text"><?php echo lang('view_exchange_44'); ?>17</div>
                                    <div class="amount_text">--</div>
                                    <div class="amount_sum_text">--</div>
                                    <div class="clear"></div>
                                    <div class="amount_sum_rate_shadow" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style type="text/css">
                        @media screen and (min-width: 1700px) {
                            .body_box .exchange_box .exchange_right_box .exchange_right_position_tab{ display: none; }
                        }
                        @media screen and (max-width: 1700px) {
                            .body_box .exchange_box .exchange_right_box .exchange_right_position_tab{ display: block; background: #191a1f; font-size: 14px; color: #d5def2; height: 50px; position: absolute; right: 0px; top: 0px; width: 330px; }
                            .body_box .exchange_box .exchange_right_box .exchange_right_position_tab .position_tab_item{ float: left; line-height: 48px; width: 50%; text-align: center; cursor: pointer; box-sizing: border-box; border-top: #191a1f solid 2px; }
                            .body_box .exchange_box .exchange_right_box .exchange_right_position_tab .position_tab_item.active{ border-top: #3B97E9 solid 2px; line-height: 48px; background: #1f2126; }
                        }
                    </style>
                    <div class="exchange_right_position_tab">
                        <div class="position_tab_item active" price-box-status="1"><?php echo lang('view_exchange_45'); ?></div>
                        <div class="position_tab_item" price-box-status="0"><?php echo lang('view_exchange_46'); ?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            
            <style type="text/css">
                .body_box .exchange_bottom_box{ background: #1f2126; margin-bottom: 6px; }
                .body_box .exchange_bottom_box .order_tab_box{ background: #191a1f; font-size: 14px; color: #a7b7c7; height: 50px; padding-left: 20px; }
                .body_box .exchange_bottom_box .order_tab_box .order_tab_item{ float: left; line-height: 48px; cursor: pointer; box-sizing: border-box; border-top: #191a1f solid 2px; margin-right: 20px; }
                .body_box .exchange_bottom_box .order_tab_box .order_tab_item.active{ border-bottom: #357ce1 solid 2px; height: 46px; color: #d5def2; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item{ display: none; min-height: 300px; padding: 10px 0px; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item.active{ display: block; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table{ width: 100%; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table td{ line-height: 40px; height: 40px; color: #a7b7c7; text-align: left; font-size: 12px; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .hold{ width: 20px; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .action_td{ text-align: right; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .action_td a{ cursor: pointer; color: #357ce1; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .action_td a:hover{ color: #FFF; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .action_td a.off{ cursor: not-allowed; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .title_line td{ color: #697080; font-size: 12px; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .item_line:hover{ background: rgba(53, 124, 225, 0.21); }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .buy{ color: #05c19e; }
                .body_box .exchange_bottom_box .order_tab_content_box .order_tab_content_item table .sell{ color: #e04545; }
            </style>

            <!-- 委托记录 -->
            <div class="exchange_bottom_box">

                <div class="order_tab_box">
                    <div class="order_tab_item active" target-content="order_tab_content_current"><?php echo lang('view_exchange_47'); ?></div>
                    <div class="order_tab_item" target-content="order_tab_content_history"><?php echo lang('view_exchange_48'); ?></div>
                </div>

                <div class="order_tab_content_box">
                    <div class="order_tab_content_item active" id="order_tab_content_current">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr class="title_line">
                                <td class="hold"></td>
                                <td><?php echo lang('view_exchange_49'); ?></td>
                                <td><?php echo lang('view_exchange_50'); ?></td>
                                <td><?php echo lang('view_exchange_51'); ?></td>
                                <td><?php echo lang('view_exchange_52'); ?></td>
                                <td><?php echo lang('view_exchange_53'); ?>(<?php echo $market['market_money_symbol']; ?>)</td>
                                <td><?php echo lang('view_exchange_54'); ?>(<?php echo $market['market_stock_symbol']; ?>)</td>
                                <td><?php echo lang('view_exchange_55'); ?></td>
                                <td class="action_td"><?php echo lang('view_exchange_56'); ?></td>
                                <td class="hold"></td>
                            </tr>
                            <!-- 
                            <tr class="item_line">
                                <td class="hold"></td>
                                <td>2020/06/02</td>
                                <td>BTC/USDT</td>
                                <td>市价</td>
                                <td class=" sell">卖出</td>
                                <td>9500.1234</td>
                                <td>3.233</td>
                                <td>70%</td>
                                <td class="action_td">
                                    <a class="order_cancel">撤回</a>
                                </td>
                                <td class="hold"></td>
                            </tr>
                             -->
                        </table>
                    </div>
                    <div class="order_tab_content_item" id="order_tab_content_history">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr class="title_line">
                                <td class="hold"></td>
                                <td><?php echo lang('view_exchange_57'); ?></td>
                                <td><?php echo lang('view_exchange_58'); ?></td>
                                <td><?php echo lang('view_exchange_59'); ?></td>
                                <td><?php echo lang('view_exchange_60'); ?></td>
                                <td><?php echo lang('view_exchange_61'); ?>(<?php echo $market['market_money_symbol']; ?>)</td>
                                <td><?php echo lang('view_exchange_62'); ?>(<?php echo $market['market_stock_symbol']; ?>)</td>
                                <td><?php echo lang('view_exchange_63'); ?>(<?php echo $market['market_money_symbol']; ?>)</td>
                                <td class="action_td"><?php echo lang('view_exchange_64'); ?>(<?php echo $market['market_money_symbol']; ?>)</td>
                                <td class="hold"></td>
                            </tr>
                            <!-- 
                            <tr class="item_line">
                                <td class="hold"></td>
                                <td>2020/06/02</td>
                                <td>BTC/USDT</td>
                                <td>市价</td>
                                <td class=" sell">卖出</td>
                                <td>9500.1234</td>
                                <td>3.233</td>
                                <td>1234</td>
                                <td class="action_td">30713.5</td>
                                <td class="hold"></td>
                            </tr>
                             -->
                        </table>
                    </div>
                </div>

            </div>

        </div>

        <?php $this->load->view('front/footer'); ?>

        <script src="<?php echo base_url('static'); ?>/front/js/bignumber.min.js"></script>

        <script type="text/javascript">

            var title_text = $('title').text();

            //当前栏目
            $('header .left_box .nav_box .nav_item.exchange').addClass('active');

            //市场货币切换
            $('.body_box .exchange_box .exchange_left_box .exchange_market_box .box_title .money_list .money_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            $('.body_box .exchange_box .exchange_right_box .exchange_right_position_tab .position_tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    if (parseInt(_this.attr('price-box-status'))) {

                        $('.body_box .exchange_box .exchange_right_box .exchange_price_box').show();
                    }else{

                        $('.body_box .exchange_box .exchange_right_box .exchange_price_box').hide();
                    }

                    _this.addClass('active').siblings('.active').removeClass('active');
                }
            });

            //交易窗口切换
            $('.body_box .exchange_bottom_box .order_tab_box .order_tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            //订单窗口切换
            $('.body_box .exchange_box .exchange_center_box .exchange_trade_box .trade_type_list .trade_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            //监听输入
            $('#limit_buy_price, #limit_buy_count, #limit_sell_price, #limit_sell_count, #market_buy_amount, #market_sell_count').keyup(function(){

                var _this = $(this);

                format_input_num(_this[0]);

                if (parseInt(_this.attr('data-compute'))) {

                    computeAmount($(_this.attr('data-price')), $(_this.attr('data-count')), $(_this.attr('data-amount')));
                }
            });

            //监听点击限价百分比
            $('.limit_trade .ask_box .trade_amount_rate_item').click(function(){

                var _this = $(this);

                var _balance = parseFloat(_this.parent().siblings('.trade_balance_box').find('.trade_balance_item').text());

                if (_balance > 0) {

                    var _priceObj = $(_this.attr('data-price'));
                    var _countObj = $(_this.attr('data-count'));
                    var _amountObj = $(_this.attr('data-amount'));

                    if (_priceObj.val() != '') {

                        var _price = parseFloat(_priceObj.val());

                        if (_price > 0) {

                            var _rate = parseFloat(_this.attr('data-rate'));
                            var _amount = _balance * _rate;
                            var _count = parseFloat((_amount / _price).toFixed(8));

                            _countObj.val(_count);
                            _amountObj.text(_amount.toFixed(8));
                        }
                    }
                }
            });
            $('.limit_trade .bid_box .trade_amount_rate_item').click(function(){

                var _this = $(this);

                var _balance = parseFloat(_this.parent().siblings('.trade_balance_box').find('.trade_balance_item').text());

                if (_balance > 0) {

                    var _priceObj = $(_this.attr('data-price'));
                    var _countObj = $(_this.attr('data-count'));
                    var _amountObj = $(_this.attr('data-amount'));

                    if (_priceObj.val() != '') {

                        var _price = parseFloat(_priceObj.val());

                        if (_price > 0) {

                            var _rate = parseFloat(_this.attr('data-rate'));
                            var _count = parseFloat((_balance * _rate).toFixed(8));
                            var _amount = _price * _count;

                            _countObj.val(_count);
                            _amountObj.text(_amount.toFixed(8));
                        }
                    }
                }
            });
            $('.market_trade .trade_amount_rate_item').click(function(){

                var _this = $(this);

                var _balance = parseFloat(_this.parent().siblings('.trade_balance_box').find('.trade_balance_item').text());

                if (_balance > 0) {

                    var _rate = parseFloat(_this.attr('data-rate'));
                    var _result = parseFloat((_balance * _rate).toFixed(8));

                    _this.parent().parent().find('input').eq(1).val(_result);
                }
            });

            //限价交易
            $('.limit_trade_btn').click(function(){

                var _this = $(this);

                if (! _this.hasClass('off')) {

                    var _priceObj = $(_this.attr('data-price'));
                    var _countObj = $(_this.attr('data-count'));

                    if(_priceObj.val() == ''){

                        _msg.error('<?php echo lang('view_exchange_65'); ?>' + (_this.attr('data-type') == 'sell' ? '<?php echo lang('view_exchange_66'); ?>' : '<?php echo lang('view_exchange_67'); ?>'));
                        return false;
                    }

                    if(_countObj.val() == ''){

                        _msg.error('<?php echo lang('view_exchange_68'); ?>' + (_this.attr('data-type') == 'sell' ? '<?php echo lang('view_exchange_69'); ?>' : '<?php echo lang('view_exchange_70'); ?>'));
                        return false;
                    }

                    _this.addClass('off');

                    $.ajax({
                        url: '/exchange/trade',
                        type: 'post',
                        data: {
                            'type' : _this.attr('data-type'),
                            'trade_type' : 'limit',
                            'price' : _priceObj.val(),
                            'count' : _countObj.val(),
                            'market_stock' : '<?php echo $market['market_stock_symbol']; ?>',
                            'market_money' : '<?php echo $market['market_money_symbol']; ?>'
                        },
                        dataType: 'json',
                        success: function (data) {
                            
                            if (data.status) {

                                _msg.success(data.message);
                            }else{

                                _msg.error(data.message);
                            }
                        },
                        error: function(){

                            _msg.error('<?php echo lang('view_exchange_71'); ?>');
                        },
                        complete: function(){

                            _this.removeClass('off');
                        }
                    });
                }
            });

            //市价交易
            $('.market_trade_btn').click(function(){

                var _this = $(this);

                if (! _this.hasClass('off')) {

                    var _inputObj = $(_this.attr('data-input'));

                    if(_inputObj.val() == ''){

                        _msg.error('<?php echo lang('view_exchange_72'); ?>' + (_this.attr('data-type') == 'sell' ? '<?php echo lang('view_exchange_73'); ?>' : '<?php echo lang('view_exchange_74'); ?>'));
                        return false;
                    }

                    _this.addClass('off');

                    $.ajax({
                        url: '/exchange/trade',
                        type: 'post',
                        data: {
                            'type' : _this.attr('data-type'),
                            'trade_type' : 'market',
                            'price' : '-',
                            'count' : _inputObj.val(),
                            'market_stock' : '<?php echo $market['market_stock_symbol']; ?>',
                            'market_money' : '<?php echo $market['market_money_symbol']; ?>'
                        },
                        dataType: 'json',
                        success: function (data) {
                            
                            if (data.status) {

                                _msg.success(data.message);
                            }else{

                                _msg.error(data.message);
                            }
                        },
                        error: function(){

                            _msg.error('<?php echo lang('view_exchange_75'); ?>');
                        },
                        complete: function(){

                            _this.removeClass('off');
                        }
                    });
                }
            });

            //计算总额
            function computeAmount(_priceObj, _countObj, _amountObj){

                var _amount = 0;

                if (_priceObj.length > 0 && _countObj.length > 0 && _amountObj.length > 0 && _priceObj.val() != '' && _countObj.val() != '') {

                    var _price = parseFloat(_priceObj.val());
                    var _count = parseFloat(_countObj.val());

                    if (_price > 0 && _count > 0) {

                        _amount = _price * _count;
                    }
                }

                _amountObj.text(_amount.toFixed(8));
            }

            $('#order_tab_content_current').on('click', '.order_cancel', function(){

                var _this = $(this);

                if (! _this.hasClass('off')) {

                    _this.addClass('off');

                    $.ajax({
                        url: '/exchange/cancel',
                        type: 'post',
                        data: {
                            'order' : _this.attr('data-id'),
                            'market' : '<?php echo $market['market_stock_symbol']; ?><?php echo $market['market_money_symbol']; ?>'
                        },
                        dataType: 'json',
                        success: function (data) {
                            
                            if (data.status) {

                                _msg.success(data.message);
                                _this.parent().parent().remove();
                            }else{

                                _msg.error(data.message);
                            }
                        },
                        error: function(){

                            _msg.error('<?php echo lang('view_exchange_76'); ?>');
                        },
                        complete: function(){

                            _this.removeClass('off');
                        }
                    });
                }
            });

            <?php if(count($marketSymbolList)){ ?>

                $(window).load(function(){

                    $('.ask_price_item, .bid_price_item').click(function(){

                        if ($(this).find('.amount_text').text() != '--') {

                            $('#limit_buy_price, #limit_sell_price').val($(this).find('.amount_text').text());
                        }
                    });

                    var BN = BigNumber.clone();
                    BN.config({DECIMAL_PLACES : 8});

                    var timeSub = 0;
                    var marketJson = <?php echo json_encode($marketSymbolList); ?>;
                    var marketSymbol = '<?php echo $market['market_stock_symbol'] . $market['market_money_symbol']; ?>';
                    var askMaxAmount = 0;
                    var bidMaxAmount = 0;
                    var askArray = [];
                    var bidArray = [];

                    
                });

            <?php } ?>


        </script>

    </body>
</html>

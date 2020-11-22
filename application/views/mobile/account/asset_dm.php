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
            <div class="market_list_btn"><?php echo lang('view_account_asset_dm_3'); ?></div>
            <div class="clear"></div>
        </header>

        <div class="asset_box">

            <div class="asset_total">
                <?php echo lang('asset_convert_total_text'); ?> <?php echo $userAssetUsdTotal; ?> USD
            </div>

            <?php $this->load->view("mobile/account/asset_menu"); ?>

            <?php if($userDmAsset && count($userDmAsset)){ foreach($userDmAsset as $asset){ ?>
            <div class="asset_item">
                <div class="asset_name">
                    <?php echo $asset["market_stock_symbol"]; ?>
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

                <a class="action_btn move_btn" data-coin="<?php echo $asset['market_stock_symbol']; ?>" data-active="<?php echo $asset["asset_active"]; ?>"><?php echo lang('view_account_asset_dm_9'); ?></a>

                <a class="action_btn" href="/account/record_futures/<?php echo strtolower($asset['market_stock_symbol']); ?>"><?php echo lang('view_account_asset_dm_10'); ?></a>

                <div class="clear"></div>
            </div>
            <?php }} ?>

            <?php $this->load->view("front/account/account_safe_text"); ?>
        </div>

        <?php $this->load->view("mobile/footer"); ?>

        <style type="text/css">
            .layui-layer-iframe .layui-layer-btn, .layui-layer-page .layui-layer-btn{ padding: 0px; }
            .layui-layer.layui-layer-page,.layui-layer-shade{ transition: 0s; -moz-transition: 0s; -webkit-transition: 0s; -o-transition: 0s; overflow: hidden !important; }
            .layui-layer-page .layui-layer-content{ overflow: hidden; }

            .movebox{ border: #34363f 10px solid; width: 100%; box-sizing: border-box; display: none; }
            .movebox .movecenter{ padding: 10px;  position: relative; background: #191a1f; }
            .movebox .box_title,.movebox .box_title span{ color: #aeb9d8; font-size: 16px; }
            .movebox .move_body{ margin-top: 20px; border: #357ce1 solid 1px; position: relative; }
            .movebox .move_body .move_from_box{ border-bottom: #357ce1 solid 1px; padding-left: 15px; position: relative; }
            .movebox .move_body .move_from_box .move_from_text{ font-size: 12px; line-height: 50px; color: #aeb9d8; }
            .movebox .move_body .move_from_box .move_from_item{ font-size: 14px; line-height: 50px; color: #d5def2; font-weight: bold; position: absolute; top: 0px; left: 80px; }
            .movebox .move_body .move_to_box{ padding-left: 15px; position: relative; }
            .movebox .move_body .move_to_box .move_to_text{ font-size: 12px; line-height: 50px; color: #aeb9d8; }
            .movebox .move_body .move_to_box .move_to_item{ font-size: 14px; line-height: 50px; color: #d5def2; font-weight: bold; position: absolute; top: 0px; left: 80px; }
            .movebox .move_body .move_to_box .move_to_item input{ color: #d5def2; font-size: 12px; width: 330px; height: 48px; line-height: 48px; }
            .movebox .move_body .move_to_box .move_all_btn{ position: absolute; width: 80px; line-height: 50px; right: 0px; top: 0px; border-left: #357ce1 solid 1px; font-size: 12px; text-align: center; cursor: pointer; color: #357ce1; }
            .movebox .move_body .move_to_box .move_all_btn:hover{ color: #3B97E9; }
            .movebox .move_body .move_exchange_btn{ cursor: pointer; height: 101px; width: 80px; background: url('/static/front/images/exchange.png') no-repeat center #191a1f; position: absolute; right: 0px; top: 0px; border-left: #357ce1 solid 1px; }
            .movebox .move_balance_box{ color: #aeb9d8; margin-top: 20px; }
            .movebox .move_balance_box .move_balance_item{ position: relative; }
            .movebox .move_balance_box .move_balance_item .move_balance_item_text{ font-size: 12px; line-height: 20px; }
            .movebox .move_balance_box .move_balance_item .move_balance_item_number{ color: #d5def2; font-size: 12px; line-height: 20px; position: absolute; top: 0px; left: 80px; width: 330px; }
            .movebox .move_action_btn{ float: right; width: 100px; margin-left: 20px; margin-top: 20px; text-align: center; line-height: 30px; border: #357ce1 solid 1px; color: #357ce1; font-size: 12px; cursor: pointer; }
            .movebox .move_action_btn.move_submit{ background: #357ce1; color: #FFF; }
            .movebox .move_action_btn.move_submit span{ font-size: 12px; }
            .movebox .move_action_btn.move_submit .btn_load, .movebox .move_action_btn.move_submit .btn_success{ display: none; }
            .movebox .move_action_btn.move_submit.load .btn_load{ display: inline-block; }
            .movebox .move_action_btn.move_submit.load span{ display: none; }
            .movebox .move_action_btn.move_submit.success .btn_success{ display: inline-block; }
            .movebox .move_action_btn.move_submit.success span{ display: none; }
        </style>

        <!-- 编辑框 -->
        <div class="movebox" id="movebox">
            
            <div class="movecenter">
                <div class="box_title"><?php echo lang('view_account_asset_dm_11'); ?> <span class="move_symbol_text">BTC</span></div>

                <div class="move_body">
                    <div class="move_from_box">
                        <div class="move_from_text"><?php echo lang('view_account_asset_dm_12'); ?></div>
                        <div class="move_from_item move_from_item_dom" data-symbol="exchange"><?php echo lang('view_account_asset_dm_13'); ?></div>
                    </div>
                    <div class="move_to_box">
                        <div class="move_to_text"><?php echo lang('view_account_asset_dm_14'); ?></div>
                        <div class="move_to_item move_to_item_dom" data-symbol="futures"><?php echo lang('view_account_asset_dm_15'); ?></div>
                    </div>
                    <div class="move_exchange_btn"></div>
                </div>

                <div class="move_body">
                    <div class="move_to_box">
                        <div class="move_to_text"><?php echo lang('view_account_asset_dm_16'); ?></div>
                        <div class="move_to_item">
                            <input type="text">
                        </div>
                        <div class="move_all_btn"><?php echo lang('view_account_asset_dm_17'); ?></div>
                    </div>
                </div>

                <div class="move_balance_box">
                    <div class="move_balance_item">
                        <div class="move_balance_item_text"><?php echo lang('view_account_asset_dm_18'); ?></div>
                        <div class="move_balance_item_number move_exchange_balance">0.00000000</div>
                    </div>
                    <div class="move_balance_item">
                        <div class="move_balance_item_text"><?php echo lang('view_account_asset_dm_19'); ?></div>
                        <div class="move_balance_item_number move_futures_balance">0.00000000</div>
                    </div>
                </div>

                <div class="move_action_btn move_submit">
                    <span><?php echo lang('view_account_asset_dm_20'); ?></span>
                    <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop btn_load"></i>
                    <i class="layui-icon layui-icon-ok btn_success"></i>
                </div>
                <div class="move_action_btn move_cancel"><?php echo lang('view_account_asset_dm_21'); ?></div>
                <div class="clear"></div>
            </div>
        </div>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.asset, .asset_box .account_menu .account_menu_item.futures').addClass('active');

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                //用户币币资产
                var _userAsset = <?php echo json_encode($userAsset); ?>;

                //允许关闭划转窗口
                var _closeActive = true;
                
                //划转资产
                $('.move_btn').click(function(){

                    var _this = $(this);

                    $('#movebox .move_symbol_text').text(_this.attr('data-coin'));
                    $('#movebox .move_exchange_balance').text(_userAsset[_this.attr('data-coin')]);
                    $('#movebox .move_futures_balance').text(_this.attr('data-active'));
                    $('#movebox .move_body .move_to_box .move_to_item input').val('');
                    $('#movebox .move_from_item_dom').attr('data-symbol', 'exchange');
                    $('#movebox .move_from_item_dom').text('<?php echo lang('view_account_asset_dm_22'); ?>');
                    $('#movebox .move_to_item_dom').attr('data-symbol', 'futures');
                    $('#movebox .move_to_item_dom').text('<?php echo lang('view_account_asset_dm_23'); ?>');

                    layer.open({

                        title: false,
                        type: 1,
                        content: $('#movebox'),
                        area: '100%',
                        btnAlign: 'c',
                        btn: [],
                        maxmin: false,
                        zIndex: 99,
                        scrollbar: false,
                        closeBtn: 0,
                        shade: [0.1, '#aeb9d8'],
                        success: function(){

                            $('#movebox .move_body .move_to_box .move_to_item input').focus();
                        }
                    });
                });

                //提交
                $('#movebox .move_submit').click(function(){

                    if (_closeActive) {

                        var _this = $(this);

                        if($('#movebox .move_body .move_to_box .move_to_item input').val() != ''){

                            _closeActive = false;

                            _this.addClass('load');

                            $.ajax({
                                url: '/account/asset_move',
                                type: 'post',
                                data: {
                                    from : $('#movebox .move_from_item_dom').attr('data-symbol'),
                                    to : $('#movebox .move_to_item_dom').attr('data-symbol'),
                                    count : $('#movebox .move_body .move_to_box .move_to_item input').val(),
                                    coin : $('#movebox .move_symbol_text').text()
                                },
                                dataType: 'json',
                                success: function (data) {
                                    
                                    if (data.status) {

                                        _msg.success(data.message);

                                        _this.removeClass('load').addClass('success');

                                        setTimeout(function(){

                                            window.location.href = '/account/asset_futures';
                                        }, 1000);
                                    }else{

                                        _this.removeClass('load');
                                        _msg.error(data.message);
                                        _closeActive = true;
                                    }
                                },
                                error: function(){

                                    _this.removeClass('load');
                                    _msg.error('<?php echo lang('view_account_asset_dm_24'); ?>');
                                    _closeActive = true;
                                }
                            });
                        }else{

                            _msg.error('<?php echo lang('view_account_asset_dm_25'); ?>');
                        }
                    }
                });

                //转换
                $('#movebox .move_exchange_btn').click(function(){

                    if (_closeActive) {

                        var _symbolTemp = $('#movebox .move_from_item_dom').attr('data-symbol');
                        var _symbolTextTemp = $('#movebox .move_from_item_dom').text();

                        $('#movebox .move_from_item_dom').attr('data-symbol', $('#movebox .move_to_item_dom').attr('data-symbol'));
                        $('#movebox .move_from_item_dom').text($('#movebox .move_to_item_dom').text());

                        $('#movebox .move_to_item_dom').attr('data-symbol', _symbolTemp);
                        $('#movebox .move_to_item_dom').text(_symbolTextTemp);

                        $('#movebox .move_body .move_to_box .move_to_item input').val('').focus();
                    }
                });

                //全部
                $('#movebox .move_all_btn').click(function(){

                    if (_closeActive) {

                        $('#movebox .move_body .move_to_box .move_to_item input').val($('.move_' + $('#movebox .move_from_item_dom').attr('data-symbol') + '_balance').text());
                    }
                });

                $('#movebox .move_cancel').click(function(){

                    if (_closeActive) {

                        layer.closeAll();
                    }
                });

                $('#movebox .move_body .move_to_box .move_to_item input').keyup(function(){

                    format_input_num($(this)[0]);
                });
            });
        </script>
    </body>
</html>

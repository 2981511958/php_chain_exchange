<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title><?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel='icon' href='/favicon.ico' type='image/x-ico' />
        
        <link rel="stylesheet" href="<?php echo base_url('static'); ?>/layui/css/layui.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/mobile'); ?>/style/style.css" />

        <!--[if lt IE 9]>
        <script src="<?php echo base_url('static/mobile'); ?>/js/css3.js"></script>
        <script src="<?php echo base_url('static/mobile'); ?>/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php $this->load->view('mobile/header'); ?>

        <style type="text/css">
            
            /*index*/
            .body_box header{ height: 50px; position: fixed; z-index: 9; width: 100%; background: #191a1f; }
            .body_box header .logo{ display: block; height: 20px; margin: 15px 10px; }
            .body_box header .logo img{ display: block; height: 20px; }
            .body_box header .language_select{ appearance: none; -moz-appearance: none; -webkit-appearance: none; float: right; line-height: 30px; height: 30px; font-size: 14px; padding: 0px 10px; margin-top: 10px; margin-right: 10px; cursor: pointer; border-radius: 3px; color: #FFF; background: #357ce1; text-align: center; text-align-last: center; width: auto; }
            .header_hold{ height: 50px; }
            .body_box .index_banner{ margin-top: 1px; height: 200px; }
            .body_box .index_banner .banner_item{ height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover; }
            .body_box .index_banner .layui-carousel{ background: none; }
            .body_box .index_banner .layui-carousel div:not(.banner_item){ background: none; }
        </style>

        <div class="body_box">

            <header>
                <?php $languageList = $this->config->item('_language_list'); ?>
                <select class="language_select">
                    <?php foreach ($languageList as $langSymbol => $langText) { ?>
                    <option class="language_item" value="<?php echo $langSymbol; ?>" <?php echo $langSymbol == $_SESSION['_language'] ? 'selected' : ''; ?>><?php echo $langText; ?></option>
                    <?php } ?>
                </select>

                <a class="logo">
                    <img class="logo_img" src="<?php echo $_SESSION['SYSCONFIG']['sysconfig_site_logo']; ?>">
                </a>
            </header>
            <div class="header_hold"></div>
            
            <!-- 轮播 -->
            <div class="index_banner">
                <div class="layui-carousel" id="index-banner">
                    <div carousel-item>

                        <?php if($imageList && count($imageList)){ foreach($imageList as $imageItem){ if($imageItem['article_plate'] == 1){ ?>
                        <div><a><div class="banner_item" style="background-image: url('<?php echo $imageItem['article_content']; ?>')"></div></a></div>
                        <?php }}} ?>
                    </div>
                </div>
            </div>

            <style type="text/css">
                .article_box{ margin: 10px; }
                .article_box .article_icon{ float: left; width: 30px; }
                .article_box .article_icon i{ font-size: 20px; color: #697080; font-weight: bold; line-height: 23px; }
                .article_box .article_list_box{ float: left; width: calc(100% - 60px); }
                .article_box .article_list_box .news_item{ display: block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; line-height: 23px; font-size: 14px; background: #1f2126; }
                .article_box .article_list_box .layui-carousel{ background: none; }
                .article_box .article_list_box .layui-carousel div:not(.banner_item){ background: none; }
                .article_box .article_list_box .layui-carousel>[carousel-item]:before{ opacity: 0; }

                .article_box .article_menu{ float: left; width: 30px; text-align: right; }
                .article_box .article_menu i{ font-size: 20px; color: #697080; line-height: 23px; }
            </style>

            <div class="article_box">
                <div class="article_icon"><i class="layui-icon layui-icon-speaker"></i></div>
                <div class="article_list_box">

                    <div class="layui-carousel" id="article_carousel">
                      <div carousel-item>
                        <?php if($newsList && count($newsList)){ foreach($newsList as $newsItem){ ?>
                        <div>
                            <a class="news_item" href="/article/detail/<?php echo $newsItem['article_token']; ?>"><?php echo $newsItem['article_title']; ?></a>
                        </div>
                        <?php }} ?>
                      </div>
                    </div>
                    
                </div>
                <div class="article_menu"><a href="/article"><i class="layui-icon layui-icon-spread-left"></i></a></div>
                <div class="clear"></div>
            </div>

            <style type="text/css">
                
                .body_box .market_list_box{ margin-top: 15px; }
                .body_box .market_list_box .market_tab_box{ border-bottom: #357ce1 solid 1px; padding: 0px 10px; }
                .body_box .market_list_box .market_tab_box .market_tab_item{ line-height: 35px; padding: 0px 20px; text-align: center; color: #aeb9d8; font-size: 12px; float: left; }
                .body_box .market_list_box .market_tab_box .market_tab_item.active{ background: #357ce1; color: #FFF; border-radius: 5px 5px 0px 0px; font-size: 16px; }
                .body_box .market_list_box .left_bar{ float: left; width: 35%; text-align: left; }
                .body_box .market_list_box .center_bar{ float: left; width: 40%; text-align: left; }
                .body_box .market_list_box .right_bar{ float: left; width: 25%; text-align: right; }
                .body_box .market_list_box .title_line{ margin: 10px 10px 0px 10px; }
                .body_box .market_list_box .title_line *{ font-size: 12px; color: #697080; }
                .body_box .market_list_box .market_tab_content_item{ display: none; }
                .body_box .market_list_box .market_tab_content_item.active{ display: block; }
                .body_box .market_list_box .market_tab_content_item .market_line_item{ display: block; height: 50px; border-bottom: #34363f solid 1px; padding: 0px 10px; }
                .body_box .market_list_box .market_tab_content_item .market_line_item .left_bar{ font-size: 14px; color: #d5def2; line-height: 50px; }
                .body_box .market_list_box .market_tab_content_item .market_line_item .center_bar{ font-size: 14px; color: #d5def2; line-height: 50px; }
                .body_box .market_list_box .market_tab_content_item .market_line_item .rate_bar{ line-height: 30px; background: #05c19e; color: #FFF; font-size: 12px; width: 75px; text-align: center; float: right; margin-top: 10px; border-radius: 5px; }
                .body_box .market_list_box .market_tab_content_item .market_line_item .rate_bar.down{ background: #e04545; }
            </style>
            
            <div class="market_list_box">
                <div class="market_tab_box">
                    <?php if($marketGroup && count($marketGroup)){ $i = 0; foreach($marketGroup as $money => $marketsItem){ ?>
                    <div class="market_tab_item <?php echo $i<1?'active':''; ?>" target-content="index_price_list_tab_content_<?php echo $money; ?>"><?php echo $money; ?></div>
                    <?php $i++; }} ?>
                    <div class="clear"></div>
                </div>
                <div class="title_line">
                    <div class="left_bar"><?php echo lang('view_mobile_index_1'); ?></div>
                    <div class="center_bar"><?php echo lang('view_mobile_index_2'); ?></div>
                    <div class="right_bar"><?php echo lang('view_mobile_index_3'); ?></div>
                    <div class="clear"></div>
                </div>
                <?php if($marketGroup && count($marketGroup)){ $i = 0; foreach($marketGroup as $money => $marketsItem){ ?>
                <div class="market_tab_content_item <?php echo $i<1?'active':''; ?>" id="index_price_list_tab_content_<?php echo $money; ?>">
                    <?php foreach($marketsItem as $marketItem){ ?>
                    <a class="market_line_item" id="market_item_line_<?php echo $marketItem['market_stock_symbol']; ?><?php echo $marketItem['market_money_symbol']; ?>" href="/exchange/<?php echo strtolower($marketItem['market_stock_symbol']); ?>/<?php echo strtolower($marketItem['market_money_symbol']); ?>">
                        <div class="left_bar"><?php echo $marketItem['market_stock_symbol']; ?></div>
                        <div class="center_bar">--</div>
                        <div class="right_bar">
                            <div class="rate_bar">--</div>
                        </div>
                        <div class="clear"></div>
                    </a>
                    <?php } ?>
                </div>
                <?php $i++; }} ?>
            </div>


            <style type="text/css">
                
                .about_box{ margin: 20px 0px 10px 0px; }
                .about_box .about_item{ border-bottom: #34363f solid 1px; padding: 0px 10px; }
                .about_box .about_item.noborder{ border-bottom: none; }
                .about_box .about_item a{ display: block; line-height: 50px; text-align: center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            </style>

            <?php

                $startList = $this->article_model->listActiveArticleByType(1, 100, 2, $_SESSION['_language']);
            ?>

            <div class="about_box">
                <?php if($startList && count($startList)){ foreach($startList as $key => $articleItem){ ?>
                <div class="about_item <?php echo ($key + 1) == count($startList) ? 'noborder' : ''; ?>">
                    <a class="link_item" href="/article/detail/<?php echo $articleItem['article_token']; ?>"><?php echo $articleItem['article_title']; ?></a>
                </div>
                <?php }} ?>
            </div>
        </div>
        
        <?php $this->load->view('mobile/footer'); ?>

        <script src="<?php echo base_url('static'); ?>/layui/layui.js"></script>
        <script src="<?php echo base_url('static'); ?>/mobile/js/bignumber.min.js"></script>

        <script type="text/javascript">

            //当前栏目
            $('footer .navitem.home').addClass('active');

            //首页行情列表
            $('.body_box .market_list_box .market_tab_box .market_tab_item').click(function(){

                var _this = $(this);

                if (! _this.hasClass('active')) {

                    _this.addClass('active').siblings('.active').removeClass('active');
                    $('#' + _this.attr('target-content')).addClass('active').siblings('.active').removeClass('active');
                }
            });

            <?php if(count($marketSymbolList)){ ?>

                $(window).load(function(){

                    var BN = BigNumber.clone();
                    BN.config({DECIMAL_PLACES : 8});

                    var marketJson = <?php echo json_encode($marketSymbolList); ?>;
                });

            <?php } ?>

            //layui
            var ins;
            var ins_article;
            layui.use(['layer', 'carousel'], function(){

                layer.open({
                  title: '温馨提示：'
                  ,content: '<span style="color: #F00;">仅供学习参考，请遵守相关法律法规！<br />DEMO币是平台币，可控行情</span>'
                });

                var carousel = layui.carousel;

                //首页Banner
                ins = carousel.render({
                    elem: '#index-banner',
                    width: '100%',
                    height: '200px',
                    arrow: 'hover'
                });

                ins_article = carousel.render({
                    elem: '#article_carousel',
                    width: '100%',
                    height: '23px',
                    arrow: 'none',
                    indicator : 'none',
                    anim : 'updown'
                });

                $("#index-banner").on("touchstart", function (e) {
                    var startX = e.originalEvent.targetTouches[0].pageX;//开始坐标X
                    $(this).on('touchmove', function (e) {
                        arguments[0].preventDefault();//阻止手机浏览器默认事件
                    });
                    $(this).on('touchend', function (e) {
                        var endX = e.originalEvent.changedTouches[0].pageX;//结束坐标X
                        e.stopPropagation();//停止DOM事件逐层往上传播
                        if (endX - startX > 30) {
                            ins.slide("sub"); 
                        }
                        else if (startX - endX > 30) {
                            ins.slide("add"); 
                        }
                        $(this).off('touchmove touchend');
                    });
                });
            });

            $('.language_select').change(function(){

                var _this = $(this);

                $.ajax({
                    url: '/common/change_language',
                    type: 'post',
                    data: {

                        '_language' : _this.val()
                    },
                    success: function (data) {
                        
                        location.reload();
                    }
                });
            });
        </script>

    </body>
</html>

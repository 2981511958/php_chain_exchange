<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title>
            <?php echo $article_type == 1 ? lang('view_article_list_2') : '' ?>
            <?php echo $article_type == 2 ? lang('view_article_list_3') : '' ?>
            <?php echo $article_type == 3 ? lang('view_article_list_4') : '' ?>
            <?php echo $article_type == 4 ? lang('view_article_list_5') : '' ?>
            <?php echo $article_type == 5 ? lang('view_article_list_6') : '' ?>
             - <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>
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

            .article_box{  }
            .article_box .page_title{ background: #191a1f; padding-left: 50px; line-height: 60px; font-size: 16px; color: #d5def2; }
            .article_box .right_box{ background: #1f2126; }
            .article_box .right_box .article_list_box{ padding: 10px 0px; }
            .article_box .right_box .article_list_box .article_link_item{ display: block; line-height: 20px; border-bottom: #34363f solid 1px; padding: 15px 20px; }
            .article_box .right_box .article_list_box .article_link_item:hover{ color: #FFF; }
        </style>

        <header>
            <div class="market_list_btn">
                <?php echo $article_type == 1 ? lang('view_article_list_2') : '' ?>
                <?php echo $article_type == 2 ? lang('view_article_list_3') : '' ?>
                <?php echo $article_type == 3 ? lang('view_article_list_4') : '' ?>
                <?php echo $article_type == 4 ? lang('view_article_list_5') : '' ?>
                <?php echo $article_type == 5 ? lang('view_article_list_6') : '' ?>
            </div>
            <a class="back_btn" href="/">
                <i class="layui-icon layui-icon-left"></i>
            </a>
            <div class="clear"></div>
        </header>

        <div class="article_box">
            <div class="right_box">
                
                <div class="article_list_box">
                    
                    <?php if(count($articleList)){ foreach($articleList as $article){ ?>
                        <a class="article_link_item" href="/article/detail/<?php echo $article['article_token']; ?>">
                            <?php echo $article['article_title']; ?>
                        </a>
                    <?php }} ?>

                    <div style="height: 30px;"></div>

                    <div class="page_paging_box">
                        <!-- 通用分页 -->
                        <?php
                            if($articleCount > $pageSize){
                                $this->load->view('mobile/paging');
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <?php $this->load->view("mobile/footer"); ?>

        <script src="<?php echo base_url("static"); ?>/layui/layui.js"></script>

        <script type="text/javascript">

            //当前栏目
            <?php if($article_type == 1){ ?>
            $('header .left_box .nav_box .nav_item.article').addClass('active');
            <?php } ?>

            layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {
                
                
            });
        </script>
    </body>
</html>

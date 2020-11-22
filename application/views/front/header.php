<style type="text/css">
    
    /*header*/
    header{ height: 50px; background: #191a1f; width: 100%; min-width: 1300px; }
    header .left_box{ float: left; }
    header .left_box .logo_box{ display: block; float: left; padding: 8px 20px; }
    header .left_box .logo_box .logo_img{ height: 35px; }
    header .left_box .nav_box{ float: left; width: 700px; margin-left: 20px; }
    header .left_box .nav_box .nav_item{ display: block; float: left; line-height: 50px; height: 50px; margin-right: 20px; cursor: pointer; font-size: 14px; }
    header .left_box .nav_box .nav_item:hover{ color: #FFF; }
    header .left_box .nav_box .nav_item.active{ color: #FFF; border-bottom: #3B97E9 solid 2px; height: 40px; }
    header .right_box .nav_right_box{ float: right; width: 400px; }
    header .right_box .nav_right_box .nav_item{ display: block; float: right; line-height: 50px; margin-left: 20px; cursor: pointer; font-size: 14px; }
    header .right_box .nav_right_box .nav_item.active{ color: #FFF; border-bottom: #3B97E9 solid 2px; height: 40px; }
    header .right_box .nav_right_box .nav_item:hover{ color: #FFF; }
    header .right_box .nav_right_box .nav_item.language{ width: 100px; text-align: center; line-height: 50px; position: relative; border-left: #34363f solid 1px; }
    header .right_box .nav_right_box .nav_item.language .language_box{ position: absolute; right: 0px; top: 50px; width: 100px; z-index: 999; background: #191a1f; border-left: #34363f solid 1px; display: none; }
    header .right_box .nav_right_box .nav_item.language .language_box .language_item{ border-top: #34363f solid 1px; line-height: 40px; font-size: 12px; text-align: center; color: #aeb9d8; }
    header .right_box .nav_right_box .nav_item.language .language_box .language_item:hover{ color: #FFF; }
    header .right_box .nav_right_box .nav_item.language:hover .language_box{ display: block; }
    header .right_box .nav_right_box .nav_item.app{ position: relative; }
    header .right_box .nav_right_box .nav_item.app img{ position: absolute; top: 55px; left: -60px; width: 150px; max-width: 150px; height: 150px; z-index: 999; display: none; }
    header .right_box .nav_right_box .nav_item.app:hover img{ display: block; }
</style>

<header>

    <div class="right_box">
        <div class="nav_right_box">

            <a class="nav_item language">
                <?php $languageList = $this->config->item('_language_list'); echo $languageList[$_SESSION['_language']]; ?>
                <div class="language_box">
                    <?php foreach ($languageList as $langSymbol => $langText) { if($langSymbol != $_SESSION['_language']){ ?>
                    <div class="language_item" data-lang="<?php echo $langSymbol; ?>"><?php echo $langText; ?></div>
                    <?php }} ?>
                </div>
            </a>

            

            <?php if(isset($_SESSION["USER"])){ ?>
                <a class="nav_item account" href="/account">
                    <i class="layui-icon layui-icon-username"></i>
                    <?php echo $_SESSION["USER"]["USER_NAME"]; ?>
                </a>
            <?php }else{ ?>
                <a class="nav_item register" href="/account/register"><?php echo lang('view_header_1'); ?></a>
                <a class="nav_item login" href="/account/login"><?php echo lang('view_header_2'); ?></a>
            <?php } ?>

            <a class="nav_item app">
                APP
                <img src="<?php echo $_SESSION['SYSCONFIG']['sysconfig_app_qrcode']; ?>">
            </a>

            
        </div>
    </div>

    <div class="left_box">
        <a class="logo_box" href="/">
            <img class="logo_img" src="<?php echo $_SESSION['SYSCONFIG']['sysconfig_site_logo']; ?>">
        </a>

        <div class="nav_box">
            <a class="nav_item home" href="/"><?php echo lang('view_header_3'); ?></a>
            <!-- <a class="nav_item otc" href="/otc">法币交易</a> -->
            <a class="nav_item exchange" href="/exchange"><?php echo lang('view_header_4'); ?></a>
            <a class="nav_item futures" href="/futures"><?php echo lang('view_header_5'); ?></a>
            <a class="nav_item article" href="/article"><?php echo lang('view_header_6'); ?></a>

            <?php if(isset($_SESSION["USER"])){ ?>
                <a class="nav_item asset" href="/account/asset"><?php echo lang('view_header_7'); ?></a>
            <?php } ?>
            
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</header>
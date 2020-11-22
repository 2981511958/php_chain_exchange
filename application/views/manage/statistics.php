<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/manage'); ?>/style/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/manage'); ?>/style/style.css" />

    <link rel="stylesheet" href="<?php echo base_url('static/layui/css'); ?>/layui.css">
    
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('static/manage'); ?>/js/css3.js"></script>
    <script src="<?php echo base_url('static/manage'); ?>/js/html5.js"></script>
    <![endif]-->

    <script src="<?php echo base_url('static/manage'); ?>/js/common.js"></script>
    <script src="<?php echo base_url('static/layui'); ?>/layui.js"></script>

    <!-- 配置文件 -->
    <script type="text/javascript" src="<?php echo base_url('static/ueditor'); ?>/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo base_url('static/ueditor'); ?>/ueditor.all.js"></script>
</head>
<body>

    <div class="pagebox">

        <div class="mainbox">

            <style type="text/css">
                
                .info_item{ float: left; width: calc((100% - 100px) / 5); margin: 0px 10px; background: #f2f2f2; box-shadow: 2px 4px 10px 1px rgba(0,0,0,0.3); }
                .info_item .info_title{ border-bottom: #cccccc solid 1px; line-height: 40px; font-size: 14px; padding-left: 15px; }
                .info_item .info_item_count{ line-height: 100px; text-align: center; font-size: 36px; font-weight: bold; color: #357ce1; }

                .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; cursor: pointer; }
                .layui-table .imgpreview{ height: 30px; }

                .asset_detail_item{ margin: 40px 10px 0px 10px; box-shadow: 2px 4px 10px 1px rgba(0,0,0,0.3); }
            </style>

            <div class="info_item">
                <div class="info_title">今日注册人数</div>
                <div class="info_item_count"><?php echo $todayRegisterCount; ?></div>
            </div>

            <div class="info_item">
                <div class="info_title">今日充值人数</div>
                <div class="info_item_count"><?php echo $todayRechargeUserCount; ?></div>
            </div>

            <div class="info_item">
                <div class="info_title">今日充值笔数</div>
                <div class="info_item_count"><?php echo $todayRechargeCount; ?></div>
            </div>

            <div class="info_item">
                <div class="info_title">今日提现人数</div>
                <div class="info_item_count"><?php echo $todayWithdrawUserCount; ?></div>
            </div>

            <div class="info_item">
                <div class="info_title">今日提现笔数</div>
                <div class="info_item_count"><?php echo $todayWithdrawCount; ?></div>
            </div>

            <div class="clear"></div>

            <div class="asset_detail_item">
                <table class="layui-table" >
                    <colgroup>
                        <col style="width: 60px;">
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th>图标</th>
                            <th>货币标识</th>
                            <th>今日充值</th>
                            <th>今日提现</th>
                        </tr> 
                    </thead>
                    <tbody>

                        <?php if(count($coinList)){ foreach($coinList as $coin){ ?>
                        <tr style="position: relative;">
                            <td><img class="imgpreview" src="<?php echo $coin['coin_icon']; ?>" style="display: inline; margin: -20px 0px;"></td>
                            <td><?php echo $coin['coin_symbol']; ?></td>
                            <td><?php echo isset($coin['recharge_sum']) ? $coin['recharge_sum'] : '0'; ?></td>
                            <td><?php echo isset($coin['withdraw_sum']) ? $coin['withdraw_sum'] : '0'; ?></td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
      
        //JavaScript代码区域
        layui.use(['element', 'jquery', 'form', 'layer'], function () {

            var element = layui.element;
            var form    = layui.form;
            var layer   = layui.layer;
            var $       = layui.$;

            var layuiOpenIndex = 0;
            var layuiLoadIndex = 0;

            
        });
    </script>
</body>
</html>
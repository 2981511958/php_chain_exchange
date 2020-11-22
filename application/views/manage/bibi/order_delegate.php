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

    <script src="/static/manage/js/jquery-1.8.0.min.js"></script>   
    <script src="/static/editor.md/editormd.js"></script>   
</head>
<body>

    <div class="pagebox">
        
        <div class="pagetitle layui-bg-black">
            币币交易 > 挂起订单 ( 数据更新有延迟，仅供参考 )
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
        </style>

        <div class="mainbox">
            
            <table class="layui-table" >
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                    <tr>
                        <th>用户名</th>
                        <th>交易对</th>
                        <th>下单时间</th>
                        <th>方向</th>
                        <th>类型</th>
                        <th>价格</th>
                        <th>数量</th>
                        <th>已成交</th>
                        <th>未成交</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php if(count($orderList)){ foreach($orderList as $orderItem){ ?>
                    <tr style="position: relative;">
                        <td><?php echo $orderItem['order_user_name']; ?></td>
                        <td><?php echo $orderItem['order_stock_symbol'] . ' / ' . $orderItem['order_money_symbol']; ?></td>
                        <td><?php echo date('Y/m/d H:i:s', $orderItem['order_ctime']); ?></td>
                        <td>
                            <a class="layui-btn <?php echo $orderItem['order_side'] == 1 ? 'layui-btn-danger' : ''; ?> layui-btn-xs"><?php echo $orderItem['order_side'] == 1 ? '卖出' : '买入'; ?></a>
                        </td>
                        <td><?php echo $orderItem['order_type'] == 1 ? '限价' : '市价'; ?></td>
                        <td><?php echo $orderItem['order_type'] == 1 ? $orderItem['order_price'] : '-'; ?> <?php echo $orderItem['order_money_symbol']; ?></td>
                        <td><?php echo $orderItem['order_type'] == 1 ? $orderItem['order_count'] : '-'; ?> <?php echo $orderItem['order_stock_symbol']; ?></td>
                        <td><?php echo $orderItem['order_type'] == 1 ? bcsub($orderItem['order_left'], $orderItem['order_left'], 8) : '-'; ?> <?php echo $orderItem['order_stock_symbol']; ?></td>
                        <td><?php echo $orderItem['order_type'] == 1 ? $orderItem['order_left'] : '-'; ?> <?php echo $orderItem['order_stock_symbol']; ?></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>

            <!-- 分页 -->
            <?php $this->load->view('manage/paging'); ?>
        </div>

    </div>
    
    <script>
      
        //JavaScript代码区域
        layui.use(['element', 'jquery', 'form', 'layer', 'upload', 'laydate'], function () {

            var element = layui.element;
            var form    = layui.form;
            var layer   = layui.layer;
            var upload  = layui.upload;
            var laydate = layui.laydate;
            var $       = layui.$;

            var layuiOpenIndex = 0;
            var layuiLoadIndex = 0;

        });
    </script>
</body>
</html>
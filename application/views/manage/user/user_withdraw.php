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
                </colgroup>
                <thead>
                    <tr>
                        <th>提交时间</th>
                        <th>币种</th>
                        <th>提现数量</th>
                        <th>实际到帐</th>
                        <th>业务编号</th>
                        <th>状态</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php if(count($withdrawList)){ foreach($withdrawList as $withdraw){ ?>
                    <tr style="position: relative;">
                        <td><?php echo date('Y-m-d H:i', $withdraw['withdraw_time']); ?></td>
                        <td><?php echo $withdraw['withdraw_chain_symbol']; ?></td>
                        <td><?php echo $withdraw['withdraw_amount']; ?></td>
                        <td><?php echo $withdraw['withdraw_finally_amount']; ?></td>
                        <td>
                            <?php echo $withdraw['withdraw_no']; ?>
                            <?php if($withdraw['withdraw_local']){ ?>
                                <span class="layui-btn layui-btn-xs">内部</span>
                            <?php } ?>
                        </td>
                        <td>

                            <a class="layui-btn 
                                <?php switch($withdraw['withdraw_status']){

                                    case 0:
                                        echo 'layui-btn-warm';
                                    break;

                                    case 1:
                                        echo 'layui-btn-warm';
                                    break;

                                    case 2:
                                        echo 'layui-btn-danger';
                                    break;

                                    case 3:
                                        echo 'layui-btn-warm';
                                    break;

                                    case 4:
                                        echo 'layui-btn-warm';
                                    break;

                                    case 5:
                                        echo 'layui-btn-danger';
                                    break;

                                    case 6:
                                        echo '';
                                    break;

                                    case 7:
                                        echo 'layui-btn-danger';
                                    break;
                                } ?>
                            layui-btn-xs">
                                <?php switch($withdraw['withdraw_status']){

                                    case 0:
                                        echo '待审核';
                                    break;

                                    case 1:
                                        echo '审核通过';
                                    break;

                                    case 2:
                                        echo '审核拒绝';
                                    break;

                                    case 3:
                                        echo '待钱包审核';
                                    break;

                                    case 4:
                                        echo '钱包通过';
                                    break;

                                    case 5:
                                        echo '钱包拒绝';
                                    break;

                                    case 6:
                                        echo '钱包转帐成功';
                                    break;

                                    case 7:
                                        echo '钱包转帐失败';
                                    break;
                                } ?>
                            </a>
                        </td>
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
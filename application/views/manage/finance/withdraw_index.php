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
            财务管理 > 提现记录
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }

            .search_box .download_btn{ float: right; }
        </style>

        <div class="mainbox">

            <style type="text/css">
                .search_box{ margin-bottom: 20px; }
                .search_box .search_value{ width: 300px; float: left; }
                .search_box .search_btn, .search_box .clear_search_btn{ float: left; margin-left: 10px; }
            </style>
            <div class="search_box layui-form">
                <input type="text" id="search_value" placeholder="搜索用户名、手机、邮箱" autocomplete="off" class="layui-input search_value" value="<?php echo $search; ?>">
                <button type="button" class="layui-btn search_btn" id="search_btn" data-url="/manage/finance/withdraw">搜索用户</button>
                <a class="layui-btn layui-btn-normal clear_search_btn" href="/manage/finance/withdraw">清空</a>

                <a class="layui-btn layui-btn-normal download_btn" download="提现报表_<?php echo date('Y_m_d_H_i_s'); ?>.csv" href="/manage/finance/withdraw/download">下载报表</a>
                <div class="clear"></div>
            </div>
            
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
                    <col style="width: 140px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>用户名</th>
                        <th>提交时间</th>
                        <th>币种</th>
                        <th>提现数量</th>
                        <th>实际到帐</th>
                        <th>业务编号</th>
                        <th>上级代理商</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php if(count($withdrawList)){ foreach($withdrawList as $withdraw){ ?>
                    <tr style="position: relative;">
                        <td><?php echo $withdraw['withdraw_user_name']; ?></td>
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
                        <td><?php echo $withdraw['withdraw_user_parent_name']; ?></td>
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
                        <td style="position: relative; width: 140px;">
                            <?php if($withdraw['withdraw_status'] == 0 || $withdraw['withdraw_status'] == 7 || $withdraw['withdraw_status'] == 5){ ?>
                            <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" 
                                data-id="<?php echo $withdraw['withdraw_id']; ?>" 
                                data-address="<?php echo $withdraw['withdraw_to_address'] . ' ' . $withdraw['withdraw_to_address_memo']; ?>" 
                                data-email="<?php echo $withdraw['withdraw_user_name']; ?>" 
                                data-amount="<?php echo $withdraw['withdraw_amount']; ?>" 
                                data-symbol="<?php echo $withdraw['withdraw_chain_symbol']; ?>" 
                                data-real="<?php echo $withdraw['withdraw_finally_amount']; ?>">拒绝提现</button>
                            <?php } ?>

                            <?php if($withdraw['withdraw_status'] == 0 || $withdraw['withdraw_status'] == 1 || $withdraw['withdraw_status'] == 5 || $withdraw['withdraw_status'] == 7){ ?>
                            <button class="layui-btn layui-btn-xs editbtn" 
                                data-id="<?php echo $withdraw['withdraw_id']; ?>" 
                                data-address="<?php echo $withdraw['withdraw_to_address'] . ' ' . $withdraw['withdraw_to_address_memo']; ?>" 
                                data-email="<?php echo $withdraw['withdraw_user_name']; ?>" 
                                data-amount="<?php echo $withdraw['withdraw_amount']; ?>" 
                                data-symbol="<?php echo $withdraw['withdraw_chain_symbol']; ?>" 
                                data-real="<?php echo $withdraw['withdraw_finally_amount']; ?>">转发到钱包</button>
                            <?php } ?>
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

            $('#search_btn').click(function(){

                var searchValue = $.trim($('#search_value').val());

                if (searchValue == '') {

                    layer.msg('请输入搜索内容');
                }else{

                    layuiLoadIndex = layer.load();
                    window.location.href = $(this).attr('data-url') + '?search=' + searchValue;
                }
            });

            //通过申请
            $('.editbtn').click(function(){

                var _this = $(this);
                var _withdrawId = _this.attr('data-id');
                var _coinName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '通过申请将会为对方扣款!<br /><br />' + 
                    '提现帐户：' + _this.attr('data-email') + '<br />' + 
                    '提现币种：' + _this.attr('data-symbol') + '<br />' + 
                    '转出地址：' + _this.attr('data-address') + '<br />' + 
                    '提现数量：' + _this.attr('data-amount') + '<br />' + 
                    '实现到帐：' + _this.attr('data-real') + '<br /><br />' +
                    '请确认已验证过提现信息',
                    {
                        title: '通过提现申请',
                        icon: 0,
                        area: '700px',
                        skin: 'my-layer-green',
                        btn: ['通过，转发到钱包', '取消']
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/finance/withdraw/edit',
                            type: 'post',
                            data: {
                                'withdraw_id' : _withdrawId,
                                'action' : 1
                            },
                            dataType: 'json',
                            success: function (data) {
                                
                                layer.close(layuiLoadIndex);
                                layer.msg(data.message);

                                if (data.status) {

                                    setTimeout(function(){

                                        window.location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(){

                                layer.close(layuiLoadIndex);
                                layer.msg('网络繁忙，请稍后再试');
                            }
                        });
                    }
                );

                return false;
            });


            //拒绝
            $('.delbtn').click(function(){

                var _this = $(this);
                var _withdrawId = _this.attr('data-id');
                var _coinName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '拒绝后不可更改!<br /><br />' + 
                    '提现帐户：' + _this.attr('data-email') + '<br />' + 
                    '提现币种：' + _this.attr('data-symbol') + '<br />' + 
                    '转出地址：' + _this.attr('data-address') + '<br />' + 
                    '提现数量：' + _this.attr('data-amount') + '<br />' + 
                    '实现到帐：' + _this.attr('data-real') + '<br /><br />' +
                    '请确认是否拒绝？',
                    {
                        title: '拒绝提现申请',
                        icon: 0,
                        area: '700px',
                        skin: 'my-layer-red',
                        btn: ['拒绝', '取消']
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/finance/withdraw/edit',
                            type: 'post',
                            data: {
                                'withdraw_id' : _withdrawId,
                                'action' : 0
                            },
                            dataType: 'json',
                            success: function (data) {
                                
                                layer.close(layuiLoadIndex);
                                layer.msg(data.message);

                                if (data.status) {

                                    setTimeout(function(){

                                        window.location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(){

                                layer.close(layuiLoadIndex);
                                layer.msg('网络繁忙，请稍后再试');
                            }
                        });
                    }
                );

                return false;
            });

            var coin = {

                checkForm: function(data){

                    if (data.withdraw_name == '') {

                        layer.msg('请填写币种名称');
                        return false;
                    }

                    if (data.withdraw_symbol == '') {

                        layer.msg('请填写币种标识');
                        return false;
                    }

                    if (data.withdraw_icon == '') {

                        layer.msg('请上传币种图标');
                        return false;
                    }

                    if (data.withdraw_token_status == '1' && data.withdraw_token_address == '') {

                        layer.msg('请填写代币合约地址');
                        return false;
                    }

                    if (data.withdraw_withdraw_static_address_status == '1' && data.withdraw_withdraw_static_address == '') {

                        layer.msg('请填写静态提现地址');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    $('#editbox [name=withdraw_id]').val(0);
                    $('#editbox [name=withdraw_name]').val('');
                    $('#editbox [name=withdraw_symbol]').val('');
                    $('#editbox [name=withdraw_info]').val('');
                    $('#editbox [name=withdraw_icon]').val('').siblings('img').attr('src', '').hide();
                    $('#editbox [name=withdraw_decimal]').val(18);
                    $('#editbox [name=withdraw_token_status][value=0]').prop('checked', true);
                    $('#editbox [name=withdraw_token_address]').val('');
                    $('#editbox [name=withdraw_withdraw_status]').val(1).prop('checked', true);
                    $('#editbox [name=withdraw_withdraw_static_address_status][value=0]').prop('checked', true);
                    $('#editbox [name=withdraw_withdraw_static_address]').val('');
                    $('#editbox [name=withdraw_withdraw_status]').val(1).prop('checked', true);
                    $('#editbox [name=withdraw_withdraw_amount]').val(0.0001);
                    $('#editbox [name=withdraw_withdraw_fee]').val(0.0001);
                    $('#editbox [name=withdraw_index]').val(0);
                    $('#editbox [name=withdraw_status]').val(1).prop('checked', true);

                    form.render();
                }
            }
        });
    </script>
</body>
</html>
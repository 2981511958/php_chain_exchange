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
            .layui-table .sendbtn{ position: absolute; top: 11px; right: 175px; }
            .layui-table .editbtn{ position: absolute; top: 5px; right: 10px; }
            .layui-table .delbtn{ position: absolute; top: 5px; right: 10px; }
        </style>

        <div class="mainbox">

            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="<?php echo $plateId == 1 ? 'layui-this' : ''; ?>">币币帐户</li>
                    <li class="<?php echo $plateId == 2 ? 'layui-this' : ''; ?>">法币帐户</li>
                    <li class="<?php echo $plateId == 4 ? 'layui-this' : ''; ?>">合约帐户</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item <?php echo $plateId == 1 ? 'layui-show' : ''; ?>">
                        <table class="layui-table">
                            <colgroup>
                                <col style="width: 110px;">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col style="width: 100px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>图标</th>
                                    <th>币种</th>
                                    <th>总额</th>
                                    <th>可用</th>
                                    <th>冻结</th>
                                    <th>操作</th>
                                </tr> 
                            </thead>
                            <tbody>

                                <?php if(count($userAsset)){ foreach($userAsset as $coin){ ?>
                                <tr style="position: relative;">
                                    <td><img class="imgpreview" src="<?php echo $coin['coin_icon']; ?>" style="display: inline; margin: -20px 0px;"></td>
                                    <td><?php echo $coin['coin_symbol']; ?></td>
                                    <td><?php echo $coin['asset_total']; ?></td>
                                    <td><?php echo $coin['asset_active']; ?></td>
                                    <td><?php echo $coin['asset_frozen']; ?></td>
                                    <td style="position: relative;">
                                        <button class="layui-btn layui-btn-sm editbtn" data-title="资产调整 - 币币帐户 - <?php echo $user['user_name']; ?> - <?php echo $coin['coin_symbol']; ?>" coin-symbol="<?php echo $coin['coin_symbol']; ?>" data-text="<?php echo $coin['coin_symbol']; ?>" coin-id="<?php echo $coin['coin_id']; ?>" data-plate="1">资产调整</button>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-tab-item <?php echo $plateId == 2 ? 'layui-show' : ''; ?>">

                    </div>
                    <div class="layui-tab-item <?php echo $plateId == 4 ? 'layui-show' : ''; ?>">
                        <table class="layui-table">
                            <colgroup>
                                <col style="width: 110px;">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col style="width: 100px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>图标</th>
                                    <th>币种</th>
                                    <th>总额</th>
                                    <th>可用</th>
                                    <th>冻结</th>
                                    <th>操作</th>
                                </tr> 
                            </thead>
                            <tbody>

                                <?php if(count($userDmAsset)){ foreach($userDmAsset as $dmAsset){ ?>
                                <tr style="position: relative;">
                                    <td><img class="imgpreview" src="<?php echo $dmAsset['market_stock_icon']; ?>" style="display: inline; margin: -20px 0px;"></td>
                                    <td><?php echo $dmAsset['market_stock_symbol']; ?></td>
                                    <td><?php echo $dmAsset['asset_total']; ?></td>
                                    <td><?php echo $dmAsset['asset_active']; ?></td>
                                    <td><?php echo $dmAsset['asset_frozen']; ?></td>
                                    <td style="position: relative;">
                                        <button class="layui-btn layui-btn-sm editbtn" data-title="资产调整 - 合约帐户 - <?php echo $user['user_name']; ?> - <?php echo $dmAsset['market_stock_symbol']; ?>" coin-symbol="<?php echo $dmAsset['market_stock_symbol']; ?>" data-text="<?php echo $dmAsset['market_stock_symbol']; ?>" coin-id="<?php echo $dmAsset['market_stock_coin']; ?>" data-plate="4">资产调整</button>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- 编辑框 -->
        <div class="editbox displaynone" id="editbox" style="min-width: 0px;">
            
            <div class="layui-form layui-form-pane">

                <input type="hidden" name="change_user" value="<?php echo $user['user_id']; ?>">
                <input type="hidden" name="change_coin_symbol" value="0">
                <input type="hidden" name="change_coin_id" value="0">
                <input type="hidden" name="change_plate" value="0">

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">资产变动</label>
                    <div class="layui-input-block mypane">
                        <input type="radio" name="change_action" value="5" title="增加" checked>
                        <input type="radio" name="change_action" value="6" title="扣除">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">变动额度</label>
                    <div class="layui-input-block">
                        <input type="text" name="change_amount" placeholder="请输入变动额度" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">变动说明</label>
                    <div class="layui-input-block">
                        <input type="text" name="change_remark" placeholder="请输入变动说明" class="layui-input">
                    </div>
                </div>
            </div>
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

            //调整资产
            $('.editbtn').click(function(){

                var _this = $(this);

                layuiOpenIndex = layer.open({

                    title: _this.attr('data-title'),
                    type: 1,
                    content: $('#editbox'),
                    skin: 'my-layer-green',
                    area: '500px',
                    btnAlign: 'c',
                    btn: ['提交', '取消'],
                    maxmin: false,
                    zIndex: 99,
                    success: function(){

                        $('#editbox [name=change_coin_symbol]').val(_this.attr('coin-symbol'));
                        $('#editbox [name=change_plate]').val(_this.attr('data-plate'));
                        $('#editbox [name=change_coin_id]').val(_this.attr('coin-id'));
                    },
                    yes: function(){

                        var data = {

                            'change_user' : $('#editbox [name=change_user]').val(),
                            'change_coin_symbol' : $('#editbox [name=change_coin_symbol]').val(),
                            'change_action' : $('#editbox [name=change_action]:checked').val(),
                            'change_amount' : $('#editbox [name=change_amount]').val(),
                            'change_plate' : $('#editbox [name=change_plate]').val(),
                            'change_coin_id' : $('#editbox [name=change_coin_id]').val(),
                            'change_remark' : $('#editbox [name=change_remark]').val()
                        };

                        if (user.checkForm(data)) {

                            layuiLoadIndex = layer.load();

                            $.ajax({
                                url: '/manage/user/asset/changeUserCoinAsset',
                                type: 'post',
                                data: data,
                                dataType: 'json',
                                success: function (data) {
                                    
                                    layer.close(layuiLoadIndex);
                                    layer.msg(data.message);

                                    if (data.status) {

                                        var plateId = $('#editbox [name=change_plate]').val();

                                        layer.close(layuiOpenIndex);
                                        setTimeout(function(){

                                            window.location.href = '/manage/user/asset/user_asset/<?php echo $user['user_id']; ?>/' + plateId;
                                        }, 1000);
                                    }
                                },
                                error: function(){

                                    layer.close(layuiLoadIndex);
                                    layer.msg('网络繁忙，请稍后再试');
                                }
                            });
                        }
                    },
                    end: function(){

                        layer.close(layuiOpenIndex);
                        
                        user.formRender();
                    }
                });
            });

            var user = {

                checkForm: function(data){

                    if (data.change_amount == '') {

                        layer.msg('请填写变动额度');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    $('#editbox [name=change_plate]').val(0);
                    $('#editbox [name=change_coin_symbol]').val(0);
                    $('#editbox [name=change_action][value=5]').prop('checked', true);
                    $('#editbox [name=change_amount]').val('');
                    $('#editbox [name=change_remark]').val('');

                    form.render();
                }
            }
        });
    </script>
</body>
</html>
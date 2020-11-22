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
            <button class="layui-btn addbtn" id="addbtn" data-title="添加交易市场">添加交易市场</button>
            币币交易 > 交易对管理
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
        </style>

        <div class="mainbox">

            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <?php if($marketList && count($marketList)){ $i = 1; foreach($marketList as $marketMoneySymbol => $marketListItem){ ?>
                        <li class="<?php echo $i == 1 ? 'layui-this' : ''; ?>"><?php echo $marketMoneySymbol; ?> 交易</li>
                    <?php $i ++; }} ?>
                </ul>
                <div class="layui-tab-content">
                    <?php if($marketList && count($marketList)){ $i = 1; foreach($marketList as $marketMoneySymbol => $marketListItem){ ?>
                        <div class="layui-tab-item <?php echo $i == 1 ? 'layui-show' : ''; ?>">
                            <table class="layui-table" >
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col style="width: 160px;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>交易对</th>
                                        <th>小数位数</th>
                                        <th>最小发布值</th>
                                        <th>Taker费率</th>
                                        <th>Maker费率</th>
                                        <th>排序</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr> 
                                </thead>
                                <tbody>

                                    <?php if(count($marketListItem)){ foreach($marketListItem as $market){ ?>
                                    <tr style="position: relative;">
                                        <td><?php echo $market['market_stock_symbol'] . ' / ' . $market['market_money_symbol']; ?></td>
                                        <td><?php echo $market['market_decimal']; ?></td>
                                        <td><?php echo floatval($market['market_min_amount']); ?></td>
                                        <td><?php echo floatval($market['market_taker_fee']); ?></td>
                                        <td><?php echo floatval($market['market_maker_fee']); ?></td>
                                        <td><?php echo $market['market_index']; ?></td>
                                        <td>
                                            <a class="layui-btn <?php echo $market['market_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $market['market_status'] == '1' ? '正常' : '禁用'; ?></a> 
                                        </td>
                                        <td style="position: relative;">
                                            <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" data-title="删除市场 - <?php echo $market['market_stock_symbol'] . ' / ' . $market['market_money_symbol']; ?>" data-id="<?php echo $market['market_id']; ?>" data-text="<?php echo $market['market_stock_symbol'] . ' / ' . $market['market_money_symbol']; ?>">删除市场</button>
                                            <button class="layui-btn layui-btn-warm layui-btn-xs editbtn" data-id="<?php echo $market['market_id']; ?>" data-title="编辑市场 - <?php echo $market['market_stock_symbol'] . ' / ' . $market['market_money_symbol']; ?>">编辑市场</button>
                                        </td>
                                    </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                    <?php $i ++; }} ?>
                </div>
            </div>
        </div>

        <!-- 编辑框 -->
        <div class="editbox displaynone" id="editbox">
            
            <div class="layui-form layui-form-pane">

                <input type="hidden" name="market_id" value="0">
                <input type="hidden" name="market_plate" value="1">

                <div class="layui-form-item">
                    <label class="layui-form-label">交易币种</label>
                    <div class="layui-input-block">
                        <select name="market_stock_coin" lay-filter="add_ac_c">
                            <option value="0">请选择交易币种</option>
                            <?php if($coinList && count($coinList)){ foreach ( $coinList as $coin) { ?>
                                <option value="<?php  echo $coin['coin_id']; ?>"><?php echo $coin['coin_symbol']; ?></option>
                            <?php }}; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">结算币种</label>
                    <div class="layui-input-block">
                        <select name="market_money_coin" lay-filter="add_ac_c">
                            <option value="0">请选择交易币种</option>
                            <?php if($coinList && count($coinList)){ foreach ( $coinList as $coin) { ?>
                                <option value="<?php  echo $coin['coin_id']; ?>"><?php echo $coin['coin_symbol']; ?></option>
                            <?php }}; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">小数位数</label>
                    <div class="layui-input-block">
                        <input type="text" name="market_decimal" placeholder="请输入小数位数" class="layui-input" value="4" oninput="value=value.replace(/[^\d]/g,''); value=(value==''?0:parseInt(value));">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最小发布量</label>
                    <div class="layui-input-block">
                        <input type="text" name="market_min_amount" placeholder="请输入允许最小交易量的值,最少0.0001" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">Taker费率</label>
                    <div class="layui-input-block">
                        <input type="text" name="market_taker_fee" placeholder="请输入Taker费率百分比,最少0.0001" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">Maker费率</label>
                    <div class="layui-input-block">
                        <input type="text" name="market_maker_fee" placeholder="请输入Maker费率百分比,最少0.0001" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="market_index" placeholder="请输入排序数字，越大越靠前" class="layui-input" value="0" oninput="value=value.replace(/[^\d]/g,''); value=(value==''?0:parseInt(value));">
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">交易状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="market_status" lay-skin="switch" checked lay-text="正常|禁用" value="1">
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

            //兼容layui的select的change事件
            form.on('select', function(data){

                $(data.elem).trigger('change');

            });

            //兼容layui的switch
            form.on('switch', function(data){

                if (data.elem.checked) {

                    $(data.elem).val(1).prop('checked', true);
                }else{

                    $(data.elem).val(0).prop('checked', false);
                }
            });

            //添加币种
            $('#addbtn').click(function(){

                var _this = $(this);

                layuiOpenIndex = layer.open({

                    title: _this.attr('data-title'),
                    type: 1,
                    content: $('#editbox'),
                    skin: 'my-layer-green',
                    area: '80%',
                    btnAlign: 'c',
                    btn: ['提交', '取消'],
                    maxmin: true,
                    zIndex: 99,
                    success: function(){

                    },
                    yes: function(){

                        var data = {

                            'market_plate' : $('#editbox [name=market_plate]').val(),
                            'market_stock_coin' : $('#editbox [name=market_stock_coin]').val(),
                            'market_money_coin' : $('#editbox [name=market_money_coin]').val(),
                            'market_decimal' : $('#editbox [name=market_decimal]').val(),
                            'market_min_amount' : $('#editbox [name=market_min_amount]').val(),
                            'market_taker_fee' : $('#editbox [name=market_taker_fee]').val(),
                            'market_maker_fee' : $('#editbox [name=market_maker_fee]').val(),
                            'market_index' : $('#editbox [name=market_index]').val(),
                            'market_status' : $('#editbox [name=market_status]').val()
                        };

                        if (market.checkForm(data)) {

                            layuiLoadIndex = layer.load();

                            $.ajax({
                                url: '/manage/bibi/market/add',
                                type: 'post',
                                data: data,
                                dataType: 'json',
                                success: function (data) {
                                    
                                    layer.close(layuiLoadIndex);
                                    layer.msg(data.message);

                                    if (data.status) {

                                        layer.close(layuiOpenIndex);
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
                    },
                    end: function(){

                        layer.close(layuiOpenIndex);
                        
                        market.formRender();
                    }
                });
            });


            //编辑市场
            $('.editbtn').click(function(){

                var _this = $(this);

                var _marketId = _this.attr('data-id');

                layuiLoadIndex = layer.load();

                //获取数据
                $.ajax({

                    url: '/manage/bibi/market/one',
                    type: 'post',
                    data: {

                        'market_id' : _marketId
                    },
                    dataType: 'json',
                    success: function (data) {

                        if (data.status) {
                            
                            //更新表单

                            $('#editbox [name=market_id]').val(data.market.market_id);
                            $('#editbox [name=market_plate]').val(data.market.market_plate);
                            $('#editbox [name=market_stock_coin]').val(data.market.market_stock_coin);
                            $('#editbox [name=market_money_coin]').val(data.market.market_money_coin);
                            $('#editbox [name=market_decimal]').val(data.market.market_decimal);
                            $('#editbox [name=market_min_amount]').val(data.market.market_min_amount);
                            $('#editbox [name=market_taker_fee]').val(data.market.market_taker_fee);
                            $('#editbox [name=market_maker_fee]').val(data.market.market_maker_fee);
                            $('#editbox [name=market_index]').val(data.market.market_index);

                            //swtich
                            if (data.market.market_status == '1') {

                                $('#editbox [name=market_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=market_status]').val(0).prop('checked', false);
                            }

                            form.render();
                            layer.close(layuiLoadIndex);

                            layuiOpenIndex = layer.open({

                                title: _this.attr('data-title'),
                                type: 1,
                                content: $('#editbox'),
                                skin: 'my-layer-yellow',
                                area: '80%',
                                maxHeight: '500px',
                                btnAlign: 'c',
                                btn: ['提交', '取消'],
                                maxmin: true,
                                zIndex: 99,
                                success: function(){

                                },
                                yes: function(){

                                    var data = {

                                        'market_id' : $('#editbox [name=market_id]').val(),
                                        'market_plate' : $('#editbox [name=market_plate]').val(),
                                        'market_stock_coin' : $('#editbox [name=market_stock_coin]').val(),
                                        'market_money_coin' : $('#editbox [name=market_money_coin]').val(),
                                        'market_decimal' : $('#editbox [name=market_decimal]').val(),
                                        'market_min_amount' : $('#editbox [name=market_min_amount]').val(),
                                        'market_taker_fee' : $('#editbox [name=market_taker_fee]').val(),
                                        'market_maker_fee' : $('#editbox [name=market_maker_fee]').val(),
                                        'market_index' : $('#editbox [name=market_index]').val(),
                                        'market_status' : $('#editbox [name=market_status]').val()
                                    };

                                    if (market.checkForm(data)) {

                                        layuiLoadIndex = layer.load();

                                        $.ajax({
                                            url: '/manage/bibi/market/edit',
                                            type: 'post',
                                            data: data,
                                            dataType: 'json',
                                            success: function (data) {
                                                
                                                layer.close(layuiLoadIndex);
                                                layer.msg(data.message);

                                                if (data.status) {

                                                    layer.close(layuiOpenIndex);
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
                                },
                                end: function(){

                                    layer.close(layuiOpenIndex);
                                    
                                    market.formRender();
                                }
                            });
                        }else{

                            layer.close(layuiLoadIndex);
                            layer.msg(data.message);
                        }
                    },
                    error: function(){

                        layer.close(layuiLoadIndex);
                        layer.msg('网络繁忙，请稍后再试');
                    }
                });

                return false;
            });


            //删除市场
            $('.delbtn').click(function(){

                var _this = $(this);
                var _marketId = _this.attr('data-id');
                var _marketName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '数据删除将不可恢复！<br />确定删除交易市场：' + _marketName + ' ?',
                    {
                        title: _this.attr('data-title'),
                        icon: 0,
                        skin: 'my-layer-red'
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/bibi/market/delete',
                            type: 'post',
                            data: {
                                'market_id' : _marketId
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

            var market = {

                checkForm: function(data){

                    if (data.market_stock_coin == '0') {

                        layer.msg('请选择交易币种');
                        return false;
                    }

                    if (data.market_money_coin == '0') {

                        layer.msg('请选择结算币种');
                        return false;
                    }

                    if (data.market_decimal == '') {

                        layer.msg('请填写小数位数');
                        return false;
                    }

                    if (data.market_min_amount == '') {

                        layer.msg('请填写最小发布量');
                        return false;
                    }

                    if (data.market_taker_fee == '') {

                        layer.msg('请填写Taker费率');
                        return false;
                    }

                    if (data.market_maker_fee == '') {

                        layer.msg('请填写Maker费率');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    $('#editbox [name=market_id]').val(0);
                    $('#editbox [name=market_plate]').val(1);
                    $('#editbox [name=market_stock_coin]').val(0);
                    $('#editbox [name=market_money_coin]').val(0);
                    $('#editbox [name=market_decimal]').val(4);
                    $('#editbox [name=market_min_amount]').val(0.0001);
                    $('#editbox [name=market_taker_fee]').val(0.0001);
                    $('#editbox [name=market_maker_fee]').val(0.0001);
                    $('#editbox [name=market_index]').val(0);
                    $('#editbox [name=market_status]').val(1).prop('checked', true);

                    form.render();
                }
            }
        });
    </script>
</body>
</html>
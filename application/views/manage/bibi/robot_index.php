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
            <button class="layui-btn addbtn" id="addbtn" data-title="添加交易机器人">添加机器人</button>
            币币交易 > 机器人管理
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
        </style>

        <div class="mainbox">

            
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <?php if($marketListGroup && count($marketListGroup)){ $i = 0; foreach($marketListGroup as $moneySymbol => $marketGroupItem){ ?>
                    <li class="<?php echo $i == 0 ? 'layui-this' : ''; ?>"><?php echo $moneySymbol; ?> 市场</li>
                    <?php $i ++; }} ?>
                </ul>
                <div class="layui-tab-content">
                    <?php if($marketListGroup && count($marketListGroup)){ $i = 0; foreach($marketListGroup as $moneySymbol => $marketGroupItem){ ?>
                    <div class="layui-tab-item <?php echo $i == 0 ? 'layui-show' : ''; ?>">
                        
                        <table class="layui-table" >
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col style="width: 150px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>交易对</th>
                                    <th>火币行情</th>
                                    <th>最低价</th>
                                    <th>最高价</th>
                                    <th>最低数量</th>
                                    <th>最高数量</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr> 
                            </thead>
                            <tbody>

                                <?php if(count($robotList)){ foreach($robotList as $robot){ if($marketList[$robot['robot_market']]['market_money_symbol'] == $moneySymbol){ ?>
                                <tr style="position: relative;">
                                    <td><?php echo $marketList[$robot['robot_market']]['market_stock_symbol'] . ' / ' . $marketList[$robot['robot_market']]['market_money_symbol']; ?></td>
                                    <td>
                                        <a class="layui-btn <?php echo $robot['robot_huobi'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $robot['robot_huobi'] == '1' ? '是' : '否'; ?></a> 
                                    </td>
                                    <td><?php echo floatval($robot['robot_min_price']); ?></td>
                                    <td><?php echo floatval($robot['robot_max_price']); ?></td>
                                    <td><?php echo floatval($robot['robot_min_amount']); ?></td>
                                    <td><?php echo floatval($robot['robot_max_amount']); ?></td>
                                    <td>
                                        <a class="layui-btn <?php echo $robot['robot_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $robot['robot_status'] == '1' ? '正常' : '禁用'; ?></a> 
                                    </td>
                                    <td style="position: relative; width: 150px;">
                                        <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" data-title="删除机器人 - <?php echo $marketList[$robot['robot_market']]['market_stock_symbol'] . ' / ' . $marketList[$robot['robot_market']]['market_money_symbol']; ?>" data-id="<?php echo $robot['robot_id']; ?>" data-text="<?php echo $marketList[$robot['robot_market']]['market_stock_symbol'] . ' / ' . $marketList[$robot['robot_market']]['market_money_symbol']; ?>">删除机器人</button>
                                        <button class="layui-btn layui-btn-warm layui-btn-xs editbtn" data-id="<?php echo $robot['robot_id']; ?>" data-title="编辑机器人 - <?php echo $marketList[$robot['robot_market']]['market_stock_symbol'] . ' / ' . $marketList[$robot['robot_market']]['market_money_symbol']; ?>">编辑机器人</button>
                                    </td>
                                </tr>
                                <?php }}} ?>
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

                <input type="hidden" name="robot_id" value="0">
                <input type="hidden" name="robot_price_float" value="1">

                <div class="layui-form-item">
                    <label class="layui-form-label">交易市场</label>
                    <div class="layui-input-block">
                        <select name="robot_market" lay-filter="add_ac_c">
                            
                            <option value="0">请选择交易市场</option>

                            <?php if($marketListGroup && count($marketListGroup)){ foreach ( $marketListGroup as $moneySymbol => $marketListItem) { ?>
                            <optgroup label="<?php echo $moneySymbol; ?> 市场">
                                  <?php if($marketListItem && count($marketListItem)){ foreach ( $marketListItem as $market) { ?>
                                      <option value="<?php  echo $market['market_id']; ?>">  <?php echo $market['market_stock_symbol']; ?> / <?php echo $market['market_money_symbol']; ?></option>
                                  <?php }} ?>
                            </optgroup>
                            <?php }}; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">火币行情</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="robot_huobi" lay-skin="switch" lay-text="火币有行情|火币无行情" value="0">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">火币交易对</label>
                    <div class="layui-input-block">
                        <input type="text" name="robot_huobi_symbol" placeholder="如：BTCUSDT" class="layui-input">
                        当交易对需要使用另外在火币上的交易对的行情时，需要开启火币行情并设置交易对，一般不用设置
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最低价格</label>
                    <div class="layui-input-block">
                        <input type="text" name="robot_min_price" placeholder="请输入最低价格" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最高价格</label>
                    <div class="layui-input-block">
                        <input type="text" name="robot_max_price" placeholder="请输入最高价格" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最低数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="robot_min_amount" placeholder="请输入最低数量" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最高数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="robot_max_amount" placeholder="请输入最高数量" class="layui-input">
                    </div>
                </div>

                <fieldset class="layui-elem-field">
                    <legend>行情计划 (只适用于无火币行情)</legend>
                    <div class="layui-field-box">
                        
                        <div class="layui-form-item" pane>
                            <label class="layui-form-label">计划开关</label>
                            <div class="layui-input-block">
                                <input type="checkbox" name="robot_cron" lay-skin="switch" lay-text="正常|禁用" value="0">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">开始时间</label>
                            <div class="layui-input-block">
                                <input type="text" name="robot_cron_start" id="robot_cron_start" placeholder="请选择开始时间" readonly class="layui-input" style="cursor: pointer;">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">结束时间</label>
                            <div class="layui-input-block">
                                <input type="text" name="robot_cron_end" id="robot_cron_end" placeholder="请选择结束时间" readonly class="layui-input" style="cursor: pointer;">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">目标价格</label>
                            <div class="layui-input-block">
                                <input type="text" name="robot_cron_target" placeholder="请输入目标价格" class="layui-input">
                            </div>
                        </div>

                    </div>
                </fieldset>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="robot_status" lay-skin="switch" checked lay-text="正常|禁用" value="1">
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

            laydate.render({
                elem: '#robot_cron_start', //指定元素
                type: 'datetime'
            });

            laydate.render({
                elem: '#robot_cron_end', //指定元素
                type: 'datetime'
            });

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

            //添加
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

                            'robot_market' : $('#editbox [name=robot_market]').val(),
                            'robot_huobi' : $('#editbox [name=robot_huobi]').val(),
                            'robot_huobi_symbol' : $('#editbox [name=robot_huobi_symbol]').val(),
                            'robot_price_float' : $('#editbox [name=robot_price_float]').val(),
                            'robot_min_price' : $('#editbox [name=robot_min_price]').val(),
                            'robot_max_price' : $('#editbox [name=robot_max_price]').val(),
                            'robot_min_amount' : $('#editbox [name=robot_min_amount]').val(),
                            'robot_max_amount' : $('#editbox [name=robot_max_amount]').val(),

                            'robot_cron' : $('#editbox [name=robot_cron]').val(),
                            'robot_cron_start' : $('#editbox [name=robot_cron_start]').val(),
                            'robot_cron_end' : $('#editbox [name=robot_cron_end]').val(),
                            'robot_cron_target' : $('#editbox [name=robot_cron_target]').val(),

                            'robot_status' : $('#editbox [name=robot_status]').val()
                            
                        };

                        if (robot.checkForm(data)) {

                            layuiLoadIndex = layer.load();

                            $.ajax({
                                url: '/manage/bibi/robot/add',
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
                        
                        robot.formRender();
                    }
                });
            });


            //编辑机器人
            $('.editbtn').click(function(){

                var _this = $(this);

                var _robotId = _this.attr('data-id');

                layuiLoadIndex = layer.load();

                //获取数据
                $.ajax({

                    url: '/manage/bibi/robot/one',
                    type: 'post',
                    data: {

                        'robot_id' : _robotId
                    },
                    dataType: 'json',
                    success: function (data) {

                        if (data.status) {
                            
                            //更新表单

                            $('#editbox [name=robot_id]').val(data.robot.robot_id);
                            $('#editbox [name=robot_market]').val(data.robot.robot_market);
                            $('#editbox [name=robot_price_float]').val(data.robot.robot_price_float);
                            $('#editbox [name=robot_min_price]').val(data.robot.robot_min_price);
                            $('#editbox [name=robot_max_price]').val(data.robot.robot_max_price);
                            $('#editbox [name=robot_min_amount]').val(data.robot.robot_min_amount);
                            $('#editbox [name=robot_max_amount]').val(data.robot.robot_max_amount);
                            $('#editbox [name=robot_huobi_symbol]').val(data.robot.robot_huobi_symbol);

                            $('#editbox [name=robot_cron_start]').val(data.robot.robot_cron_start);
                            $('#editbox [name=robot_cron_end]').val(data.robot.robot_cron_end);
                            $('#editbox [name=robot_cron_target]').val(data.robot.robot_cron_target);
                            
                            //swtich
                            if (data.robot.robot_status == '1') {

                                $('#editbox [name=robot_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=robot_status]').val(0).prop('checked', false);
                            }

                            if (data.robot.robot_huobi == '1') {

                                $('#editbox [name=robot_huobi]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=robot_huobi]').val(0).prop('checked', false);
                            }

                            if (data.robot.robot_cron == '1') {

                                $('#editbox [name=robot_cron]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=robot_cron]').val(0).prop('checked', false);
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

                                        'robot_id' : $('#editbox [name=robot_id]').val(),
                                        'robot_market' : $('#editbox [name=robot_market]').val(),
                                        'robot_huobi' : $('#editbox [name=robot_huobi]').val(),
                                        'robot_huobi_symbol' : $('#editbox [name=robot_huobi_symbol]').val(),
                                        'robot_price_float' : $('#editbox [name=robot_price_float]').val(),
                                        'robot_min_price' : $('#editbox [name=robot_min_price]').val(),
                                        'robot_max_price' : $('#editbox [name=robot_max_price]').val(),
                                        'robot_min_amount' : $('#editbox [name=robot_min_amount]').val(),
                                        'robot_max_amount' : $('#editbox [name=robot_max_amount]').val(),

                                        'robot_cron' : $('#editbox [name=robot_cron]').val(),
                                        'robot_cron_start' : $('#editbox [name=robot_cron_start]').val(),
                                        'robot_cron_end' : $('#editbox [name=robot_cron_end]').val(),
                                        'robot_cron_target' : $('#editbox [name=robot_cron_target]').val(),

                                        'robot_status' : $('#editbox [name=robot_status]').val()
                                    };

                                    if (robot.checkForm(data)) {

                                        layuiLoadIndex = layer.load();

                                        $.ajax({
                                            url: '/manage/bibi/robot/edit',
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
                                    
                                    robot.formRender();
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


            //删除机器人
            $('.delbtn').click(function(){

                var _this = $(this);
                var _robotId = _this.attr('data-id');
                var _marketName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '数据删除将不可恢复！<br />确定删除机器人：' + _marketName + ' ?',
                    {
                        title: _this.attr('data-title'),
                        icon: 0,
                        skin: 'my-layer-red'
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/bibi/robot/delete',
                            type: 'post',
                            data: {
                                'market_id' : _robotId
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

            var robot = {

                checkForm: function(data){
                    
                    if (data.robot_market == '0') {

                        layer.msg('请选择交易市场');
                        return false;
                    }

                    if (data.robot_min_price == '' || parseFloat(data.robot_min_price) <= 0) {

                        layer.msg('请填写最低价格');
                        return false;
                    }

                    if (data.robot_max_price == '' || parseFloat(data.robot_max_price) <= 0) {

                        layer.msg('请填写最高价格');
                        return false;
                    }

                    if (data.robot_min_amount == '' || parseFloat(data.robot_min_amount) <= 0) {

                        layer.msg('请填写最低数量');
                        return false;
                    }

                    if (data.robot_max_amount == '' || parseFloat(data.robot_max_amount) <= 0) {

                        layer.msg('请填写最高数量');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    $('#editbox [name=robot_id]').val(0);
                    $('#editbox [name=robot_market]').val(1);
                    $('#editbox [name=robot_huobi]').val(0).prop('checked', false);
                    $('#editbox [name=robot_min_price]').val(0);
                    $('#editbox [name=robot_max_price]').val(4);
                    $('#editbox [name=robot_min_amount]').val(0.0001);
                    $('#editbox [name=robot_max_amount]').val(0.0001);
                    $('#editbox [name=robot_status]').val(1).prop('checked', true);

                    $('#editbox [name=robot_cron]').val(0).prop('checked', false);
                    $('#editbox [name=robot_cron_start]').val('');
                    $('#editbox [name=robot_cron_end]').val('');
                    $('#editbox [name=robot_cron_target]').val('');

                    form.render();
                }
            }
        });
    </script>
</body>
</html>
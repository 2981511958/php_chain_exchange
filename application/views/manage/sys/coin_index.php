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
            <button class="layui-btn addbtn" id="addbtn" data-title="添加币种">添加币种</button>
            系统设置 > 币种管理
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
        </style>

        <div class="mainbox">
            
            <table class="layui-table" >
                <colgroup>
                    <col style="width: 110px;">
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
                        <th>图标</th>
                        <th>货币标识</th>
                        <th>所属主链</th>
                        <th>充值</th>
                        <th>提现</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php if(count($coinList)){ foreach($coinList as $coin){ ?>
                    <tr style="position: relative;">
                        <td><img class="imgpreview" src="<?php echo $coin['coin_icon']; ?>" style="display: inline; margin: -20px 0px;"></td>
                        <td><?php echo $coin['coin_symbol']; ?></td>
                        <td><?php echo $chainList[$coin['coin_chain']]; ?></td>
                        <td>
                            <a class="layui-btn <?php echo $coin['coin_recharge_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $coin['coin_recharge_status'] == '1' ? '开启' : '关闭'; ?></a> 
                        </td>
                        <td>
                            <a class="layui-btn <?php echo $coin['coin_withdraw_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $coin['coin_withdraw_status'] == '1' ? '开启' : '关闭'; ?></a> 
                        </td>
                        <td><?php echo $coin['coin_index']; ?></td>
                        <td>
                            <a class="layui-btn <?php echo $coin['coin_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $coin['coin_status'] == '1' ? '正常' : '禁用'; ?></a> 
                        </td>
                        <td style="position: relative;">
                            <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" data-title="删除币种 - <?php echo $coin['coin_symbol']; ?>" data-id="<?php echo $coin['coin_id']; ?>" data-text="<?php echo $coin['coin_symbol']; ?>">删除币种</button>
                            <button class="layui-btn layui-btn-warm layui-btn-xs editbtn" data-id="<?php echo $coin['coin_id']; ?>" data-title="编辑币种 - <?php echo $coin['coin_symbol']; ?>">编辑币种</button>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>

        <!-- 编辑框 -->
        <div class="editbox displaynone" id="editbox">
            
            <div class="layui-form layui-form-pane">

                <input type="hidden" name="coin_id" value="0">
                <input type="hidden" name="coin_token_status" value="0">
                <input type="hidden" name="coin_decimal" value="18">
                <input type="hidden" name="coin_token_address" value="">
                <input type="hidden" name="coin_recharge_static_address_status" value="1">
                <input type="hidden" name="coin_recharge_static_address" value="">
                <input type="hidden" name="coin_name" value="">
                <input type="hidden" name="coin_info" value="">

                <div class="layui-form-item">
                    <label class="layui-form-label">货币标识</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_symbol" placeholder="请输入货币标识" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">货币图标</label>
                    <div class="layui-input-block">
                        <input type="hidden" name="coin_icon">
                        <button type="button" class="layui-btn upload" style="margin-left: 10px;">
                            <i class="layui-icon">&#xe67c;</i>上传货币图标
                        </button>
                        <img src="" class="imgpreview pointer" />
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">充值</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="coin_recharge_status" lay-skin="switch" checked lay-text="开启|关闭" value="1">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最低充值</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_recharge_min_amount" placeholder="请输入充值的最低数量" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">提现</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="coin_withdraw_status" lay-skin="switch" checked lay-text="开启|关闭" value="1">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">最低提现</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_withdraw_amount" placeholder="请输入提现的最低数量" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">提现费用</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_withdraw_fee" placeholder="请输入货币提现手续费" class="layui-input" value="0.0001">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">所属主链</label>
                    <div class="layui-input-block">
                        <select name="coin_chain" lay-filter="add_ac_c">
                            <option value="0">请选择主链</option>
                            <?php if($chainList && count($chainList)){ foreach ( $chainList as $chainCode => $chainName) { ?>
                                <option value="<?php  echo $chainCode; ?>"><?php echo $chainName; ?></option>
                            <?php }}; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">合约地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_contract" placeholder="请输入货币标识" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">Memo</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_memo" placeholder="请输入货币Memo" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">折合USD</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_usd" placeholder="请输入折合USD的价值" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="coin_index" placeholder="请输入排序数字，越大越靠前" class="layui-input" value="0" oninput="value=value.replace(/[^\d]/g,''); value=(value==''?0:parseInt(value));">
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">货币状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="coin_status" lay-skin="switch" checked lay-text="正常|禁用" value="1">
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

            //兼容layui的radio
            form.on('radio', function(data){

                $(data.elem).prop('checked', true).siblings('[name=' + $(data.elem).attr('name') + ']').prop('checked', false);
            });

            //创建update实例
            upload.render({

                elem: '.upload',
                url: '/manage/common/upload/images',
                accept: 'images',
                acceptMime: 'image/*',
                multiple: false,
                before: function(obj){

                    layuiLoadIndex = layer.load();
                },
                //上传完毕回调
                done: function(data){

                    layer.close(layuiLoadIndex);

                    if (data.status) {

                        //获取当前触发上传的元素
                        this.item.siblings('input[type=hidden]').val(data.filename[0]).siblings('img').attr('src', data.filename[0]).show();
                    }else{

                        layer.msg(data.message);
                    }
                },
                error: function(){
                    
                    layer.close(layuiLoadIndex);
                    layer.msg('网络繁忙，请稍后再试');
                }
            });

            //预览上传的图片
            $(document).on('click', '.previewitem img, .layui-table .imgpreview, .imgpreview', function(){

                var _this = $(this);

                layer.photos({
                    photos: {

                        "title": "", //相册标题
                        "id": 123, //相册id
                        "start": 0, //初始显示的图片序号，默认0
                        'data' : [

                            {
                                'src' : _this.attr('src')
                            }
                        ]
                    },
                    anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                });
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

                            'coin_name' : $('#editbox [name=coin_name]').val(),
                            'coin_symbol' : $('#editbox [name=coin_symbol]').val(),
                            'coin_info' : $('#editbox [name=coin_info]').val(),
                            'coin_icon' : $('#editbox [name=coin_icon]').val(),
                            'coin_decimal' : $('#editbox [name=coin_decimal]').val(),
                            'coin_token_status' : $('#editbox [name=coin_token_status]:checked').val(),
                            'coin_token_address' : $('#editbox [name=coin_token_address]').val(),
                            'coin_recharge_status' : $('#editbox [name=coin_recharge_status]').val(),
                            'coin_recharge_min_amount' : $('#editbox [name=coin_recharge_min_amount]').val(),
                            'coin_recharge_static_address_status' : $('#editbox [name=coin_recharge_static_address_status]:checked').val(),
                            'coin_recharge_static_address' : $('#editbox [name=coin_recharge_static_address]').val(),
                            'coin_withdraw_status' : $('#editbox [name=coin_withdraw_status]').val(),
                            'coin_withdraw_amount' : $('#editbox [name=coin_withdraw_amount]').val(),
                            'coin_withdraw_fee' : $('#editbox [name=coin_withdraw_fee]').val(),
                            'coin_index' : $('#editbox [name=coin_index]').val(),
                            'coin_chain' : $('#editbox [name=coin_chain]').val(),
                            'coin_contract' : $('#editbox [name=coin_contract]').val(),
                            'coin_memo' : $('#editbox [name=coin_memo]').val(),
                            'coin_usd' : $('#editbox [name=coin_usd]').val(),
                            'coin_status' : $('#editbox [name=coin_status]').val()
                        };

                        if (coin.checkForm(data)) {

                            layuiLoadIndex = layer.load();

                            $.ajax({
                                url: '/manage/sys/coin/add',
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
                        
                        coin.formRender();
                    }
                });
            });


            //编辑币种
            $('.editbtn').click(function(){

                var _this = $(this);

                var _coinId = _this.attr('data-id');

                layuiLoadIndex = layer.load();

                //获取数据
                $.ajax({

                    url: '/manage/sys/coin/one',
                    type: 'post',
                    data: {

                        'coin_id' : _coinId
                    },
                    dataType: 'json',
                    success: function (data) {

                        if (data.status) {
                            
                            //更新表单

                            $('#editbox [name=coin_id]').val(data.coin.coin_id);
                            $('#editbox [name=coin_name]').val(data.coin.coin_name);
                            $('#editbox [name=coin_symbol]').val(data.coin.coin_symbol);
                            $('#editbox [name=coin_info]').val(data.coin.coin_info);
                            $('#editbox [name=coin_decimal]').val(data.coin.coin_decimal);
                            $('#editbox [name=coin_token_address]').val(data.coin.coin_token_address);
                            $('#editbox [name=coin_recharge_static_address]').val(data.coin.coin_recharge_static_address);
                            $('#editbox [name=coin_recharge_min_amount]').val(data.coin.coin_recharge_min_amount);
                            $('#editbox [name=coin_withdraw_amount]').val(data.coin.coin_withdraw_amount);
                            $('#editbox [name=coin_withdraw_fee]').val(data.coin.coin_withdraw_fee);
                            $('#editbox [name=coin_index]').val(data.coin.coin_index);
                            $('#editbox [name=coin_chain]').val(data.coin.coin_chain);
                            $('#editbox [name=coin_contract]').val(data.coin.coin_contract);
                            $('#editbox [name=coin_memo]').val(data.coin.coin_memo);
                            $('#editbox [name=coin_usd]').val(data.coin.coin_usd);
                            $('#editbox [name=coin_status]').val(data.coin.coin_status);

                            //swtich
                            if (data.coin.coin_recharge_status == '1') {

                                $('#editbox [name=coin_recharge_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=coin_recharge_status]').val(0).prop('checked', false);
                            }

                            if (data.coin.coin_withdraw_status == '1') {

                                $('#editbox [name=coin_withdraw_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=coin_withdraw_status]').val(0).prop('checked', false);
                            }

                            if (data.coin.coin_status == '1') {

                                $('#editbox [name=coin_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=coin_status]').val(0).prop('checked', false);
                            }

                            //image
                            if (data.coin.coin_icon != '') {

                                $('#editbox [name=coin_icon]').val(data.coin.coin_icon).siblings('img').attr('src', data.coin.coin_icon).show();
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

                                        'coin_id' : $('#editbox [name=coin_id]').val(),
                                        'coin_name' : $('#editbox [name=coin_name]').val(),
                                        'coin_symbol' : $('#editbox [name=coin_symbol]').val(),
                                        'coin_info' : $('#editbox [name=coin_info]').val(),
                                        'coin_icon' : $('#editbox [name=coin_icon]').val(),
                                        'coin_decimal' : $('#editbox [name=coin_decimal]').val(),
                                        'coin_token_status' : $('#editbox [name=coin_token_status]:checked').val(),
                                        'coin_token_address' : $('#editbox [name=coin_token_address]').val(),
                                        'coin_recharge_status' : $('#editbox [name=coin_recharge_status]').val(),
                                        'coin_recharge_min_amount' : $('#editbox [name=coin_recharge_min_amount]').val(),
                                        'coin_recharge_static_address_status' : $('#editbox [name=coin_recharge_static_address_status]:checked').val(),
                                        'coin_recharge_static_address' : $('#editbox [name=coin_recharge_static_address]').val(),
                                        'coin_withdraw_status' : $('#editbox [name=coin_withdraw_status]').val(),
                                        'coin_withdraw_amount' : $('#editbox [name=coin_withdraw_amount]').val(),
                                        'coin_withdraw_fee' : $('#editbox [name=coin_withdraw_fee]').val(),
                                        'coin_index' : $('#editbox [name=coin_index]').val(),
                                        'coin_chain' : $('#editbox [name=coin_chain]').val(),
                                        'coin_contract' : $('#editbox [name=coin_contract]').val(),
                                        'coin_memo' : $('#editbox [name=coin_memo]').val(),
                                        'coin_usd' : $('#editbox [name=coin_usd]').val(),
                                        'coin_status' : $('#editbox [name=coin_status]').val()
                                    };

                                    if (coin.checkForm(data)) {

                                        layuiLoadIndex = layer.load();

                                        $.ajax({
                                            url: '/manage/sys/coin/edit',
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
                                    
                                    coin.formRender();
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


            //删除币种
            $('.delbtn').click(function(){

                var _this = $(this);
                var _coinId = _this.attr('data-id');
                var _coinName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '数据删除将不可恢复！<br />确定删除币种：' + _coinName + ' ?',
                    {
                        title: _this.attr('data-title'),
                        icon: 0,
                        skin: 'my-layer-red'
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/sys/coin/delete',
                            type: 'post',
                            data: {
                                'coin_id' : _coinId
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

                    if (data.coin_symbol == '') {

                        layer.msg('请填写币种标识');
                        return false;
                    }

                    if (data.coin_icon == '') {

                        layer.msg('请上传币种图标');
                        return false;
                    }

                    if (data.coin_token_status == '1' && data.coin_token_address == '') {

                        layer.msg('请填写代币合约地址');
                        return false;
                    }

                    if (data.coin_recharge_static_address_status == '1' && data.coin_recharge_static_address == '') {

                        layer.msg('请填写静态充值地址');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    $('#editbox [name=coin_id]').val(0);
                    $('#editbox [name=coin_name]').val('');
                    $('#editbox [name=coin_symbol]').val('');
                    $('#editbox [name=coin_info]').val('');
                    $('#editbox [name=coin_icon]').val('').siblings('img').attr('src', '').hide();
                    $('#editbox [name=coin_decimal]').val(18);
                    $('#editbox [name=coin_token_status][value=0]').prop('checked', true);
                    $('#editbox [name=coin_token_address]').val('');
                    $('#editbox [name=coin_recharge_status]').val(1).prop('checked', true);
                    $('#editbox [name=coin_recharge_min_amount]').val(0.0001);
                    $('#editbox [name=coin_recharge_static_address_status][value=0]').prop('checked', true);
                    $('#editbox [name=coin_recharge_static_address]').val('');
                    $('#editbox [name=coin_withdraw_status]').val(1).prop('checked', true);
                    $('#editbox [name=coin_withdraw_amount]').val(0.0001);
                    $('#editbox [name=coin_withdraw_fee]').val(0.0001);
                    $('#editbox [name=coin_index]').val(0);
                    $('#editbox [name=coin_status]').val(1).prop('checked', true);

                    form.render();
                }
            }
        });
    </script>
</body>
</html>
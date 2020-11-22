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
            tbody .layui-form-switch{ margin-top: 0px; }
        </style>

        <div class="mainbox">
            
            <table class="layui-table" >
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col style="width: 400px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>用户名</th>
                        <th>手机</th>
                        <th>邮箱</th>
                        <th>登陆时间</th>
                        <th>登陆IP</th>
                        <th>操作</th>
                    </tr> 
                </thead>
                <tbody class="layui-form">

                    <?php if(count($userList)){ foreach($userList as $user){ ?>
                    <tr style="position: relative;">
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_phone']; ?></td>
                        <td><?php echo $user['user_email']; ?></td>
                        <td><?php echo $user['user_last_login'] > 0 ? date('Y-m-d H:i:s', $user['user_last_login']) : '-'; ?></td>
                        <td><?php echo $user['user_last_ip']; ?></td>
                        <td style="position: relative; width: 400px;">

                            <a class="layui-btn layui-btn-xs loginbtn" data-id="<?php echo $user['user_id']; ?>">前台登陆</a>

                            <a class="layui-btn layui-btn-xs sendbtn window_show" data-title="充值记录 - <?php echo $user['user_name']; ?>" data-href="/manage/user/user/user_recharge/<?php echo $user['user_id']; ?>">充值记录</a>
                            <a class="layui-btn layui-btn-xs sendbtn window_show" data-title="提现记录 - <?php echo $user['user_name']; ?>" data-href="/manage/user/user/user_withdraw/<?php echo $user['user_id']; ?>">提现记录</a>

                            <a class="layui-btn layui-btn-xs sendbtn window_show" data-title="资产详情 - <?php echo $user['user_name']; ?>" data-href="/manage/user/asset/user_asset/<?php echo $user['user_id']; ?>">资产详情</a>

                            <a class="layui-btn layui-btn-xs sendbtn window_show" data-title="合约订单 - <?php echo $user['user_name']; ?>" data-href="/manage/user/user/user_dm/<?php echo $user['user_id']; ?>">合约订单</a>

                            <?php if($user['user_auth'] == 3){ ?>
                            <a class="layui-btn layui-btn-xs showbtn" data-id="<?php echo $user['user_id']; ?>" data-email="<?php echo $user['user_email'] ?>" data-name="<?php echo $user['user_auth_name'] ?>" data-number="<?php echo $user['user_auth_number'] ?>" data-image-1="<?php echo json_decode($user['user_auth_image'], TRUE)[0] ?>" data-image-2="<?php echo json_decode($user['user_auth_image'], TRUE)[1] ?>">实名信息</a>
                            <?php }else{ ?>
                            <a class="layui-btn layui-btn-xs layui-btn-disabled disbtn noborder">暂未实名</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>

            <!-- 分页 -->
            <?php $this->load->view('agent/paging'); ?>
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

            //兼容layui的switch
            form.on('switch', function(data){

                if (data.elem.checked) {

                    $(data.elem).val(1).prop('checked', true);
                }else{

                    $(data.elem).val(0).prop('checked', false);
                }
            });


            $('.loginbtn').click(function(){

                var _this = $(this);

                layer.load();

                $.ajax({
                    url: '/manage/user/user/login',
                    type: 'post',
                    data: {
                        'user_id' : _this.attr('data-id')
                    },
                    success: function (data) {
                        
                        window.open('/account', 'target');
                    },
                    complete: function(){

                        layer.closeAll();
                    }
                });
            });


            $('.window_show').click(function(){

                var _this = $(this);

                layuiOpenIndex = layer.open({

                    title: _this.attr('data-title'),
                    type: 2,
                    content : _this.attr('data-href'),
                    icon: 0,
                    maxmin: true,
                    area: ['100%', '100%'],
                    skin: 'my-layer-green',
                    btn: ['关闭'],
                    success : function(_dom, _index){

                        layer.full(_index);
                    }
                });

                return false;
            });

            //查看
            $('.showbtn').click(function(){

                var _this = $(this);

                layuiOpenIndex = layer.open({

                    title: '查看实名信息',
                    type: 1,
                    content : 
                        '<div style="width: 500px; padding: 30px; margin: 0 autu;">' +
                            '邮箱<br />' + 
                            _this.attr('data-email') + '<br /><br />' +
                            '姓名<br />' + 
                            _this.attr('data-name') + '<br /><br />' +
                            '身份证<br />' + 
                            _this.attr('data-number') + '<br /><br />' +
                            '图片1<br />' + 
                            '<img class="auth_image" style="width: 500px; border: #CCC solid 1px; cursor: pointer;" src="' + _this.attr('data-image-1') + '" /><br /><br />' +
                            '图片2<br />' + 
                            '<img class="auth_image" style="width: 500px; border: #CCC solid 1px; cursor: pointer;" src="' + _this.attr('data-image-2') + '" /><br /><br />' +
                        '</div>',
                    icon: 0,
                    skin: 'my-layer-green',
                    area: ['100%', '100%'],
                    btn: ['关闭'],
                    success : function(_dom, _index){

                        layer.full(_index);
                    }
                });

                //预览上传的图片
                $(document).on('click', '.auth_image', function(){

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

                return false;
            });
        });
    </script>
</body>
</html>
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
            用户管理 > 实名审核
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
        </style>

        <div class="mainbox">

            <style type="text/css">
                .search_box{ margin-bottom: 20px; }
                .search_box .search_value{ width: 300px; float: left; }
                .search_box .search_btn, .search_box .clear_search_btn{ float: left; margin-left: 10px; }
            </style>
            <div class="search_box layui-form">
                <input type="text" id="search_value" placeholder="搜索用户名、手机、邮箱" autocomplete="off" class="layui-input search_value" value="<?php echo $search; ?>">
                <button type="button" class="layui-btn search_btn" id="search_btn" data-url="/manage/user/auth">搜索用户</button>
                <a class="layui-btn layui-btn-normal clear_search_btn" href="/manage/user/auth">清空</a>
                <div class="clear"></div>
            </div>
            
            <table class="layui-table" >
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col style="width: 195px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>用户名</th>
                        <th>姓名</th>
                        <th>身份证</th>
                        <th>提交时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php if(count($authList)){ foreach($authList as $user){ ?>
                    <tr style="position: relative;">
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_auth_name']; ?></td>
                        <td><?php echo $user['user_auth_number']; ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $user['user_auth_time']); ?></td>
                        <td>
                            <a class="layui-btn <?php echo $user['user_auth'] == 1 ? 'layui-btn-warm' : ($user['user_auth'] == 2 ? 'layui-btn-danger' : ''); ?> layui-btn-xs"><?php echo $user['user_auth'] == 1 ? '待审核' : ($user['user_auth'] == 2 ? '未通过' : '已通过'); ?></a>     
                        </td>
                        <td style="position: relative; width: 195px;">

                            <button class="layui-btn layui-btn-normal layui-btn-xs showbtn" data-id="<?php echo $user['user_id']; ?>" data-email="<?php echo $user['user_email'] ?>" data-name="<?php echo $user['user_auth_name'] ?>" data-number="<?php echo $user['user_auth_number'] ?>" data-image-1="<?php echo json_decode($user['user_auth_image'], TRUE)[0] ?>" data-image-2="<?php echo json_decode($user['user_auth_image'], TRUE)[1] ?>">查看信息</button>

                            <?php if($user['user_auth'] == 1){ ?>
                            
                            <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" data-id="<?php echo $user['user_id']; ?>" data-email="<?php echo $user['user_email'] ?>" data-name="<?php echo $user['user_auth_name'] ?>" data-number="<?php echo $user['user_auth_number'] ?>">拒绝通过</button>
                            <button class="layui-btn layui-btn-xs editbtn" data-id="<?php echo $user['user_id']; ?>" data-email="<?php echo $user['user_email'] ?>" data-name="<?php echo $user['user_auth_name'] ?>" data-number="<?php echo $user['user_auth_number'] ?>">通过审核</button>
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
                var _userId = _this.attr('data-id');

                layuiOpenIndex = layer.confirm(

                    '通过申请将不可更改!<br /><br />' + 
                    '邮箱：' + _this.attr('data-email') + '<br />' + 
                    '姓名：' + _this.attr('data-name') + '<br />' + 
                    '身份证：' + _this.attr('data-number') + '<br /><br />' + 
                    '请确认已审核信息',
                    {
                        title: '通过实名申请',
                        icon: 0,
                        area: '500px',
                        skin: 'my-layer-green',
                        btn: ['已验证过信息，通过', '取消']
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/user/auth/edit',
                            type: 'post',
                            data: {
                                'user_id' : _userId,
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

            //通过申请
            $('.delbtn').click(function(){

                var _this = $(this);
                var _userId = _this.attr('data-id');

                layuiOpenIndex = layer.confirm(

                    '拒绝申请将不可更改!<br /><br />' + 
                    '邮箱：' + _this.attr('data-email') + '<br />' + 
                    '姓名：' + _this.attr('data-name') + '<br />' + 
                    '身份证：' + _this.attr('data-number') + '<br /><br />' + 
                    '请确认是否拒绝',
                    {
                        title: '拒绝实名申请',
                        icon: 0,
                        area: '500px',
                        skin: 'my-layer-green',
                        btn: ['拒绝','取消']
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/user/auth/edit',
                            type: 'post',
                            data: {
                                'user_id' : _userId,
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
                    maxmin: true,
                    area: ['100%', '100%'],
                    skin: 'my-layer-green',
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
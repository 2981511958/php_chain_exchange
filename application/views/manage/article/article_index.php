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
        
        <div class="pagetitle layui-bg-black">
            <button class="layui-btn addbtn" id="addbtn" data-title="添加<?php echo $this->config->item('article_type')[$article_type]; ?>">添加<?php echo $this->config->item('article_type')[$article_type]; ?></button>
            <?php echo $this->config->item('article_type')[$article_type]; ?>管理 > <?php echo $this->config->item('article_type')[$article_type]; ?>列表
        </div>

        <style type="text/css">
            
            .myuploadbox{ width: 300px; }
            .imgpreview{ height: 36px; margin-left: 10px; position: relative; display: none; border: rgb(230, 230, 230) solid 1px; cursor: pointer; }
            .layui-table .imgpreview{ height: 30px; }
        </style>

        <div class="mainbox">

            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <?php if($langList && count($langList)){ foreach($langList as $langSymbol => $langText){ ?>
                    <li class="<?php echo $lang == $langSymbol ? 'layui-this' : ''; ?>" data-link="/manage/article/article/index/<?php echo $article_type; ?>/<?php echo $langSymbol; ?>"><?php echo $langText; ?></li>
                    <?php }} ?>
                </ul>
                <div class="layui-tab-content">
                    <?php if($langList && count($langList)){ foreach($langList as $langSymbol => $langText){ if($lang == $langSymbol){ ?>
                    <div class="layui-tab-item <?php echo $lang == $langSymbol ? 'layui-show' : ''; ?>">
                        <table class="layui-table" >
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <?php if($article_type == 0){ ?>
                                    <col>
                                <?php } ?>
                                <col>
                                <col>
                                <col style="width: 130px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <?php if($article_type == 0){ ?>
                                        <th>滚动图片</th>
                                        <th>平台</th>
                                    <?php }else{ ?>
                                        <th>文章标题</th>
                                    <?php } ?>
                                    <th>语言</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr> 
                            </thead>
                            <tbody>

                                <?php if(count($articleList)){ foreach($articleList as $article){ ?>
                                <tr style="position: relative;">
                                    <?php if($article_type == 0){ ?>
                                        <td><img class="imgpreview" src="<?php echo $article['article_content']; ?>" style="display: inline; margin: -20px 0px;"></td>
                                        <td><?php echo $article['article_plate'] == 0 ? 'PC' : 'Mobile'; ?></td>
                                    <?php }else{ ?>
                                        <td><?php echo $article['article_title']; ?></td>
                                    <?php } ?>
                                    <td><?php echo isset($langList[$article['article_lang']]) ? $langList[$article['article_lang']] : ''; ?></td>
                                    <td>
                                        <a class="layui-btn <?php echo $article['article_status'] == '1' ? '' : 'layui-btn-danger'; ?> layui-btn-xs"><?php echo $article['article_status'] == '1' ? '正常' : '封禁'; ?></a>
                                    </td>
                                    <td style="position: relative; width: 130px;">
                                        <button class="layui-btn layui-btn-danger layui-btn-xs delbtn" data-title="删除文章" data-id="<?php echo $article['article_id']; ?>">删除文章</button>
                                        <button class="layui-btn layui-btn-warm layui-btn-xs editbtn" data-id="<?php echo $article['article_id']; ?>" data-title="编辑文章">编辑文章</button>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                    <?php }}} ?>

                    <!-- 分页 -->
                    <?php $this->load->view('manage/paging'); ?>
                </div>
            </div>

            
        </div>

        <!-- 编辑框 -->
        <div class="editbox displaynone" id="editbox">
            
            <div class="layui-form layui-form-pane">

                <input type="hidden" name="article_id" value="0">
                <input type="hidden" name="article_type" value="<?php echo $article_type; ?>">

                <div class="layui-form-item">
                    <label class="layui-form-label">文章标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="article_title" placeholder="请输入文章标题" class="layui-input">
                    </div>
                </div>

                <?php if($article_type == 0){ ?>
                    <div class="layui-form-item">
                        <label class="layui-form-label">滚动图片</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="article_content">
                            <button type="button" class="layui-btn upload" style="margin-left: 10px;">
                                <i class="layui-icon">&#xe67c;</i>上传滚动图片
                            </button>
                            <img src="" class="imgpreview pointer" />
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">平台</label>
                        <div class="layui-input-block">
                            <select name="article_plate" lay-filter="add_ac_c">
                                <option value="0">PC</option>
                                <option value="1">Mobile</option>
                            </select>
                        </div>
                    </div>
                <?php }else{ ?>
                    <input type="hidden" name="article_plate" value="0">

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">文章内容</label>
                        <div class="layui-input-block">
                            <!-- 加载编辑器的容器 -->
                            <script id="article_content" name="article_content" type="text/plain"></script>
                        </div>
                    </div>
                <?php } ?>

                <div class="layui-form-item">
                    <label class="layui-form-label">语言</label>
                    <div class="layui-input-block">
                        <select name="article_lang" lay-filter="add_ac_c">
                            <option value="">请选择语言</option>
                            <?php if($langList && count($langList)){ foreach ( $langList as $langSymbol => $langText) { ?>
                                <option value="<?php  echo $langSymbol; ?>"><?php echo $langText; ?></option>
                            <?php }}; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item" pane>
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="article_status" lay-skin="switch" checked lay-text="正常|禁用" value="1">
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

            <?php if($article_type <> 0){ ?>
            var ueWidth = $('#article_content').parent().width() - 2;
            var article_content = UE.getEditor('article_content',{initialFrameWidth: ueWidth});
            <?php } ?>

            $('.layui-tab li').click(function(){

                window.location.href = $(this).attr('data-link');

                return false;
            });

            //兼容layui的select的change事件
            form.on('select', function(data){

                $(data.elem).trigger('change');

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
                    area: ['100%', '100%'],
                    btnAlign: 'c',
                    btn: ['提交', '取消'],
                    maxmin: true,
                    zIndex: 99,
                    success: function(){

                    },
                    yes: function(){

                        var data = {

                            'article_type' : $('#editbox [name=article_type]').val(),
                            'article_title' : $('#editbox [name=article_title]').val(),
                            'article_lang' : $('#editbox [name=article_lang]').val(),
                            'article_plate' : $('#editbox [name=article_plate]').val(),

                            <?php if($article_type == 0){ ?>
                                'article_content' : $('#editbox [name=article_content]').val(),
                            <?php }else{ ?>
                                'article_content' : article_content.getContent(),
                            <?php } ?>

                            'article_status' : $('#editbox [name=article_status]').val()
                        };

                        if (article.checkForm(data)) {

                            layuiLoadIndex = layer.load();

                            $.ajax({
                                url: '/manage/article/article/add',
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
                        
                        article.formRender();
                    }
                });
            });


            //编辑
            $('.editbtn').click(function(){

                var _this = $(this);

                var _articleId = _this.attr('data-id');

                layuiLoadIndex = layer.load();

                //获取数据
                $.ajax({

                    url: '/manage/article/article/one',
                    type: 'post',
                    data: {

                        'article_id' : _articleId
                    },
                    dataType: 'json',
                    success: function (data) {

                        if (data.status) {
                            
                            //更新表单

                            $('#editbox [name=article_id]').val(data.article.article_id);
                            $('#editbox [name=article_type]').val(data.article.article_type);
                            $('#editbox [name=article_title]').val(data.article.article_title);
                            $('#editbox [name=article_lang]').val(data.article.article_lang);
                            $('#editbox [name=article_plate]').val(data.article.article_plate);
                            // $('#editbox [name=article_content]').val(data.article.article_content);

                            <?php if($article_type == 0){ ?>
                                //image
                                if (data.article.article_content != '') {

                                    $('#editbox [name=article_content]').val(data.article.article_content).siblings('img').attr('src', data.article.article_content).show();
                                }
                            <?php }else{ ?>
                                setTimeout(function () {
                                   article_content.setContent(data.article.article_content);
                                },666);
                            <?php } ?>

                            

                            $('#editbox [name=article_status]').val(data.article.article_status);

                            //swtich
                            if (data.article.article_status == '1') {

                                $('#editbox [name=article_status]').val(1).prop('checked', true);
                            }else{

                                $('#editbox [name=article_status]').val(0).prop('checked', false);
                            }

                            form.render();
                            layer.close(layuiLoadIndex);

                            layuiOpenIndex = layer.open({

                                title: _this.attr('data-title'),
                                type: 1,
                                content: $('#editbox'),
                                skin: 'my-layer-yellow',
                                area: ['100%', '100%'],
                                maxHeight: '500px',
                                btnAlign: 'c',
                                btn: ['提交', '取消'],
                                maxmin: true,
                                zIndex: 99,
                                success: function(){

                                },
                                yes: function(){

                                    var data = {

                                        'article_id' : $('#editbox [name=article_id]').val(),
                                        'article_type' : $('#editbox [name=article_type]').val(),
                                        'article_title' : $('#editbox [name=article_title]').val(),
                                        'article_lang' : $('#editbox [name=article_lang]').val(),
                                        'article_plate' : $('#editbox [name=article_plate]').val(),
                                        
                                        <?php if($article_type == 0){ ?>
                                            'article_content' : $('#editbox [name=article_content]').val(),
                                        <?php }else{ ?>
                                            'article_content' : article_content.getContent(),
                                        <?php } ?>

                                        'article_status' : $('#editbox [name=article_status]').val()
                                    };

                                    if (article.checkForm(data)) {

                                        layuiLoadIndex = layer.load();

                                        $.ajax({
                                            url: '/manage/article/article/edit',
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
                                    
                                    article.formRender();
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


            //删除
            $('.delbtn').click(function(){

                var _this = $(this);
                var _articleId = _this.attr('data-id');
                var _articleName = _this.attr('data-text');

                layuiOpenIndex = layer.confirm(

                    '数据删除将不可恢复！<br />确定删除 ?',
                    {
                        title: _this.attr('data-title'),
                        icon: 0,
                        skin: 'my-layer-red'
                    },
                    function(index){

                        layer.close(index);
                        layuiLoadIndex = layer.load();

                        $.ajax({
                            url: '/manage/article/article/delete',
                            type: 'post',
                            data: {
                                'article_id' : _articleId
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

            var article = {

                checkForm: function(data){

                    if (data.article_title == '') {

                        layer.msg('请输入标题');
                        return false;
                    }

                    if (data.article_content == '') {

                        layer.msg('请输入内容');
                        return false;
                    }

                    if (data.article_lang == '') {

                        layer.msg('请选择语言');
                        return false;
                    }

                    return true;
                },

                formRender: function(){

                    location.reload();
                }
            }
        });
    </script>
</body>
</html>
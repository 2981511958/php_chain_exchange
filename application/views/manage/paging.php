<!-- 后台通用分页-->
<!-- 加载之前请确认有分页信息变量 -->
<!-- 加载之前请确认引入了layui类库 -->
<div class="paging layui-form">
    <div class="layui-inline">
        <?php if($pagingInfo['pageindex']==1){?>
            <button class="layui-btn layui-btn-sm layui-btn-disabled">首页</button>
            <button class="layui-btn layui-btn-sm layui-btn-disabled">上一页</button>
        <?php }else{?>
            <a class="layui-btn layui-btn-sm" href="<?php echo $pagingInfo['action']; ?>1.html<?php echo isset($search) ? ('?search=' . $search) : ''; ?>">首页</a>
            <a class="layui-btn layui-btn-sm" href="<?php echo $pagingInfo['action'] . ($pagingInfo['pageindex'] - 1); ?>.html<?php echo isset($search) ? ('?search=' . $search) : ''; ?>">上一页</a>
        <?php }?>
        <?php if($pagingInfo['left']){ echo '...'; } ?>
        <?php for($i=$pagingInfo['pageindexstart'];$i<=$pagingInfo['pageindexend'];$i++){
            if($i == $pagingInfo['pageindex'])
                echo "<button class='layui-btn layui-btn-sm layui-btn-disabled'>" . $i . "</button>";
            else 
                echo "<a class='layui-btn layui-btn-sm' href='" . $pagingInfo['action'] . $i . ".html" . (isset($search) ? ('?search=' . $search) : '') . "'>" . $i . "</a>";
        }?>
        <?php if($pagingInfo['right']){ echo '...'; } ?>
        <?php if($pagingInfo['pageindex']==$pagingInfo['pagesum']){?>
            <button class="layui-btn layui-btn-sm layui-btn-disabled">下一页</button>
            <button class="layui-btn layui-btn-sm layui-btn-disabled">末页</button>
        <?php }else{?>
            <a class="layui-btn layui-btn-sm" href="<?php echo $pagingInfo['action'] . ($pagingInfo['pageindex'] + 1); ?>.html<?php echo isset($search) ? ('?search=' . $search) : ''; ?>">下一页</a>
            <a class="layui-btn layui-btn-sm" href="<?php echo $pagingInfo['action'] . $pagingInfo['pagesum']; ?>.html<?php echo isset($search) ? ('?search=' . $search) : ''; ?>">末页</a>
        <?php }?><br />
    </div>
    <div class="layui-inline">
        <select lay-filter="paging" url="<?php echo $pagingInfo['action']; ?>" class="page_select">
            <?php for($i = 1; $i <= $pagingInfo['pagesum']; $i ++){ ?>
            <option value="<?php echo $i; ?>.html<?php echo (isset($search) ? ('?search=' . $search) : ''); ?>" <?php echo ($i==$pagingInfo['pageindex']) ? "selected='selected'" : '' ?>><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<script type="text/javascript">
    layui.use(['element', 'jquery', 'form'], function () {

        var pagingElement = layui.element;
        var pagingForm    = layui.form;
        var $             = layui.$;

        pagingForm.on('select(paging)', function(data){

            var pagingUrl = $(data.elem).attr('url') + data.value;
            window.location.href = pagingUrl;
        });
    });
</script>
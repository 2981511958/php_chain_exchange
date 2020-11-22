<!-- 通用分页-->
<!-- 加载之前请确认有分页信息变量 -->

<style type="text/css">
    .paging{ text-align: center; }
    .paging .layui-btn-normal{ background-color: #357ce1; }
    .paging .layui-btn-disabled{ background: none; border-color: #697080; color: #697080; }
    .paging .layui-btn+.layui-btn{ margin-left: 5px; }
</style>

<div class="paging layui-form">
    <div class="layui-inline">
        <?php if($pagingInfo['pageindex']==1){?>
            <a class="layui-btn layui-btn-normal layui-btn-sm layui-btn-disabled"><?php echo lang('view_paging_2'); ?></a>
        <?php }else{?>
            <a class="layui-btn layui-btn-normal layui-btn-sm" href="<?php echo $pagingInfo['action'] . ($pagingInfo['pageindex'] - 1); ?>.html"><?php echo lang('view_paging_4'); ?></a>
        <?php }?>
        <?php for($i=$pagingInfo['pageindexstart'];$i<=$pagingInfo['pageindexend'];$i++){
            if($i == $pagingInfo['pageindex'])
                echo "<a class='layui-btn layui-btn-normal layui-btn-sm layui-btn-disabled'>" . $i . "</a>";
        }?>
        <?php if($pagingInfo['pageindex']==$pagingInfo['pagesum']){?>
            <a class="layui-btn layui-btn-normal layui-btn-sm layui-btn-disabled"><?php echo lang('view_paging_5'); ?></a>
        <?php }else{?>
            <a class="layui-btn layui-btn-normal layui-btn-sm" href="<?php echo $pagingInfo['action'] . ($pagingInfo['pageindex'] + 1); ?>.html"><?php echo lang('view_paging_7'); ?></a>
        <?php }?><br />
    </div>
</div>
/**
 * layer扩展
 */

//layer最大高度
layer.maxHeight = 600;

//重新设置位置和大小
layer.refresh_height_top = function(layerIndex){

	var _this = this;

	//获取屏幕高度，用于计算top
	var clientHeight = $(window).height();

	//获取相关dom以及高度
	var _layer_dom = $('#layui-layer' + layerIndex);
	var _layer_dom_content = _layer_dom.children('.layui-layer-content');
	var _layer_dom_content_height = _layer_dom_content.children().height();

	//计算高度和top
	_layer_dom_content.height((_layer_dom_content_height + 99) >= _this.maxHeight ? _this.maxHeight - 99 : _layer_dom_content_height + 11);
	_layer_dom.css({'top' : (clientHeight - _layer_dom_content.height() - 99) / 2 + 'px'});
};

//layer弹出框等待异步执行结果或等待异步事件执行结束的时候，将下方的按钮暂时隐藏，显示loading
layer.wait = function(layerIndex){

	var _this = this;

	//获取弹出框dom
	var _layer_dom = $('#layui-layer' + layerIndex);

	//隐藏按钮，写入loading图片元素
	_layer_dom.find('.layui-layer-btn a').addClass('wait');
	_layer_dom.find('.layui-layer-btn a:last').after('<img class="layer-wait" src="images/loading.gif" style="margin-top: 7px;">');
}

//layer弹出框清除loading
layer.clear_wait = function(layerIndex){

	var _this = this;

	//获取弹出框dom
	var _layer_dom = $('#layui-layer' + layerIndex);

	//删除loading图片元素，显示按钮
	_layer_dom.find('.layui-layer-btn .layer-wait').remove();
	_layer_dom.find('.layui-layer-btn a').removeClass('wait');
}

//layer通用配置
layer.config({

    type: 1,
    btnAlign: 'c',
    closeBtn: 0,
    zIndex: 10,
    maxHeight: layer.maxHeight,
    resize: true
});

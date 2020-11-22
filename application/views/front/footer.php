<style type="text/css">
	
	/*footer*/
	footer{ background: #191a1f; padding: 50px 0px; }
	footer .center_box{ width: 1200px; margin: 0 auto; }
	footer .center_box .left_box{ float: left; width: 380px; }
	footer .center_box .left_box .footer_logo{ display: block; height: 50px; margin-bottom: 20px; }
	footer .center_box .left_box .footer_copyright_info{ line-height: 20px; font-size: 14px; color: #6a707f; }
	footer .center_box .right_box{ float: right; width: 800px; }
	footer .center_box .right_box .footer_link_list{ float: right; width: 200px; }
	footer .center_box .right_box .footer_link_list .list_title{ color: #FFF; font-size: 18px; padding-bottom: 10px; text-align: left; }
	footer .center_box .right_box .footer_link_list .link_item{ display: block; font-size: 14px; color: #d5def2; text-align: left; line-height: 30px; }
	footer .center_box .right_box .footer_link_list .link_item:hover{ color: #357ce1; cursor: pointer; }

	.notyf{ padding-top: 70px !important; }
</style>

<?php

	$startList = $this->article_model->listActiveArticleByType(1, 100, 2, $_SESSION['_language']);
	$supportList = $this->article_model->listActiveArticleByType(1, 100, 3, $_SESSION['_language']);
	$serviceList =$this->article_model->listActiveArticleByType(1, 100, 4, $_SESSION['_language']);
	$toolList = $this->article_model->listActiveArticleByType(1, 100, 5, $_SESSION['_language']);
?>

<footer>
	<div class="center_box">
		<div class="right_box">
			<div class="footer_link_list">
				<div class="list_title"><?php echo lang('view_footer_1'); ?></div>
				<?php if($toolList && count($toolList)){ foreach($toolList as $articleItem){ ?>
				<a class="link_item"><?php echo $articleItem['article_title']; ?></a>
				<?php }} ?>
			</div>
			<div class="footer_link_list">
				<div class="list_title"><?php echo lang('view_footer_2'); ?></div>
				<?php if($serviceList && count($serviceList)){ foreach($serviceList as $articleItem){ ?>
				<a class="link_item" href="/article/detail/<?php echo $articleItem['article_token']; ?>"><?php echo $articleItem['article_title']; ?></a>
				<?php }} ?>
			</div>
			<div class="footer_link_list">
				<div class="list_title"><?php echo lang('view_footer_3'); ?></div>
				<?php if($supportList && count($supportList)){ foreach($supportList as $articleItem){ ?>
				<a class="link_item" href="/article/detail/<?php echo $articleItem['article_token']; ?>"><?php echo $articleItem['article_title']; ?></a>
				<?php }} ?>
			</div>
			<div class="footer_link_list">
				<div class="list_title"><?php echo lang('view_footer_4'); ?></div>
				<?php if($startList && count($startList)){ foreach($startList as $articleItem){ ?>
				<a class="link_item" href="/article/detail/<?php echo $articleItem['article_token']; ?>"><?php echo $articleItem['article_title']; ?></a>
				<?php }} ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="left_box">
			<img class="footer_logo" src="<?php echo $_SESSION['SYSCONFIG']['sysconfig_site_logo']; ?>">
			<div class="footer_copyright_info"><?php echo lang('view_footer_5'); ?> <?php echo $_SESSION['SYSCONFIG']['sysconfig_site_name']; ?></div>
			<div class="footer_copyright_info"><?php echo lang('view_footer_6'); ?></div>
		</div>
		<div class="clear"></div>
	</div>
</footer>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('static'); ?>/notyf/notyf.min.css" />

<script src="<?php echo base_url('static/front'); ?>/js/jquery-1.8.0.min.js" ></script>
<script src="<?php echo base_url('static'); ?>/notyf/notyf.min.js"></script>
<script src="<?php echo base_url('static/front'); ?>/js/common.js" ></script>

<script type="text/javascript">

	$('header .right_box .nav_right_box .nav_item.language .language_box .language_item').click(function(){

		var _this = $(this);

		$.ajax({
			url: '/common/change_language',
			type: 'post',
			data: {

				'_language' : _this.attr('data-lang')
			},
			success: function (data) {
				
				location.reload();
			}
		});
	});

	$('.input_ele_box .input_ele_label').click(function(){

		$(this).siblings('.input_ele').focus();
	});
</script>

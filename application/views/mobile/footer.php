<style type="text/css">
	footer{ position: fixed; bottom: 0px; left: 0px; width: 100%; height: 49px; box-shadow: 0px 6px 20px 0px rgba(0,0,0,0.3); border-top: #34363f solid 1px; background: #191a1f; z-index: 9; }
	footer .navitem{ float: left; width: 20%; }
	footer .navitem .navicon{ width: 20px; height: 20px; margin: 7px auto 1px auto; background-position: center; background-size: cover; }
	footer .navitem .navtext{ font-size: 12px; text-align: center; padding-bottom: 2px; color: #697080; font-weight: bold; }
	footer .navitem.home .navicon{ background-image: url('/static/mobile/images/index0.png'); }
	footer .navitem.home.active .navicon{ background-image: url('/static/mobile/images/index1.png'); }
	footer .navitem.exchange .navicon{ background-image: url('/static/mobile/images/hang0.png'); }
	footer .navitem.exchange.active .navicon{ background-image: url('/static/mobile/images/hang1.png'); }
	footer .navitem.futures .navicon{ background-image: url('/static/mobile/images/gang0.png'); }
	footer .navitem.futures.active .navicon{ background-image: url('/static/mobile/images/gang1.png'); }
	footer .navitem.asset .navicon{ background-image: url('/static/mobile/images/mine0.png'); }
	footer .navitem.asset.active .navicon{ background-image: url('/static/mobile/images/mine1.png'); }
	footer .navitem.account .navicon{ background-image: url('/static/mobile/images/account0.png'); }
	footer .navitem.account.active .navicon{ background-image: url('/static/mobile/images/account1.png'); }
	footer .navitem.active .navtext{ color: #357ce1; }
	.footer_holder{ height: 50px; }
</style>

<footer>
	<a class="navitem home " href="/">
		<div class="navicon"></div>
		<div class="navtext"><?php echo lang('view_mobile_footer_1'); ?></div>
	</a>
	<a class="navitem exchange " href="/exchange">
		<div class="navicon"></div>
		<div class="navtext"><?php echo lang('view_mobile_footer_2'); ?></div>
	</a>
	<a class="navitem futures " href="/futures">
		<div class="navicon"></div>
		<div class="navtext"><?php echo lang('view_mobile_footer_3'); ?></div>
	</a>
	<a class="navitem asset " href="/account/asset">
		<div class="navicon"></div>
		<div class="navtext"><?php echo lang('view_mobile_footer_4'); ?></div>
	</a>
	<a class="navitem account " href="/account">
		<div class="navicon"></div>
		<div class="navtext"><?php echo lang('view_mobile_footer_5'); ?></div>
	</a>
	<div class="clear"></div>
</footer>
<div class="footer_holder"></div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('static'); ?>/notyf/notyf.min.css" />

<script src="<?php echo base_url('static/mobile'); ?>/js/jquery-1.8.0.min.js" ></script>
<script src="<?php echo base_url('static'); ?>/notyf/notyf.min.js"></script>
<script src="<?php echo base_url('static/mobile'); ?>/js/common.js" ></script>

<script type="text/javascript">

	

	$('.input_ele_box .input_ele_label').click(function(){

		$(this).siblings('.input_ele').focus();
	});
</script>

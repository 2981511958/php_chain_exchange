<!-- 针对安卓平台 -->
<?php if($this->android){ ?>
<style type="text/css">
	.screen_status_bar{ height: 25px; background: #191a1f; position: fixed; left: 0px; top: 0px; width: 100%; z-index: 999999; }
	.screen_status_bar_bold{ height: 25px; }
	.notyf{ margin-top: 25px !important; }
</style>

<div class="screen_status_bar"></div>
<div class="screen_status_bar_bold"></div>
<?php } ?>
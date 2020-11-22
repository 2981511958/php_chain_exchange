<style type="text/css">
    .account_box .left_box .account_menu{ padding: 10px; background: #191a1f; }
    .account_box .left_box .account_menu .account_menu_item{ display: block; line-height: 40px; text-align: center; font-size: 14px; }
    .account_box .left_box .account_menu .account_menu_item.active{ background: #357ce1; color: #FFF; }
    .account_box .left_box .account_menu .account_menu_item:hover{ color: #FFF; }

    .account_box .left_box .account_menu_logout{ margin-top: 10px; }
    .account_box .left_box .account_menu_logout .account_menu_item:hover{ background: #e04545; }
</style>

<div class="account_menu">
    <a class="account_menu_item account" href="/account"><?php echo lang('view_account_menu_1'); ?></a>
    <a class="account_menu_item phone" href="/account/phone"><?php echo lang('view_account_menu_2'); ?></a>
    <a class="account_menu_item email" href="/account/email"><?php echo lang('view_account_menu_3'); ?></a>
    <a class="account_menu_item auth" href="/account/auth"><?php echo lang('view_account_menu_4'); ?></a>
    <a class="account_menu_item repass" href="/account/repass"><?php echo lang('view_account_menu_5'); ?></a>
    <a class="account_menu_item reexpass" href="/account/reexpass"><?php echo lang('view_account_menu_6'); ?></a>

    <?php if($user['user_agent'] == 1){ ?>
    <a class="account_menu_item invite" href="/account/invite"><?php echo lang('view_account_menu_7'); ?></a>
    <?php } ?>
</div>

<div class="account_menu account_menu_logout">
    <a class="account_menu_item" href="/account/logout"><?php echo lang('view_account_menu_8'); ?></a>
</div>
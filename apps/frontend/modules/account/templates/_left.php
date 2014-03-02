<?php if ( $form == "simple" ): ?>
<div id="blockChoiceAccount">
<?php echo image_tag('account/create/leftRegisterSimple1_' . strtolower($sf_user->getCulture()) . '.png', array('alt' => '', 'border' => '0', 'size' => '279x27')); ?>

	<a
		href="<?php echo url_for(array('module'=>'account', 'action'=>'register')) ?>">
		<?php echo image_tag('account/create/leftRegisterSimple2_' . strtolower($sf_user->getCulture()) . '.png', array('title' => __('Compte de jeu simple'), 'border' => '0', 'size' => '279x75')); ?>
	</a> <a
		href="<?php echo url_for(array('module'=>'account', 'action'=>'registerAdvanced')) ?>">
		<?php echo image_tag('account/create/leftRegisterSimple3_' . strtolower($sf_user->getCulture()) . '.png', array('title' => __('Compte de jeu complet'), 'border' => '0', 'size' => '279x76')); ?>
	</a>

	<?php echo image_tag('account/create/leftRegisterSimple4_' . strtolower($sf_user->getCulture()) . '.png', array('alt' => '', 'border' => '0', 'size' => '279x343')); ?>
</div>
<script>
$(function(){
	$(window).scroll(function(){
		if($(window).scrollTop() <= '430' && $(window).scrollTop() >= '200'){ 
			$('#blockChoiceAccount').animate({top:($(window).scrollTop()-200)+"px" },{queue: false, duration: 350});
		}
		if ($(window).scrollTop() == '0') {
			$('#blockChoiceAccount').animate({top:($(window).scrollTop())+"px" },{queue: false, duration: 350});
		}
	});
});
</script>
	<?php else: ?>
<div id="blockChoiceAccount">
	<?php echo image_tag('account/create/leftRegisterAdvanced1_' . strtolower($sf_user->getCulture()) . '.png', array('alt' => '', 'border' => '0', 'size' => '279x27')); ?>

	<a href="<?php echo url_for(array('module' => 'account', 'action' => 'register')) ?>">
		<?php echo image_tag('account/create/leftRegisterAdvanced2_' . strtolower($sf_user->getCulture()) . '.png', array('title' => __('Compte de jeu simple'), 'border' => '0', 'size' => '279x75')); ?>
	</a> 
	<a href="<?php echo url_for(array('module' => 'account', 'action' => 'registerAdvanced')) ?>">
		<?php echo image_tag('account/create/leftRegisterAdvanced3_' . strtolower($sf_user->getCulture()) . '.png', array('title' => __('Compte de jeu complet'), 'border' => '0', 'size' => '279x75')); ?>
	</a>

	<?php echo image_tag('account/create/leftRegisterAdvanced4_' . strtolower($sf_user->getCulture()) . '.png', array('alt' => '', 'border' => '0', 'size' => '279x343')); ?>
</div>
<script>
$(function(){
	$(window).scroll(function(){
		if($(window).scrollTop() <= '1230' && $(window).scrollTop() >= '150'){ 
			$('#blockChoiceAccount').animate({top:($(window).scrollTop()-150)+"px" },{queue: false, duration: 350});
		}
		if ($(window).scrollTop() == '0') {
			$('#blockChoiceAccount').animate({top:($(window).scrollTop())+"px" },{queue: false, duration: 350});
		}
	});
});
</script>
	<?php endif ?>
<style>
#blockChoiceAccount {
position: relative;
}
</style>
<?php if (sfConfig::get('app_profile') == 'free') { ?>
<script type="text/javascript">
$(function() {
	$('a[href="<?php echo url_for(array('module'=>'account', 'action'=>'registerAdvanced')) ?>"]').attr('title','<?php echo addslashes(__('a_title_real_money_bets_unavailable_text'))?>');
	$('a[href="<?php echo url_for(array('module'=>'account', 'action'=>'registerAdvanced')) ?>"]').tipsy({fade: true,gravity: 'n'}).attr("href","#");
});
</script>
<?php } ?>
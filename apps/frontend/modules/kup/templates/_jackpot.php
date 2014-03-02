<div class="jackpot">
	<div style="float: left;">
		<?php if ($thousands != ''): ?>
			<?php echo image_tag('kup/view/boxkup_tools_cagnotte'.$thousands.'.png', array('alt' => __('Jackpot'), 'size'=>'30x44') ) ?>
		<?php endif ?>
		<?php if ($hundred != ''): ?>
			<?php echo image_tag('kup/view/boxkup_tools_cagnotte'.$hundred.'.png', array('alt'=>__('Jackpot'), 'size'=>'30x44') ) ?>
		<?php endif ?>
		<?php if ($ten != ''): ?>
			<?php echo image_tag('kup/view/boxkup_tools_cagnotte'.$ten.'.png', array('alt'=>__('Jackpot'), 'size'=>'30x44') ) ?>
		<?php endif ?>
		<?php echo image_tag('kup/view/boxkup_tools_cagnotte'.$unity.'.png', array('alt'=>__('Jackpot'), 'size'=>'30x44') ) ?>
		<?php echo image_tag('kup/view/boxkup_tools_euro.png', array('alt'=>__('Jackpot'), 'size'=>'30x44') ) ?>
	</div>
	<div style="font-size: 20px; font-family: Arial; float: left; padding-left: 5px;">*</div>
</div>
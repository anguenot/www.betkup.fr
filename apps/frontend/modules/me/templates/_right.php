<div
    class="todolist"
    style="background: url(<?php echo $sf_user->getAttribute('type', '', 'subscriber') == sfConfig::get("mod_me_account_type_gambling_fr") ? '/images/me/todo_list_gambling.png' : '/images/me/todo_list_free.png' ?> );
           height: <?php echo $sf_user->getAttribute('type', '', 'subscriber') == sfConfig::get("mod_me_account_type_gambling_fr") ? '435px' : '360px' ?>;
           ">
	<div class="bar">
		<div class="bar-empty"></div>
		<div class="bar-progress" style="width: <?php echo $percentage; ?>%;">
			<div class="percentage"><?php echo $percentage; ?>%</div>
		</div>
	</div>
	<div class="list">
		<?php if (in_array('me_todo_account_created', $sf_data->getRaw('status'))) : ?>
			<div class="point-check">
				<?php echo __('text_todo_account_created'); ?>
			</div>
		<?php else : ?>
			<div class="point-uncheck">
				<a href=""><?php echo __('text_todolist_account_created'); ?></a>
				<?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
			</div>
		<?php endif; ?>
		<!--
		<?php if (in_array('me_todo_account_credited', $sf_data->getRaw('status'))) : ?>
			<div class="point-check">
				<?php echo __('text_todolist_account_credited'); ?>
			</div>
		<?php else : ?>
			<div class="point-uncheck">
				<a href=""><?php echo __('text_todolist_account_credited'); ?></a>
				<?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
			</div>
		<?php endif; ?>
		<?php if (in_array('me_todo_account_verified', $sf_data->getRaw('status'))) : ?>
			<div class="point-check">
				<?php echo __('text_todolist_player_verified'); ?>
			</div>
		<?php else : ?>
			<div class="point-uncheck">
				<a href=""><?php echo __('text_todolist_player_verified'); ?></a>
				<?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
			</div>
		<?php endif; ?>
		-->
		<?php if (in_array('me_todo_facebook_linked', $sf_data->getRaw('status'))) : ?>
			<div class="point-check">
				<?php echo __('text_todolist_facebook_linked'); ?>
			</div>
		<?php else : ?>
			<div class="point-uncheck">
				<a href="<?php echo url_for(array('module'=>'account', 'action'=>'privacy')) ?>"><?php echo __('text_todolist_facebook_linked'); ?></a>
				<?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
			</div>
		<?php endif; ?>
        <?php if (in_array('me_todo_photo_added', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_todolist_photo_added'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'account', 'action'=>'index')) ?>"><?php echo __('text_todolist_photo_added'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php if (in_array('me_todo_kup_participate', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_todolist_do_prediction'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'kup', 'action'=>'home')) ?>"><?php echo __('text_todolist_do_prediction'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php if (in_array('me_todo_join_room', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_todolist_room_join'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'room', 'action'=>'home')) ?>"><?php echo __('text_todolist_room_join'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php if (in_array('me_todo_gambling_account_created', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_me_todo_gambling_account_created'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'account', 'action'=>'updateSimpleAccount')) ?>"><?php echo __('text_me_todo_gambling_account_created'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php if ($sf_user->getAttribute('type', '', 'subscriber') == sfConfig::get("mod_me_account_type_gambling_fr")): ?>
        <?php if (in_array('me_todo_gambling_account_verified', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_me_todo_gambling_account_verified'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'account', 'action'=>'status')) ?>"><?php echo __('text_me_todo_gambling_account_verified'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php if (in_array('me_todo_gambling_account_credited', $sf_data->getRaw('status'))) : ?>
            <div class="point-check">
                <?php echo __('text_me_todo_gambling_account_credited'); ?>
            </div>
        <?php else : ?>
            <div class="point-uncheck">
                <a href="<?php echo url_for(array('module'=>'account', 'action'=>'credit')) ?>"><?php echo __('text_me_todo_gambling_account_credited'); ?></a>
                <?php echo image_tag('/image/default/me/arrow.png', array('alt' => __('label_me_arrow'), 'size' => '24x6')) ?>
            </div>
        <?php endif; ?>
        <?php endif; ?>
	</div>
</div>
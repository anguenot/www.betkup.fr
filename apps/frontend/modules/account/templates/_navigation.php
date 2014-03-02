<div class="" style="height: 55px; margin-top: <?php echo $marginHeight ?>px; margin-left: 7px;">
    <div class="onglet1" style="width: 163px; height: 57px; position: absolute;">
        <?php if ( $module == "me" ): ?>
            <a href="<?php echo url_for(array('module' => 'me', 'action' => 'index')) ?>" title="<?php echo __('title_account_home'); ?>">
				<?php echo image_tag('moncompte/me_white_on.png', array('alt' => __('title_account_home'), 'border' => '0', 'size' => '163x70')); ?>
            </a>
        <?php else: ?>
            <a href="<?php echo url_for(array('module' => 'me', 'action' => 'index')) ?>" title="<?php echo __('title_account_home'); ?>">
                <?php echo image_tag('moncompte/button_mybetkup_room_perso.png', array('alt' => __('title_account_home'), 'border' => '0', 'size' => '163x57')); ?>
            </a>
        <?php endif ?>
    </div>

    <div class="onglet2" style="margin: 0px; padding: 0px; width: 157px; height: 57px; position: absolute; margin-left: 163px;">
    	<?php if ( $excludedKupAction == true): ?>
        	<a href="<?php echo url_for(array('module' => 'kup', 'action' => 'home')) ?>" title="<?php echo __('title_account_kups'); ?>"><?php echo image_tag('/image/default/navigation/menu_item2_on_grey.png', array('alt' => __('title_account_kups'), 'border' => '0', 'size' => '154x63')); ?></a>
        <?php else: ?>
        	<a href="<?php echo url_for(array('module' => 'kup', 'action' => 'home')) ?>" title="<?php echo __('title_account_kups'); ?>"><?php echo image_tag('/image/default/navigation/menu_item2_off.png', array('alt' => __('title_account_kups'), 'border' => '0', 'size' => '157x70')); ?></a>
        <?php endif ?>
    </div>

    <div class="onglet3" style="width: 154px; height: 70px; position: absolute; margin-left: 320px;">
        <?php if ( $excludedRoomAction == true ): ?>
            <a href="<?php echo url_for(array('module' => 'room', 'action' => 'home')) ?>" title="<?php echo __('title_account_rooms'); ?>">
                <?php if ( $action == "home" || $action == "create" || $action = "search"): ?>
                    <?php echo image_tag('moncompte/button_roomsWhiteOn_fr.png', array('alt' => __('title_account_rooms'), 'border' => '0', 'size' => '154x70')); ?>
                <?php else: ?>
                    <?php echo image_tag('moncompte/button_rooms.png', array('alt' => __('title_account_rooms'), 'border' => '0', 'size' => '154x57')); ?>
                <?php endif ?>
            </a>
        <?php else: ?>
            <a href="<?php echo url_for(array('module' => 'room', 'action' => 'home')) ?>" title="<?php echo __('title_account_rooms'); ?>">
            	<?php echo image_tag('moncompte/button_rooms.png', array('alt' => __('title_account_rooms'), 'border' => '0', 'size' => '154x57')); ?>
            </a>
        <?php endif ?>
    </div>
    
    <div class="onglet4" style="width: 154px; height: 70px; position: absolute; margin-left: 473px;">
        <?php if ( $excludedChallengeAction == true ): ?>
            <a href="<?php echo url_for(array('module' => 'challenge', 'action' => 'home')) ?>" title="<?php echo __('title_account_challenge'); ?>">
                <?php if ( $action == "home" || $action == "promos" ): ?>
                    <?php echo image_tag('moncompte/button_challengesWhiteOn_fr.png', array('alt' => __('title_account_challenge'), 'border' => '0', 'size' => '154x70')); ?>
                <?php else: ?>
                    <?php echo image_tag('moncompte/button_challenges_fr.png', array('alt' => __('title_account_challenge'), 'border' => '0', 'size' => '154x57')); ?>
                <?php endif ?>
            </a>
        <?php else: ?>
            <a href="<?php echo url_for(array('module' => 'challenge', 'action' => 'home')) ?>" title="<?php echo __('title_account_challenge'); ?>">
            	<?php echo image_tag('moncompte/button_challenges_fr.png', array('alt' => __('title_account_challenge'), 'border' => '0', 'size' => '154x57')); ?>
            </a>
        <?php endif ?>
    </div>
</div>
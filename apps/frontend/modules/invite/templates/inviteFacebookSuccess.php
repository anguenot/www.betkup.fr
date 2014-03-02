<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
		<?php include_component('room', 'right', array('dataRoom'=>$dataRoom)); ?>
		<div class="view" style="margin-top: 4px;">
			<div class="" style="margin-left: 10px;">
				<?php include_component('room', 'header', array ('data'=>$dataRoom)) ?>
			</div>
			<?php if ( $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator')) ): ?>
			<?php include_component('room', 'tabs', array('numTab' => '3', 'id' => '3', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
			<?php endif ?>	
			<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
			<div style="height: 25px;"></div>
		    <?php include_component('account', 'title', array('racine' => 'invite_friends', 'altImg' => __('label_room_invite_friends'), 'area' => 'areaOne')) ?>
		    <?php include_component('invite', 'facebook', array('room_uuid'=>$room_uuid, 'invite_send'=>$invite_send)) ?>
			<?php include_component('interface', 'areaOneEnd') ?>
		</div>
	</div>
</div>

<div class="moncompte rugby">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="view">
		<?php include_component('kup', 'right', array('kupData' => $kupData)) ?>
		<div class="view" style="margin-top: 4px;">
			<div class="" style="margin: 0px; margin-left: 0px; margin-bottom: 12px;">
				<?php include_component('kup', 'box', array('kupData' => $kupData)) ?>
			</div>
			<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs)) ?>
			<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
			<div style="height: 20px; display: block;"></div>
			<p>
			<?php if ($kupData['status'] != 0): ?>
			<?php echo image_tag('interface/ticker_error.png', array('size' => '15x15')); ?>
			<b><?php echo __("Il n'est plus possible de pronostiquer sur cette Kup. Vous pouvez en revanche suivre le classement de la Kup.") ?></b>
			<?php endif ?>
			<p/>
		    <div style="height: 20px; display: block;"></div>
			<?php include_component('rugby', 'predictionKnockout', array('tournamentData' => $tournamentData, 'kupData' => $kupData)) ?>
            <div style="height: 50px; display: block;"></div>
			<div style="height: 25px;"></div>
            <?php include_component('interface', 'areaOneEnd') ?>
		</div>
	</div>
</div>
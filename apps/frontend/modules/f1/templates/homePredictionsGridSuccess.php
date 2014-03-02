<div id="f1-grid-view-last-prono">
    <div style="text-indent: 0; font: bold 12px Arial, sans-serif;">
        <?php if ($lastModified != NULL): ?>
        <?php $date = util::displayDateCompleteFromTimestampComplet($lastModified); ?>
        <?php if($sf_user->getAttribute('grid_is_draft', '0', 'predictionsSave') &&
                 $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
            <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 11px Arial, sans-serif;">
                <?php echo __('text_predictions_draft_with_last_modification', array(
                                                                                    '%br%' => '<br />',
                                                                                    '%span%' => '<span style="font: normal 11px Arial, sans-serif;">',
                                                                                    '%/span%' => '</span>',
                                                                                    '%link_date%' => link_to(substr($date, 0, strlen($date) - 7), url_for(array('module' => 'kup',
                                                                                                                                                                'action' => 'view',
                                                                                                                                                                'uuid' => $kup_uuid)).'?empty_draft=1',
                                                                                        array(
                                                                                            'class' => 'draft-pronos',
                                                                                            'style' => 'font: bold 11px Arial, sans-serif; color: #9f4113;'
                                                                                        ))
                                                                               )) ?>
            </h2>
            <?php else : ?>
            <h2 class="date" style="padding: 5px; font: bold 11px Arial, sans-serif;" title="<?php echo $date ?>">
                <?php echo __('label_kup_prediction_last_modified') . ' : ' . substr($date, 0, strlen($date) - 7) ?>
            </h2>
            <?php endif; ?>
        <?php else : ?>
        <?php if($sf_user->getAttribute('grid_is_draft', '0', 'predictionsSave') &&
            $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
            <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 11px Arial, sans-serif;">
                <?php echo __('text_predictions_draft_simple') ?>
            </h2>
            <?php else : ?>
            <h2 style="padding: 5px; font: bold 11px Arial, sans-serif;">
                <?php echo __('label_kup_prediction_none') ?>
            </h2>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<table class="podium-table-grid">
<?php for($i=1; $i <= 4; $i++) :?>
	<?php if($i == 1 || $i == 3) :?>
	<tr>
	<?php endif; ?>
		<?php if($i > $maxDisplay) :?>
		<td></td>
		<?php else :?>
		<td>
			<div class="div-top">
				<div class="rank-grid"><?php echo $i; ?></div>
				<div class="car">
					<?php echo (isset($predictions[$i-1]) && isset($predictions[$i-1]['car'])) ? image_tag($predictions[$i-1]['car'], array('size' => '100x28')) : image_tag('/image/default/f1/interface/car_default.png', array('size' => '100x28'));?>
				</div>
			</div>
			<div class="div-bottom">
				<div class="info-grid"><?php echo (isset($predictions[$i-1]) && isset($predictions[$i-1]['driver'])) ? '<b>'.$predictions[$i-1]['driver'].'</b>' : 'Aucun pronostic'?></div>
				<div class="info-grid"><?php echo (isset($predictions[$i-1]) && isset($predictions[$i-1]['team'])) ? $predictions[$i-1]['team'] : ''?></div>
			</div>
		</td>
		<?php endif;?>
	<?php if($i == 2 || $i == 4) :?>
	</tr>
	<?php endif;?>
<?php endfor;?>
</table>
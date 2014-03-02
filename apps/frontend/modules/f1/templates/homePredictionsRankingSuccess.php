<div id="f1-ranking-view-last-prono">
    <div style="text-indent: 0;">
        <?php if ($lastModified != NULL): ?>
        <?php $date = util::displayDateCompleteFromTimestampComplet($lastModified); ?>
        <?php if($sf_user->getAttribute('ranking_is_draft', '0', 'predictionsSave') &&
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
        <?php if($sf_user->getAttribute('ranking_is_draft', '0', 'predictionsSave') &&
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
<table class="podium-table">
<?php for($i=1; $i<=10; $i++) :?>
	<?php if($i==4) :?>
	<tr>
		<td colspan="3" style="height:15px;">
		
		</td>
	</tr>
	<?php endif;?>
	<tr class="<?php echo ($i<=3) ? 'f1-podium-row' : 'f1-prono-row' ?>">
		<td class="podium-image">
			<?php echo ($i<=3) ? image_tag('/image/default/f1/interface/podium_'.$i.'.png', array('size' => '32x18', 'style' => 'margin-left: 2px;')) : '<div class="podium-rank">'.$i.'<sup>e</sup></div>' ?>
		</td>
		<td class="helmet">
			<?php if(isset($predictions[$i-1]) && isset($predictions[$i-1]['helmet'])) :?>
				<?php echo ($i<=3) ? image_tag($predictions[$i-1]['helmet'], array('height' => '30px', 'style' => "margin-left: 5px;")) : image_tag($predictions[$i-1]['helmet'], array('height' => '20px', 'style' => "margin-left: 15px;"));?>
			<?php else: ?>
				<?php echo image_tag('/image/default/f1/interface/default_helmet.png', array('height' => '20px', 'style' => "margin-left: 20px;"))?>
			<?php endif; ?>
		</td>
		<td class="driver">
			<?php if(isset($predictions[$i-1]) && isset($predictions[$i-1]) && isset($predictions[$i-1]['driver']) && isset($predictions[$i-1]['team'])) :?>
				<div><b><?php echo $predictions[$i-1]['driver']; ?></b></div>
				<div><?php echo $predictions[$i-1]['team']; ?></div>
			<?php else: ?>
				<div>Aucun pronostic</div>
			<?php endif; ?>
		</td>
	</tr>
<?php endfor; ?>
</table>
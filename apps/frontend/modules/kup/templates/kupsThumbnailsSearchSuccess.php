<h3>
<?php echo __('text_kup_search_showing_kups', array('%kups%' => count($kupsData), '%total%' => $totalKups))?>
</h3>
<div id="findKupResults">
<?php foreach ( $kupsData as $kup ): ?>
	<?php if(isset($kup["ui"]["vignette_room_kup_view"]) && ($kup["ui"]["vignette_room_kup_view"] != "")){ $imgBackground = $kup["ui"]["vignette_room_kup_view"];}else{ $imgBackground = $kup["avatarUrl"];};?>
	<?php include_component('kup', 'kupThumbnailKups', array(
							'kup' => $kup,
                            'imgBackground' => $imgBackground,
                            'cssTitleBloc'=>'white',
                            'cssTitleKup'=>'white')) ?>
    <?php endforeach ?>
</div>
<?php include_component('interface', 'pagination', array(
			'totalKups' => $totalKups, 
			'offset' => $offset,
			'batchSize' => $batchSize,
			'functionKupsLoad' => 'loadKups'))?>
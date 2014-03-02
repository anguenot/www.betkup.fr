<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 15px;">
						<div class="" style="margin: 0px; margin-left: 0px; margin-bottom: 17px;">
						<?php include_component('kup', 'kupHeader', array('kupData' => $kupData)) ?>
						</div>
						<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
						<div style="height: 25px;"></div>
						<?php include_component('account', 'title', array('racine' => 'classement', 'altImg' => __('label_kup_ranking'), 'area' => 'areaOne')) ?>
						<!-- ?php include_component('kup', 'percent', array('progress' => 65, 'nbEvents' => 4, 'nbEventsTotal' => 9)) ?-->
						<?php include_component('kup', 'ranking',
								array('uuid' => $uuid, 
									  'kupsRankingData' => $kupsRankingData, 
									  'offset' => $offset, 
									  'batch' => $batch, 
									  'nbPlayers'=>$nbPlayers,
								      'kupData' => $kupData,
									  'memberPosition'=>$memberPosition,
									  'urlForFacebook' => $urlForFacebook,
									  'userRanking' => $userRanking)) ?>
						<!-- ?php include_component('kup', 'wall', array('uuid' => $uuid)) ? -->
					    <div style="height: 5px;"></div>
					    <div class="fb-comments" data-href="<?php echo $urlForFacebook; ?>" data-num-posts="5" data-width="704"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php include_component('kup', 'right', array('kupData' => $kupData)) ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
$(window).bind("load",function(){
	var heightRightRoom = parseInt($('.rightroom').css('height'));
	var heightView = parseInt($('.view').css('height'));
	var heightDiff = heightRightRoom-heightView;

	if(heightDiff >= '0'){
		var goodHeight = heightDiff+90;
		$('#areaOneEnd_bottom').css('height',goodHeight);
	}
});
</script>
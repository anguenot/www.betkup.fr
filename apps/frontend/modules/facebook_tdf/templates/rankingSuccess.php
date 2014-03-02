<div class="row-fluid">
	<div class="span1"></div>
	<div class="span10 span-ranking">
		<div id="ranking-tabs">
		<ul>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'rankingGeneral')); ?>" <?php echo (isset($selectedTab) && $selectedTab == 1) ? 'class="selected-tab"': ''?>>
					Classement général
					<span class="arrow-down"></span>
				</a>
				
			</li>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'rankingFriends')); ?>" <?php echo (isset($selectedTab) && $selectedTab == 2) ? 'class="selected-tab"': ''?>>
					Classement de vos amis
					<span class="arrow-down"></span>
				</a>
				
			</li>
		</ul>
	</div>
	<div style="height: 10px; width: 100%;">&nbsp;</div>
	<div style="width: 710px; margin: 0px auto;">
		<form id="form-ranking-filter" method="post">
			<select id="select-ranking-kups" name="ranking_kups" class="cycling-select">
				<option value="-1"><?php echo __('text_all_cycling_race')?></option>
				<?php foreach ($kupsData as $kup) :?>
				<option value="<?php echo $kup['uuid']?>" <?php echo $kup['uuid'] == $kupData['uuid'] ? 'selected="selected"' : '' ?>>
					<?php echo $kup['name']?>
				</option>
				<?php endforeach;?>
			</select>
		</form>
	</div>
	<div style="height: 20px; width: 100%;">&nbsp;</div>
	<div id="ranking-content"></div>
	</div>
	<div class="span1"></div>
</div>
<script type="text/javascript">
$(function() {
	$('a', $('#ranking-tabs')).click(function() {
		$('.selected-tab').removeClass('selected-tab');
		$(this).addClass('selected-tab');
		loadRanking(0, '<?php echo $batchSize ?>');

		return false;
	});
	$('.selected-tab').trigger('click');

	$('#select-ranking-kups').selectmenu({
		style:'dropdown', 
		width: 180,
		menuWidth: 180
	});
	
	$('#select-ranking-kups').change(function() {
		$('.selected-tab').trigger('click');
	});
});

function loadRanking(offset, batchSize) {
	var kupId = $('#select-ranking-kups').val(),
		url = $('.selected-tab').attr('href');
	
	$('#ranking-content').loadContent({
		'url' : url,
    	'method' : 'GET',
    	'data' : {
        	"room_uuid" : "<?php echo $room_uuid?>", 
        	"kup_uuid" : kupId,
        	"offset" : offset,
        	"batchSize" : batchSize
        }
	});
}
</script>
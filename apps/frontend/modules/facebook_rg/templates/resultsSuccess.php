<div style="margin: 0px; height: 50px; width: 730px; line-height: 50px;">
	<form id="form-filter" method="post" style="float: right;">
		<select id="results-kups" name="results_kups" class="select-filter">
			<?php foreach($kupsData as $kupData) :?>
			<option value="<?php echo $kupData['uuid'] ?>">
				<?php echo $kupData['name']?>
			</option>
			<?php endforeach;?>
		</select>
		<select id="results-friends" name="results-friends" class="select-filter">
			<option value="0">Mes résultats</option>
			<option value="1">Résultats de mes amis</option>
		</select>
	</form>
</div>
<div id="contents">
	<div id="results-module">
		<?php include_component('f1', 'results', array(
		    	'kup_uuid' => $kup_uuid,
		    	'room_uuid' => $room_uuid,
		    	'kupData' => $kupData
		)) ?>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#results-kups').selectmenu({
		style:'dropdown', 
		width: 160,
		menuWidth: 160
	});

	$('#results-friends').selectmenu({
		style:'dropdown', 
		width: 160,
		menuWidth: 160
	});

	$('.select-filter').change(function() {
		var filters = $('#form-filter').serializeObject();
		loadAllContent(JSON.stringify(filters));
	});
});
</script>
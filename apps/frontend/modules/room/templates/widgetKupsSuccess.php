<div id="select-kups-container">
	<table>
		<tr>
			<td>
				<div class="widget-picto-kups"></div>
			</td>
			<td>
				<select id="select-kups-dropdown">
					<option value="0"><?php echo __('text_widget_all_kups')?></option>
					<?php foreach($kupsData as $kupData) :?>
					<option value="<?php echo $kupData['uuid']?>">
						<?php echo $kupData['name']?>
					</option>
					<?php endforeach;?>
				</select>
			</td>
		</tr>
	</table>
</div>
<div id="container"></div>
<script type="text/javascript">
$(function() {
	$('#select-kups-dropdown').selectmenu({style:'dropdown', width: 150, menuWidth: 200});
	loadContainer();
	
	$('#select-kups-dropdown').change(function() {
		loadContainer();
	});
});

function loadContainer() {
	var kupXhr, kup_uuid;

	kup_uuid = $('#select-kups-dropdown').val();
	
	kupXhr = $.ajax({
		'url' : '<?php echo url_for(array('module' => 'room', 'action' => 'getWidgetUrl')) ?>',
		'type' : 'get',
		'dataType' : 'text',
		'data' : {
			'room_uuid' : '<?php echo $room_uuid?>',
			'kup_uuid' : kup_uuid
		},
		'beforeSend' : function() {
			$('#container').loadingModal();
		}
	});
	
	kupXhr.done(function(url) {
		$.ajax({
			'url' : url,
			'dataType' : 'html',
			'data' : {
				'urlToLink' : '<?php echo $urlToLink ?>'
			},
			'success' : function(datas) {
				$('#container').loadingModal({'show': false});
				$('#container').html(datas);
			}
		});
	});
}
</script>
<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table" style="margin-top: -2px;">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view">
					<?php include_component('interface', 'areaOneBegin', array('margintop' => 4, 'marginleft' => 13)) ?>
						<div>
							<div style="height: 10px;"></div>
							<table id="title-room-search">
								<tr>
									<td>
										<div id="title-pic"></div>
									</td>
									<td>
										<h1>
										<?php echo __('text_room_search_find_room')?>
										</h1>
									</td>
								</tr>
							</table>
							<form id="formFindRoom" name="formFindRoom" method="post">
								<div class="room">
									<div id="room-filters-container">
										<table id="room-filters" class="hide">
											<tr>
												<td colspan="3">
													<div style="height: 20px;"></div>
												</td>
											</tr>
											<tr>
												<td width="245" align="left" valign="top">
													<?php include_component('interface', 'widgetChoices', array('data' => $rows[0])) ?>
												</td>
												<td width="245" align="left" valign="top">
													<?php include_component('interface', 'widgetChoices', array('data' => $rows[1])) ?>
												</td>
												<td width="245" align="left" valign="top">
													<?php include_component('interface', 'widgetChoices', array('width' => '225', 'data' => $rows[2])) ?>
													<div style="height: 20px;"></div> 
													<?php include_component('interface', 'widgetChoices', array('width' => '225', 'data' => $rows[3])) ?>
												</td>
											</tr>
										</table>
									</div>
									<div id="keyword-filter">
										<?php //echo image_tag('/images/room/search/searchKeys.png', array('style' => 'border: 0px;', 'size' => '200x53'))?>
                                        <div style="height: 20px;"></div>
                                        <h2 style="text-indent: 10px; color: #575756; font: bold 14px Arial, sans-serif;">
                                            <?php echo __('text_room_search_keywords') ?>
                                        </h2>
                                        <table style="margin: 0px; padding: 0px; margin-top: 6px;">
											<tr>
												<td align="left" valign="middle">
												<input type="text"
													name="roomHomeSearchText"
													value="<?php echo $defaultSearchText ?>"
													class="inputSearchRoomHome"
													style="width: 575px; height: 27px; margin-right: 12px;" />
												</td>
												<td align="left" valign="middle">
													<a href="javascript:void(0);"
														onClick="$('#formFindRoom').submit();"
														title="<?php echo __('Search') ?>"> <?php echo image_tag('/images/interface/button/search_fr.png', array('style' => 'border: 0px;', 'size' => '118x27'))?>
													</a>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</form>
							<!-- XXX Uncoment this when complete Room search is supported.
                            <table class="filters-options">
								<tr>
									<td>
										<div class="pic-filters-option pic-more"></div>
									</td>
									<td>
										<a class="more-option" href="javascript:void(0);">
											<?php echo __('text_room_search_more_options')?>
										</a>
									</td>
								</tr>
							</table>
							-->
							<div style="height: 10px;"></div>
						</div>
						<div style="height: 20px;"></div>
						<div id="rooms-thumbnails-container">
							<div class="background-div">
								<div id="rooms-thumbnails-list"></div>
							</div>
						</div>
						<div style="height: 45px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php include_component('room', 'right') ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
$('.checkbox').checkbox({cls: 'checkbox'});
$(function() {
	$('.more-option').click(function() {
		var table = $('#room-filters');
		
		if(table.hasClass('hide')) {
			table.removeClass('hide');
			$('#room-filters-container').slideToggle('fast');
			$(this).html("<?php echo __('text_room_search_less_options')?>");
			$(this).parent().parent().find('.pic-filters-option').removeClass('pic-more').addClass('pic-less');
		} else {
			$('#room-filters-container').slideToggle('fast');
			table.addClass('hide');
			$(this).html("<?php echo __('text_room_search_more_options')?>");
			$(this).parent().parent().find('.pic-filters-option').removeClass('pic-less').addClass('pic-more');
		}
	});
	loadRooms();

	$('.inputSearchRoomHome').focus(function(){
		$(this).addClass('inputSearchRoomHomeSelected');
	}).blur(function() {
		$(this).removeClass('inputSearchRoomHomeSelected');
	});
	
	$(".room-sensible-cell").hover(function() {
		$(this).addClass('kup-cell-hover');
	}, function() {
		$(this).removeClass('kup-cell-hover');
	});

	$(".checkbox").parent().parent().removeClass('kup-cell-selected');
	$(".checkbox:checked").parent().parent().addClass('kup-cell-selected');

	$(".checkbox").change(function() {
		if($(this).hasClass('CATEGORY')) {

			if($(this).attr('id') == 'checkbox_CATEGORY_ALL') {
				if($(this).is(':checked')) {
					$('.CATEGORY').attr('checked', false);
					$(this).attr('checked', true);
				}
			} else {
				$('#checkbox_CATEGORY_ALL:checked').attr('checked', false);
			}
		} else if($(this).hasClass('<?php echo sfConfig::get('app_kup_search_params_sports') ?>')) {

			if($(this).attr('id') == 'checkbox_<?php echo sfConfig::get('app_kup_search_params_sports') ?>_<?php echo sfConfig::get('app_params_type_sports_all') ?>') {
				if($(this).is(':checked')) {
					$('.<?php echo sfConfig::get('app_kup_search_params_sports') ?>').attr('checked', false);
					$(this).attr('checked', true);
				}
			} else {
				$('#checkbox_<?php echo sfConfig::get('app_kup_search_params_sports') ?>_<?php echo sfConfig::get('app_params_type_sports_all') ?>:checked').attr('checked', false);
			}
		}
		$(".checkbox").parent().parent().removeClass('kup-cell-selected');
    	$(".checkbox:checked").parent().parent().addClass('kup-cell-selected');    	
		$('#formFindRoom').submit();
    });

    $('#formFindRoom').submit(function() {
    	loadRooms();
		return false;
	});
});

function loadRooms(offset, batchSize) {
	var params =  $('#formFindRoom').serialize(), postParams;

	if(typeof(offset) == 'undefined' || typeof(batchSize) == 'undefined') {
		var offset = 0;
		var batchSize = 9;
	}
	params = params+'&offset='+offset+'&batchSize='+batchSize+'&nbLine=3&nbDisplay=3';
	$('#rooms-thumbnails-list').loadContent({
		'url' : '<?php echo url_for(array('module' => 'room', 'action' => 'roomsThumbnailsSearch'))?>',
    	'method' : 'POST',
    	'data' : params
	});
}
</script>

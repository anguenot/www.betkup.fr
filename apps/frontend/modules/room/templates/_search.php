<div class="search" style="width: 710px; background: url('/images/tmp/roomSearch.png');">
	<div style="height: 21px;"></div>
	<div class="contentOfSearchRoom">
		<form name="formRoomTag" action="<?php echo url_for(array('module' => 'room', 'action' => 'search')) ?>" method="POST">			
			<?php echo __('label_room_search_keywords') ?>
			<table style="margin: 0px; padding: 0px; margin-top: 6px;">
				<tr>
					<td align="left" valign="middle">
						<input type="text" name="roomHomeSearchText" value="" class="inputSearchRoomHome"
							   style="width: 525px; height: 27px; margin-right: 12px;" />
					</td>
					<td align="left" valign="middle">
						<a href="javascript:void(0);" onClick="document.formRoomTag.submit();" title="<?php echo __('label_room_searching') ?>">
						    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/button_searching', array('alt' => __('label_room_advanced_search'), 'size' => '118x27')) ?> 
						</a>
					</td>
				</tr>
			</table>
		</form>
		<div style="height: 27px;"></div>
	</div>
	<div align="center">
		<a href="javascript:void(0);" onClick="document.formRoomTag.submit();">
		<?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/button_advanced_search', array('alt' => __('label_room_advanced_search'), 'size' => '170x28')) ?>
		</a>
	</div>	
	<div style="height: 20px;"></div>
</div>
<script type="text/javascript">
$('.inputSearchRoomHome').focus(function() {
	$('.inputSearchRoomHome').addClass('inputSearchRoomHomeSelected');
}).blur(function() {
	$('.inputSearchRoomHome').removeClass('inputSearchRoomHomeSelected');
});
</script>
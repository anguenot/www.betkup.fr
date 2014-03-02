<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room" style="margin-top: -2px;">
	<table id="room_table">
    	<tr>
        	<td style="vertical-align: top; width: 760px;">
			<div class="view">
				<?php include_component('interface', 'areaOneBegin', array('margintop' => 4, 'marginleft' => 13, 'header' =>'grey')) ?>
				<div id="top-search">
					<div style="height: 5px;"></div>
						<?php echo image_tag('interface/titre/findKup_'.$sf_user->getCulture().'.png', array('alt' => '', 'border' => '0', 'size' => '349x45'));?>
					<div style="height: 5px;"></div>
					<div id="search-menu">
						<?php include_component('kup', 'search', array()) ?>
					</div>
				</div>
				<div id="kups-thumbnails-container">
					<div class="background-div">
						<div id="kups-thumbnails-list"></div>
					</div>
				</div>
				<?php include_component('interface', 'areaOneEnd') ?>
			</div>
		</td>
		<td style="vertical-align: top; width: 220px;">
        	<div style="padding-left: 5px; padding-top: 7px;">
				<?php include_component('kup', 'right') ?>
			</div>
		</td>
		</tr>
		</table>
	</div>
</div>
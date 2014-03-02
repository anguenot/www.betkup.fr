<?php use_stylesheet('kup/search/checkbox.css')?>
<?php use_javascript('jquery.checkbox.min.js')?>
<form id="formFindKup" name="formFindKup" action="<?php echo url_for(array('module'=>'kup', 'action'=>'search')) ?>" method="get">
    <table style="padding:0; border-spacing: 0; border-collapse: collapse; width: 710px;">
        <thead>
        <tr>
            <th width="150">
            	<table class="search-kups-top">
            		<tbody>
            			<tr>
            				<td style="width: 12px">
                                <?php echo image_tag('/image/default/kup/search/sport_pic.png', array('size' => '12x10'))?>
                            </td>
            				<td>
            					<h2><?php echo __('kup_search_sports')?></h2>
            				</td>
            			</tr>
            		</tbody>
            	</table>
            </th>
            <th width="150">
	            <table class="search-kups-top">
	            	<tbody>
	            		<tr>
	           				<td style="width: 18px">
                                   <?php echo image_tag('/image/default/kup/search/dol_pic.png', array('size' => '18x10'))?>
                               </td>
	           				<td>
	           					<h2><?php echo __('kup_search_type')?></h2>
	           				</td>
	           			</tr>
	           		</tbody>
	           	</table>
	        </th>
            <th width="150">
	            <table class="search-kups-top">
	            	<tbody>
	           			<tr>
	           				<td style="width: 14px">
                                   <?php echo image_tag('/image/default/kup/search/status_pic.png', array('size' => '14x14'))?>
                               </td>
	           				<td>
	           					<h2><?php echo __('kup_search_status')?></h2>
	           				</td>
	            		</tr>
	           		</tbody>
	            </table>
            </th>
            <th width="150">
            	<table class="search-kups-top">
            		<tbody>
            			<tr>
            				<td style="width: 10px">
                                <?php echo image_tag('/image/default/kup/search/sort_pic.png', array('size' => '10x13'))?>
                            </td>
            				<td>
            					<h2><?php echo __('kup_search_sort_by')?></h2>
            				</td>
            			</tr>
            		</tbody>
            	</table>
            </th>
        </tr>
        </thead>
        <tbody>
	        <tr>
	        <?php $cpt=0; foreach ( $datas as $key => $colonne ): ?>
	            <td align="left" valign="top">
	            	<?php if($cpt < 4) :?>
			            <?php $i=0; foreach ( $colonne as $index => $value ): ?>
			                <div class="kup-sensible-cell" id="findKupCellule_<?php echo $key ?>_<?php echo $index ?>" style="cursor: pointer; width: 155px; border: 0px; <?php echo ($i==0) ? 'border-top: 1px solid #C8C8C8;': ''?> border-bottom: 1px solid #C8C8C8;">
			                <?php if (isset( $value["image"] )): ?>
			                    <div style="float: right;">
			                    <?php echo image_tag($value["image"], array('alt' => '', 'border' => '0', 'size' => '25x18'));?>
			                    </div>
			                <?php endif ?>
			                    <div style="padding: 5px 4px;">
			                        <input type="checkbox" id="checkbox_<?php echo $key ?>_<?php echo $index ?>" class="checkbox <?php echo $key ?>" name="<?php echo $key ?>[<?php echo $index ?>]" <?php echo (in_array($key.'_'.$index, $sf_data->getRaw('selectedDatas'))) ? 'checked="checked"' : ''; ?> value="1" />
			                        <label for="checkbox_<?php echo $key ?>_<?php echo $index ?>" class="normal"><?php echo __($value["name"]) ?></label>
			                    </div>
			               </div>
			            <?php $i++; endforeach ?>
		           <?php endif;?>
	            </td>
	        <?php $cpt++; endforeach ?>
	        </tr>
	        <tr>
	            <td colspan="4" class="search-bottom-line">
	            	<div class="search-bottom-line-container">
		            	<table class="search-kups-top">
		            		<tbody>
		            			<tr>
		            				<td style="width: 14px">
                                        <?php echo image_tag('/image/default/kup/search/options_pic.png', array('size' => '14x13'))?>
                                    </td>
		            				<td>
		            					<h2><?php echo __('kup_search_other_filters')?></h2>
		            				</td>
		            			</tr>
		            		</tbody>
		            	</table>
		               	<table class="other-filters-table">
			               	<tbody>
			               		<tr>	
			               		<?php if(isset($datas[sfConfig::get('app_kup_search_params_other')])) :?>
			               		<?php $i=0; foreach($datas[sfConfig::get('app_kup_search_params_other')] as $index => $value) :?>
			               			<?php if(!in_array($key.'_'.$index, $sf_data->getRaw('disabledDatas'))) :?>
			               			<td class="other-kup-search other-kup-search-<?php echo $i?>">
				               			<div class="kup-sensible-cell" style="padding: 5px 4px;">
						                	<input type="checkbox" id="checkbox_<?php echo $key ?>_<?php echo $index ?>" class="checkbox" name="<?php echo $key ?>[<?php echo $index ?>]" 
						                	<?php echo (in_array($key.'_'.$index, $sf_data->getRaw('selectedDatas'))) ? 'checked="checked"' : ''; ?>  
						                	value="1" />
						                    <label for="checkbox_<?php echo $key ?>_<?php echo $index ?>" class="normal"><?php echo __($value["name"]) ?></label>
					                    </div>
				                    </td>
				                    <?php endif;?>
			               		<?php $i++; endforeach;?>
			               		<?php endif; ?>
			               		</tr>
			               	</tbody>
		               </table>
	               </div>
	    	   </td>
	        </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">
$(function() {
	$('.checkbox').checkbox({cls: 'checkbox'});
	loadKups('<?php echo $offset ?>', '<?php echo $batchSize ?>');
	
    $(".kup-sensible-cell").hover(function() {
    	$(this).addClass('kup-cell-hover');
    }, function() {
    	$(this).removeClass('kup-cell-hover');
    });
    $(".checkbox").parent().parent().removeClass('kup-cell-selected');
	$(".checkbox:checked").parent().parent().addClass('kup-cell-selected');

    $(".checkbox").change(function() {
		if($(this).hasClass('<?php echo sfConfig::get('app_kup_search_params_stake') ?>')) {

			if($(this).attr('id') == 'checkbox_<?php echo sfConfig::get('app_kup_search_params_stake') ?>_<?php echo sfConfig::get('app_params_type_stake_all') ?>') {
				if($(this).is(':checked')) {
					$('.<?php echo sfConfig::get('app_kup_search_params_stake') ?>').attr('checked', false);
					$(this).attr('checked', true);
				}
			} else {
				$('#checkbox_<?php echo sfConfig::get('app_kup_search_params_stake') ?>_<?php echo sfConfig::get('app_params_type_stake_all') ?>:checked').attr('checked', false);
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
		} else if($(this).hasClass('<?php echo sfConfig::get('app_kup_search_params_status') ?>')) {

			if($(this).attr('id') == 'checkbox_<?php echo sfConfig::get('app_kup_search_params_status') ?>_<?php echo sfConfig::get('app_params_type_duration_all') ?>') {
				if($(this).is(':checked')) {
					$('.<?php echo sfConfig::get('app_kup_search_params_status') ?>').attr('checked', false);
					$(this).attr('checked', true);
				}
			} else {
				$('#checkbox_<?php echo sfConfig::get('app_kup_search_params_status') ?>_<?php echo sfConfig::get('app_params_type_duration_all') ?>:checked').attr('checked', false);
			}
		}
		$(".checkbox").parent().parent().removeClass('kup-cell-selected');
    	$(".checkbox:checked").parent().parent().addClass('kup-cell-selected');

		$('#formFindKup').submit();
    });

    $('#formFindKup').submit(function() {
    	loadKups();
		return false;
	});
});
function loadKups(offset, batchSize) {
	var params =  $('#formFindKup').serialize(), postParams;

	if(typeof(offset) == 'undefined' || typeof(batchSize) == 'undefined') {
		var offset = 0;
		var batchSize = '<?php echo $batchSize ?>';
	}
	params += params+'&offset='+offset+'&batchSize='+batchSize;
	$('#kups-thumbnails-list').loadContent({
		'url' : '<?php echo url_for(array(
                                         'module' => 'kup',
                                         'action' => 'kupsThumbnailsSearch'))?>',
    	'method' : 'POST',
        'abortOld' : true,
    	'data' : params
	});
}
</script>
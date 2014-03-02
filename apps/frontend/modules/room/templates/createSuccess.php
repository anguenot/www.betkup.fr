<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
    <div class="room">
    	<table id="room_table" style="margin-top: -2px;">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
			        <div class="view">
			            <?php include_component('interface', 'areaOneBegin', array('margintop' => 4, 'marginleft' => 15)) ?>
						<div style="margin: 0px; padding: 0px; width: 725px; height: 90px; background: url('/images/room/header.png');">
			                <div style="position: absolute; margin: 0px; padding: 0px; margin-left: 550px; margin-top: 46px;">
			                    <div style="height: 16px; padding-left: 9px; background: url('/images/interface/background/link.png') no-repeat;">
			                        <a href="<?php echo url_for(array('module' => 'room', 'action' => 'home')) ?>" class="orange12">
			                                <?php echo __("label_back_to_room_home") ?>
			                        </a>
			                    </div>
			                </div>
			            </div>
			            <div style="margin-left: 46px; margin-bottom: 35px; width: 651px; height: 38px; background: url('/images/room/create/rootlineStep1.png');"></div>
			            <?php if($sf_user->isAuthenticated() == false) :?>
			           	<div style="height: 10px;"></div>
			            <div class="warnning-room-authentification">
			            	<table>
			            		<tr>
			            			<td>
			            				<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
			            			</td>
			            			<td>
			            				<h3>
			            				<?php echo __('text_warnning_room_create_unauthenticated', array(
			            										'%login%' => link_to(__('text_warnning_room_create_unauthenticated_login'), url_for('account/login')), 
			            										'%register%' => link_to(__('text_warnning_room_create_unauthenticated_register'), url_for('account/register'))))?>
			            				</h3>
			            			</td>
			            		</tr>
			            	</table>
			            </div>
			            <div style="height: 20px;"></div>
			            <?php endif; ?>
			            <form name="createRoom" action="" id="createRoom" method="post" ENCTYPE="multipart/form-data">
			                <div style="margin: 0px; padding: 0px; margin-top: 10px;">
			                
			                <?php include_component('interface', 'simpleWidget', array(
			                    'bloc' => 'information',
			                    'largeur1' => '240',
			                    'largeur2' => '240',
			                    'widthGadget' => '240',
			                    'marginLeftError' => '400',
			                    'messageError' => __('label_form_create_room_name_error'),
			                    'blocType' => 'text',
			                    'blocIcone' => '',
			                    'blocName' => 'roomName',
			                	'maxlength' => '15',
			                    'blocLegende' => __('label_form_create_room_name_field'),
			                    'blocValue' => (isset($information ['roomName'])?$information ['roomName']:''),
			                    'blocHelp' => __('label_form_create_room_name_legend'),
			                    'displayHelp' => true,
			                    )) ?>

			                <?php include_component('interface', 'widgetDownload', array(
			                    'bloc' => 'information',
			                    'width1' => '222',
			                    'width2' => '230',
			                    'widthGadget' => '231',
			                    'heightGadget' => '20',
			                    'marginLeftError' => '400',
			                    'messageError' => __('label_form_create_room_avatar_error'),
			                    'blocType' => 'file',
			                    'blocIcone' => '',
			                    'blocName' => 'roomPicture',
			                    'blocLegende' =>  __('label_form_create_room_avatar_field'),
			                    'blocValue' => (isset($information ['roomPicture'])?$information ['roomPicture']:''),
			                    'blocHelp' =>  __('label_form_create_room_avatar_legend'),
			                    'displayHelp' => false,
			                	'formId' => 'createRoom'
			                    )) ?>
			
			                <?php include_component('interface', 'radio', array(
			                    'bloc' => 'information',
			                    'largeur1' => '220',
			                    'largeur2' => '256',
			                    'marginLeftError' => '400',
			                    'messageError' => __('label_form_create_room_access_error'),
			                    'blocName' => 'roomAccess',
			                    'blocLegende' =>  __('label_form_create_room_access_field'),
			                    'blocValue' => (isset($information ['roomAccess'])?$information ['roomAccess']:''),
			                    'blocChoices' => $roomAccessPolicies,
			                    'blocHelp' => __('label_form_create_room_access_legend'),
			                    'displayHelp' => true,
			                    'blocActions' => array('div_roomPassword', 'div_roomPassword', '', '')
			                    )) ?>
			
			                <?php include_component('interface', 'simpleWidget', array(
			                    'bloc' => 'information',
			                    'largeur1' => '220',
			                    'largeur2' => '220',
			                    'widthGadget' => '220',
			                    'marginLeftError' => '400',
			                    'messageError' => __('label_form_create_room_password_error'),
			                    'blocType' => 'password',
			                    'blocIcone' => '',
			                    'blocName' => 'roomPassword',
			                    'blocLegende' => __('label_form_create_room_password_field'),
			                    'blocValue' => (isset($information ['roomPassword'])?$information ['roomPassword']:''),
			                    'blocHelp' => '',
			                    'displayHelp' => true,
			                    'display' => ($information['roomAccess']== sfConfig::get('mod_room_privacy_private') || $information['roomAccess']== sfConfig::get('mod_room_privacy_private_gambling_fr') ? true : false),
			                    )) ?>
			                    
		                    <?php include_component('interface', 'widgetTextarea', array(
			                    'bloc' => 'information',
			                    'largeur1' => '220',
			                    'largeur2' => '220',
			                    'width1' => '220',
			                    'width2' => '252',
			                    'widthGadget' => '220',
			                    'heightGadget' => '100',
			                    'marginLeftError' => '400',
			                    'messageError' => '',
			                    'blocIcone' => '',
			                    'blocName' => 'roomDescription',
			                    'blocLegende' => __('label_form_create_room_description_field'),
			                    'blocValue' => (isset($information ['roomDescription'])?$information ['roomDescription']:''),
			                    'blocHelp' => __('label_form_create_room_description_help'),
			                    'displayHelp' => false,
			                )) ?>
			                </div>
			                <div style="margin: 0px; padding: 0px; width: 725px; height: 40px; margin-top: 30px;">
			                    <div style="position: absolute; margin: 0px; padding: 0px; margin-left: 100px;">
			                        <div style="height: 16px; padding-left: 9px; background: url('/images/interface/background/link.png') no-repeat;">
			                            <a href="javascript:void(0);" onclick="showHiddenDiv()" class="showDivBtn orange12">
			                                <?php echo __('label_room_create_form_more_options') ?> 
			                            </a>
			                        </div>
			                    </div>
			                </div>
			                <div style="clear: both;"></div>
			                <div class="hiddenDiv" style="margin: 0px; padding: 0px; width: 725px; display: none;">
			                   
			                    <?php include_component('interface', 'widgetCheckbox', array(
			                    'bloc' => 'information',
			                    'largeur1' => '220',
			                    'largeur2' => '256',
			                    'width1' => '220',
			                    'width2' => '252',
			                    'marginLeftError' => '400',
			                    'messageError' => '',
			                    'blocName' => 'roomType',
			                    'blocLegende' => __('label_form_create_room_types_field'),
			                    'blocValue' => (isset($information ['roomType'])?$information ['roomType']: array()),
			                    'blocChoices' => $roomTypes,
			                    'blocHelp' => __('label_form_create_room_types_help'),
			                    'displayHelp' => false,
			                    )) ?>
			                    <div style="border: 0px solid red; margin: 0px; padding: 0px; margin-top: 10px;">
			                <?php include_component('interface', 'simpleWidget', array(
			                    'bloc' => 'information',
			                    'largeur1' => '220',
			                    'largeur2' => '220',
			                    'width1' => '220',
			                    'width2' => '252',
			                    'widthGadget' => '220',
			                    'marginLeftError' => '400',
			                    'messageError' => '',
			                    'blocType' => 'text',
			                    'blocIcone' => '',
			                    'blocName' => 'roomTags',
			                    'blocLegende' => __('label_form_create_room_tags_field'),
			                    'blocValue' => (isset($information ['roomTags'])?$information ['roomTags']:''),
			                    'blocHelp' => __('label_form_create_room_tags_help'),
			                    'displayHelp' => true,
			                    )) ?>
			                    </div>
			                </div>
			                <div style="height: 20px;"></div>
			                <div align="center">
			                    <input id="nextStepBtn" type="image" title="" src="/images/interface/button/nextStep.png" />
			                </div>
			            </form>
			            <div style="height: 65px;"></div>
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
$(function() {
	$('#roomName').charCounter({
		'maxlength' : 25,
    	'counterText' : '<?php echo __('text_char_counter')?>'
	});

	$('#roomDescription').charCounter({
		'maxlength' : 130,
		'counterId' : 'room-description-counter',
    	'counterText' : '<?php echo __('text_char_counter')?>'
	});

	var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();

	$('#roomName').click(function() {
	    $('#roomName').keyup();
	});

	$("#roomName").keyup(function(event) {
	    
	    delay(function(){
	        checkRoomNameExist($('#roomName'));
	    }, 900);
	});
});

function checkRoomNameExist(handler) {
    
    $.ajax({
        type: 'GET',
        dataType: 'html',
        data: { name : $(handler).val() },
        url: '<?php echo url_for(array('module' => 'room', 'action' => 'existsRoomName')) ?>',
        beforeSend: function() {
            if($(handler).val() == '') {
                $(handler).removeClass("formInputVarcharSuccessOnlyTicker");
                $(handler).addClass("formInputVarcharErrorOnlyTicker");
            }
        },
        success: function(data) {
            
            if(data == 'true' || $(handler).val() == '') {
                $(handler).removeClass("formInputVarcharSuccessOnlyTicker");
                $(handler).addClass("formInputVarcharErrorOnlyTicker");
            } else {
                $(handler).removeClass("formInputVarcharErrorOnlyTicker");
                $(handler).addClass("formInputVarcharSuccessOnlyTicker");
            }
        },
        complete: function() {
            
        }
    });
}

function showHiddenDiv() {
    $('.hiddenDiv').fadeIn('500');
    $('.showDivBtn').html('<?php echo __('label_room_create_less_options'); ?>');
    $('.showDivBtn').attr('onclick', '').unbind('click').click(closeHiddenDiv);
}

function closeHiddenDiv() {
    $('.showDivBtn').html('<?php echo __('label_room_create_form_more_options') ?>');
    $('.hiddenDiv').fadeOut('500');
    $('.showDivBtn').attr('onclick', '').unbind('click').click(showHiddenDiv);
}
 
</script>

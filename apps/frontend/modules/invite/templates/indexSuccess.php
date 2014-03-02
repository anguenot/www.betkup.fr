<script type="text/javascript">
	$(function() {
		/* Default component loaded : here is the 'email' component */
		loadContent('first', 'email', 'invite', 'emails');
	});

	/*
	*	Used to load the components you want to display for invite module 
	*	Choose between 'email', 'facebook', 'link', 'twitter'
	*	Params: Object sender, 
	*			String typeInvite, 
	*			String calledModule, 
	*			String calledComponent
	*/
	function loadContent(sender, typeInvite, calledModule, calledComponent) {
		$.ajax({
		  type: "GET",
		  cache: false,
		  url: "<?php echo url_for(array('module'=>'invite', 'action'=>'componentDispatcher')) ?>",
		  data: {
				"room_uuid" : '<?php echo $room_uuid ?>',
				"kup_uuid" : '<?php echo $kup_uuid ?>',
				"type_invite" : typeInvite,
				"called_module" : calledModule,
				"called_component" : calledComponent,
				"customMessage" : '<?php echo $customMessage?>',
				"customUrl" : '<?php echo $customUrl?>'
		},
		dataType: "html",
	 	beforeSend: function() {
			$('#inviteModule').loadingModal();
		},
		success: function(data) {
			$('#inviteModule').loadingModal({'show': false});
			if(sender != 'first') {
				$('.selectedInvite').removeClass('selectedInvite');
				$(sender).parent().parent().parent().parent().parent().addClass('selectedInvite');

				$('.topMenu').addClass('topMenu'+ucfirst(typeInvite));
			}
			$('#tdRight').html(data);
		}
		});
	}
</script>
<?php include_component('invite', 'menu', array('type_invite' => $type_invite, 'room_uuid' => $room_uuid, 'kup_uuid' => $kup_uuid)); ?>
<div id="inviteModule" class="invite">
<div style="height: 20px; width: 100%; display: bloc; clear: both;"></div>
	<table>
		<tr>
			<td id="tdRight"></td>
		</tr>
	</table>
</div>
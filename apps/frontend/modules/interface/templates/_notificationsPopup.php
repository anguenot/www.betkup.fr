<?php use_stylesheet('interface/notificationsPopup.css')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
<div id="popup_accept_gain" title="<?php echo __('text_important_info_to_validate') ?>">
	<div id="content_popup">
		<p><?php echo __('text_learn_about_event')?></p>
        <br /><br />
		<form id="accept_popup_form" action="" method="post">
			<div id="overflow_div">
				<ul>
				<?php foreach($notifications as $key => $value) :?>
                    <?php if($key == 'policyAcceptance'): ?>
					<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $key; ?>" />
					<li><?php echo html_entity_decode($value) ?></li>
                    <?php endif; ?>
                    <?php if ($key == 'bonus'): ?>
                        <b>Bonus (alimentation en provenance de Betkup sur le compartiment bonus) :</b>
                        <br /><br />
                        <?php foreach($value as $txn) :?>
                            <input type="hidden" name="bonus[<?php echo $txn['txnUUID'] ?>]" value="<?php echo $txn['txnUUID'] ?>" />
                            <input type="hidden" name="bonus" value="<?php echo $txn['txnUUID'] ?>" />
                            <input type="hidden" name="bonusBefore" value="<?php echo $txn['creditBefore'] ?>" />
                            <input type="hidden" name="bonusAmount" value="<?php echo $txn['txnAmount'] ?>" />
                            <input type="hidden" name="bonusAfter" value="<?php echo $txn['creditAfter'] ?>" />
                            <input type="hidden" name="bonusName" value="<?php echo $txn['txnLabel'] ?>" />
                            <li><?php echo $txn['txnLabel'] . ' ' . $txn['txnAmount'] . ' €' . ' ( ' . Util::displayDateCompleteFromTimestampComplet($txn['txnDate']) . ' )'; ?></li>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <?php if ($key == 'winnings'): ?>
                        <b>Gains (Gain sur pari sportif) :</b>
                        <br /><br />
                        <?php foreach($value as $txn) :?>
                            <input type="hidden" name="winnings[<?php echo $txn['txnUUID'] ?>]" value="<?php echo $txn['txnUUID'] ?>" />
                            <input type="hidden" name="winnings" value="<?php echo $txn['txnUUID'] ?>" />
                            <input type="hidden" name="winningsKupId" value="<?php echo $txn['kupId'] ?>" />
                            <input type="hidden" name="winningsKupDescription" value="<?php echo $txn['kupName'] ?>" />
                            <input type="hidden" name="winningsKupEndDate" value="" />
                            <input type="hidden" name="winningsBeforeGain" value="<?php echo $txn['creditBefore'] ?>" />
                            <input type="hidden" name="winningsAfterGain" value="<?php echo $txn['creditAfter'] ?>" />
                            <input type="hidden" name="winningsGain" value="<?php echo $txn['txnAmount'] ?>" />
                            <input type="hidden" name="login" value="<?php echo $userEmail ?>" />
                            <li><?php echo 'Gain de ' . $txn['txnAmount'] . ' €' . ' ( ' . Util::displayDateCompleteFromTimestampComplet($txn['txnDate']) . ' )'; ?></li>
                        <?php endforeach ?>
                    <?php endif; ?>
				<?php endforeach;?>
				</ul>
			</div>
            <input type="hidden" name="login[accountEmail]" value="<?php echo $userEmail ?>" />
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function() {
        var isClick = false;

		var validateForm = function() {
            var button = $('.validate-popup');

            if(!isClick) {
                isClick = true;
                button.removeClass('ui-state-default').addClass('ui-state-disabled');

                var loading = '<span class="notification-loading-button" style="display: block; width: 16px; height: 16px; background: url(\'/image/default/button_loading.gif\')"></span>';
                button.parent().css('position', 'relative').prepend(loading);
                $('.notification-loading-button').css({
                    'position' : 'absolute',
                    'top' : '50%',
                    'left' : '81%',
                    'margin-top' : '-8px',
                    'margin-left' : '-8px',
                    'z-index' : '1000'
                });

                var serializedData = $('#accept_popup_form').serialize();

                var jxhr = $.ajax({
                        url: '<?php echo url_for(array('module' => 'account', 'action' => 'notificationsPopup'));?>',
                        type: 'post',
                        data: $.url.decode(serializedData) ,
                        dataType: 'text'
                    });

                jxhr.done(function(response) {
                    if(response == '202') {
                        $('#popup_accept_gain').dialog("close");
                    }
                });
            }

			return false;
		};

		$('#popup_accept_gain').dialog({
			autoOpen: true,
			closeOnEscape: false,
			draggable: false,
			modal: true,
			resizable: false,
			dialogClass: "mt",
			width: 575,
			height: 345,
			buttons: [{
	              	text: "<?php echo __('text_accept_notifications')?>",
                    class: "validate-popup",
	            	click: validateForm
	          	}
			],
			open: function() {
				$('a.ui-dialog-titlebar-close').remove();
			}
		});
	});
</script>
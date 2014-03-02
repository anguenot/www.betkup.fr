<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px; display: <?php echo ($display?'block':'none') ?>;" id="div_<?php echo $blocName ?>">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" style="vertical-align: middle;" height="28">
                <span style="font-family: Arial; font-size: 12px; <?php if ($bloc == 'gold' || $bloc == 'credit_amount'){echo 'font-weight: normal';}else{echo 'font-weight: bold';} ?>; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="<?php echo (isset($col2_align) ? $col2_align : 'center') ?>" height="28" valign="middle">
                <div id="<?php echo $blocName ?>_input" style="margin-left: 10px;">
                    <input type="<?php echo $blocType ?>"
                    id="<?php echo $blocName ?>"
                    name="<?php echo $bloc ?>[<?php echo $blocName ?>]"
                    value="<?php echo $blocValue ?>" class="formInputVarchar"
                    style="width: <?php echo $widthGadget ?>px; height: <?php echo $heightGadget ?>px;" <?php echo $option ?>
                    <?php echo (isset($maxlength)) ? 'maxlength="'.$maxlength.'"': ''?>
                    <?php if ($blocType == 'password' || $blocName == 'accountCity' || $blocName == 'accountBirthplace') { echo 'autocomplete="off"';}?>>
                </div>
            </td>
            <td align="left" height="28">
                <div style="width: <?php echo $width3 ?>px; margin-left: 15px;">
                    <?php if ( isset($blocHelp) ): ?>
                        <span class="help" style="display: none;" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
               </div>
            </td>
        </tr>
    </table>
</div>
<?php if($inArray) :?>
<div id="content-search-<?php echo $blocName; ?>-results" class="content-search-city-results">
</div>
<?php endif;?>

<?php if (isset($blocHelp) ): ?>
 <script type="text/javascript">
 $(function() {
     $("#<?php echo $blocName; ?>").bind('focus mouseenter', function() {
         $("#<?php echo $blocName; ?>_help").fadeIn(200);
     }).blur(function () {
         $("#<?php echo $blocName; ?>_help").fadeOut(200);
     }).mouseleave(function () {
         if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(200);}
     });

     if($.browser.msie && $.browser.version=="8.0") {
         $('.help').css('font-size','9px');
     }

    <?php if($inArray) :?>
    var authorizeBloc = null;

	if('<?php echo $blocName ?>' == 'accountBirthplace') {
        authorizeBloc = $('#accountBirthcountry');
	} else if('<?php echo $blocName ?>' == 'accountCity') {
        authorizeBloc = $('#accountCountry');
	}

    $('#<?php echo $blocName ?>').autoSuggest({
        "authorizeBloc" : authorizeBloc,
        "authorizeNeededValue" : 'FR',
        "search_url" : "<?php echo url_for('account/searchCity'); ?>",
        "blocName"   : "<?php echo $blocName ?>",
        "text_no_results" : "<?php echo __('text_register_no_results'); ?>"
    });
    <?php endif;?>
 });
</script>
 <?php endif ?>
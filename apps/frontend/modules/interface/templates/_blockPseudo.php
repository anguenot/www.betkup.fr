<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
<p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px;">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="<?php echo $width1 ?>" align="right" height="27px;">
            <span style="font-family: Arial; font-size: 12px; <?php if ($bloc == 'gold' || $bloc == 'credit_amount'){echo 'font-weight: normal';}else{echo 'font-weight: bold';} ?>; color: #6A6A69;"><?php echo $blocLegende ?></span>
		</td>
		<td width="10px;"></td>
		<td width="22px;" height="27px;" valign="middle">
		<div id="blockPseudoButtonLeft"
			style="height: 27px; width: 22px; background-image: url('/images/account/create/pseudoChoiceLeft.png'); background-repeat: no-repeat;"></div>
		</td>
		<td width="<?php echo $width2 ?>" align="right" height="27px;"
			valign="middle">
		<div id="<?php echo $blocName ?>_input"
			style="background-image: url('/images/account/create/pseudoChoiceBgInput.png'); background-repeat: no-repeat;">
		<input type="<?php echo $blocType ?>" id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" value="<?php echo $blocValue ?>" class="formInputVarcharPseudo" style="width: <?php echo $widthGadget ?>px; height: <?php echo $heightGadget ?>px;" <?php echo $option ?>>
		<input type="<?php echo $blocType ?>" id="<?php echo $blocName ?>_off" name="<?php echo $bloc ?>[<?php echo $blocName ?>_off]" value="<?php echo $blocValue ?>" class="formInputVarcharPseudo" style="width: <?php echo $widthGadget ?>px; height: <?php echo $heightGadget ?>px; display: none;" <?php echo $option ?>>
		<input type="<?php echo $blocType ?>" id="<?php echo $blocName ?>_off" name="<?php echo $bloc ?>[<?php echo $blocName ?>_off]" value="<?php echo $blocValue ?>" class="formInputVarcharPseudo" style="width: <?php echo $widthGadget ?>px; height: <?php echo $heightGadget ?>px; display: none;" <?php echo $option ?> placeholder="<?php echo __('interface_blockPseudo_input_placeholder_text'); ?>">
		</div>
		</td>
		<td width="23px;" height="27px;" valign="middle">
		<div id="blockPseudoButtonRight"
			style="height: 27px; width: 23px; background-image: url('/images/account/create/pseudoChoiceRight.png'); background-repeat: no-repeat;"></div>
		</td>
		<td align="left" height="28">
		<div style="width: <?php echo $width3 ?>px; margin-left: 15px;" ><?php if ( isset($blocHelp) ): ?>
		<span class="help" style="display: none;"
			id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span> <?php endif ?>
		<img id="<?php echo $blocName ?>_save"
			src="/images/interface/boutonSave_FR.png" border="0"
			class="widgetSave" alt="Save"> <img
			id="<?php echo $blocName ?>_cancel"
			src="/images/interface/boutonAnnuler_FR.png" border="0"
			class="widgetCancel" alt="Cancel"></div>
		</td>
	</tr>
</table>
</div>
<?php if (isset($blocHelp) ): ?>
<script type="text/javascript">
 $("#<?php echo $blocName; ?>").focus(function () {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).mouseenter(function () {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).blur(function () {
     $("#<?php echo $blocName; ?>_help").fadeOut(500);
}).mouseleave(function () {
	if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}
});
 $("#<?php echo $blocName; ?>_off").focus(function () {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).mouseenter(function () {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).blur(function () {
     $("#<?php echo $blocName; ?>_help").fadeOut(500);
}).mouseleave(function () {
	if ($("#<?php echo $blocName; ?>_off").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}
});
 </script>
<?php endif ?>
<script type="text/javascript">

$("#blockPseudoButtonLeft").css("cursor", "pointer");
$("#blockPseudoButtonRight").css("cursor", "pointer");

var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	})();


 $("#<?php echo $blocName ?>_input input:eq(0)").focus(function() {
     if($("#<?php echo $blocName ?>_input input:eq(0)").val()==''){
         var accountFirstname = $("#accountFirstname").val();
         var accountLastname = $("#accountLastname").val();
         $("#<?php echo $blocName ?>_input input:eq(0)").val(accountFirstname+' '+accountLastname.substr(0,1)+'.');
     };
	 $("#<?php echo $blocName ?>_input input:eq(0)").keyup();
 });

 $("#<?php echo $blocName ?>_input input:eq(1)").focus(function() {
     if($("#<?php echo $blocName ?>_input input:eq(1)").val()==''){
         var accountFirstname = $("#accountFirstname").val();
         var accountLastname = $("#accountLastname").val();
         $("#<?php echo $blocName ?>_input input:eq(1)").val(accountFirstname+' '+accountLastname);
     };
     $("#<?php echo $blocName ?>_input input:eq(1)").keyup();
 });

 $("#blockPseudoButtonLeft").click(function() {
	 if( $("#<?php echo $blocName ?>_input input:eq(0)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(0)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(1)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").show();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").focus();
	 }else if( $("#<?php echo $blocName ?>_input input:eq(1)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(0)").show();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(0)").focus();
		 $("#<?php echo $blocName ?>_input input:eq(1)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
	 }else if( $("#<?php echo $blocName ?>_input input:eq(2)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(0)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(1)").show();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(1)").focus();
		 $("#<?php echo $blocName ?>_input input:eq(2)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
	 }
 });

 $("#blockPseudoButtonRight").click(function() {
	 if( $("#<?php echo $blocName ?>_input input:eq(2)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(0)").show();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(0)").focus();
		 $("#<?php echo $blocName ?>_input input:eq(1)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
	 }else if( $("#<?php echo $blocName ?>_input input:eq(0)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(1)").show();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(1)").focus();
		 $("#<?php echo $blocName ?>_input input:eq(0)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
	 }else if( $("#<?php echo $blocName ?>_input input:eq(1)").is(':visible') ) {
		 $("#<?php echo $blocName ?>_input input:eq(1)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(1)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").show();
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('id','<?php echo $blocName ?>');
		 $("#<?php echo $blocName ?>_input input:eq(2)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>]');
		 $("#<?php echo $blocName ?>_input input:eq(2)").focus();
		 $("#<?php echo $blocName ?>_input input:eq(0)").hide();
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('id','<?php echo $blocName ?>_off');
		 $("#<?php echo $blocName ?>_input input:eq(0)").attr('name','<?php echo $bloc ?>[<?php echo $blocName ?>_off]');
	 }
 });

 $("#<?php echo $blocName ?>_input input:eq(0)").click(function() {
	 $("#<?php echo $blocName ?>_input input:eq(0)").focus();
	 $("#<?php echo $blocName ?>_input input:eq(0)").keyup();
 });

 $("#<?php echo $blocName ?>_input input:eq(1)").click(function() {
	 $("#<?php echo $blocName ?>_input input:eq(1)").focus();
	 $("#<?php echo $blocName ?>_input input:eq(1)").keyup();
 });

 var validFormat = new RegExp("^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$", "g");

 $("#<?php echo $blocName ?>_input input:eq(0)").keyup(function(event) {

	delay(function() {
		if($("#<?php echo $blocName ?>_input input:eq(0)").val().length >=5 ) {
			if(validFormat.test($("#<?php echo $blocName ?>_input input:eq(0)").val())) {
				if(isNicknameExist($("#<?php echo $blocName ?>_input input:eq(0)").val()) == 'false') {
	
					$("#<?php echo $blocName ?>_input input:eq(0)").removeClass("formInputVarcharErrorOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(0)").addClass("formInputVarcharSuccessOnlyTickerPseudo");
				} else {
					$("#<?php echo $blocName ?>_input input:eq(0)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(0)").addClass("formInputVarcharErrorOnlyTickerPseudo");
				}
			} else {
				$("#<?php echo $blocName ?>_input input:eq(0)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
				$("#<?php echo $blocName ?>_input input:eq(0)").addClass("formInputVarcharErrorOnlyTickerPseudo");
			}
		} else {
			$("#<?php echo $blocName ?>_input input:eq(0)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
			$("#<?php echo $blocName ?>_input input:eq(0)").addClass("formInputVarcharErrorOnlyTickerPseudo");
		}
	}, 1000);
 });

 $("#<?php echo $blocName ?>_input input:eq(1)").keyup(function(event) {
	 delay(function() {
		if($("#<?php echo $blocName ?>_input input:eq(1)").val().length >=5) {
			if(validFormat.test($("#<?php echo $blocName ?>_input input:eq(0)").val())) {
				if(isNicknameExist($("#<?php echo $blocName ?>_input input:eq(1)").val()) == false) {
	
					$("#<?php echo $blocName ?>_input input:eq(1)").removeClass("formInputVarcharErrorOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(1)").addClass("formInputVarcharSuccessOnlyTickerPseudo");
				} else {
					$("#<?php echo $blocName ?>_input input:eq(1)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(1)").addClass("formInputVarcharErrorOnlyTickerPseudo");
				}
			} else {
				$("#<?php echo $blocName ?>_input input:eq(1)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
				$("#<?php echo $blocName ?>_input input:eq(1)").addClass("formInputVarcharErrorOnlyTickerPseudo");
			}
		} else {
			$("#<?php echo $blocName ?>_input input:eq(1)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
			$("#<?php echo $blocName ?>_input input:eq(1)").addClass("formInputVarcharErrorOnlyTickerPseudo");
		}
	 }, 800);
 });

 $("#<?php echo $blocName ?>_input input:eq(2)").keyup(function(event) {
	 delay(function() {
	 	if($("#<?php echo $blocName ?>_input input:eq(2)").val().length >=5) {
	 		if(validFormat.test($("#<?php echo $blocName ?>_input input:eq(0)").val())) {
				if(isNicknameExist($("#<?php echo $blocName ?>_input input:eq(2)").val()) == false) {
	
					$("#<?php echo $blocName ?>_input input:eq(2)").removeClass("formInputVarcharErrorOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(2)").addClass("formInputVarcharSuccessOnlyTickerPseudo");
				} else {
					$("#<?php echo $blocName ?>_input input:eq(2)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
					$("#<?php echo $blocName ?>_input input:eq(2)").addClass("formInputVarcharErrorOnlyTickerPseudo");
				}
	 		} else {
	 			$("#<?php echo $blocName ?>_input input:eq(2)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
				$("#<?php echo $blocName ?>_input input:eq(2)").addClass("formInputVarcharErrorOnlyTickerPseudo");
	 		}
	 	}	else {
			$("#<?php echo $blocName ?>_input input:eq(2)").removeClass("formInputVarcharSuccessOnlyTickerPseudo");
			$("#<?php echo $blocName ?>_input input:eq(2)").addClass("formInputVarcharErrorOnlyTickerPseudo");
		}
	 }, 800);
 });

function isNicknameExist(nickname) {
		var response = false;
		var jxhr = $.ajax({
			type: 'post',
			async: false,
			url: '<?php echo url_for('account/existsNickname');?>',
			dataType: 'text',
			data: {accountPseudo: nickname},
			cache: false
		});

		jxhr.done(function(data) {
			response = data;
		});

		return response;
}
 </script>

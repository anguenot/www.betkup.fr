<div class="createAccountOnHome">
    <div style="height: 70px;"></div>
    <form name="formCreateAccount" id="formCreateAccount" method="post" action="<?php echo url_for(array('module' => 'account', 'action' => 'register')) ?>">

        <div style="text-align: left; margin-left: 25px; padding-bottom: 10px;">

            <label><?php echo $form['accountLastName']->render() ?></label><br/>
            <?php echo $form['accountLastName']->renderError() ?>

            <label><?php echo $form['accountFirstname']->render() ?></label><br/>
            <?php echo $form['accountFirstname']->renderError() ?>

            <label><?php echo $form['accountEmail']->render() ?></label><br/>
            <?php echo $form['accountEmail']->renderError() ?>

            <?php if (isset($messageError) && $messageError != ""): ?>
                <div align="center" style="margin-top: 5px; margin-bottom: 5px;">
                    <ul class="error_list">
                        <li><?php echo $messageError ?></li>
                    </ul>
                </div>
            <?php endif ?>

            <?php echo $form->renderHiddenFields(); ?>

        </div>

        <input type="image" src="/images/interface/boutonInscrireFleche_<?php echo $sf_user->getCulture() ?>.png" border="0">
    </form>
    <div align="center">
    	<div style="font-style: italic; padding: 6px;"><img src="/images/home/createAccount/ou_<?php echo strtolower($sf_user->getCulture()) ?>.png" alt="" style="border: none;" /></div>
    	<div>
    		<a style="" href="<?php echo url_for(array('module' => 'account', 'action' => 'loginFacebook')) ?>">
				<?php echo image_tag('facebook/connect.png', array('alt' => '', 'border' => '0', 'size' => '107x25')); ?>
			</a>
    	</div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $(".input-text").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });

    $(".input-text").blur(function(key) {
        $(".input-text").removeClass("formInputVarcharSelected");
    });
});
</script>
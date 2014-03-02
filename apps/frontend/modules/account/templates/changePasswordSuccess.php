<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <a name="toppage"></a>
    <div class="interface">
        <?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
        <div>
            <div class="interface_gauche">
                <div class="enteteGauche">
                    <p class="titre">
                        <?php echo image_tag('moncompte/titremoncompte_' . $sf_user->getCulture() . '.png', array('alt' => '', 'border' => '0', 'size' => '349x45')); ?>
                    </p>
                    <?php include_component('account', 'menu', array('ongletActif' => $ongletActif, 'labelsOnglets' => $labelsOnglets)) ?>
                </div>

                <div class="corpsGauche">

                    <div class="sommaire">
                        <ul>
                            <li><a href="#moncomptebetkup"><?php echo __('account_changePassword_corpsGauche_sommaire_text'); ?></a></li>
                        </ul>
                    </div>

                    <?php include_component('account', 'title', array('racine' => 'changepassword', 'altImg' => 'Mon compte Betkup')) ?>
                               
                    <div class="blocBlanc">

                        <form name="formChangePassword" id="formChangePassword" method="post" action="">

                            <div style="text-align: left; margin-left: 50px; margin-top: 20px;">
								<?php if($isNoPassword != 1) :?>
                                <?php
                                include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'changePassword',
                                    'width1' => '160',
                                    'width2' => '240',
                                    'width3' => '',
                                    'marginLeftError' => '400',
                                    'messageError' => __('account_changePassword_oldPassword_messageError_text'),
                                    'blocType' => 'password',
                                    'blocIcone' => '',
                                    'blocName' => 'oldPassword',
                                    'blocLegende' => __('account_changePassword_oldPassword_legende_text'),
                                    'blocValue' => ''))
                                ?>
								<?php endif;?>
                                <?php
                                include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'changePassword',
                                    'width1' => '160',
                                    'width2' => '240',
                                    'width3' => '',
                                    'marginLeftError' => '400',
                                    'messageError' => __('account_changePassword_newPassword_messageError_text'),
                                    'blocType' => 'password', 'blocIcone' => '',
                                    'blocName' => 'newPassword',
                                    'blocLegende' => __('account_changePassword_newPassword_legende_text'),
                                    'blocValue' => ''))
                                ?>

                                <?php
                                include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'changePassword',
                                    'width1' => '160',
                                    'width2' => '240',
                                    'width3' => '',
                                    'marginLeftError' => '400',
                                    'messageError' => __('account_changePassword_confirmationPassword_messageError_text'),
                                    'blocType' => 'password',
                                    'blocIcone' => '',
                                    'blocName' => 'confirmationPassword',
                                    'blocLegende' => __('account_changePassword_confirmationPassword_legende_text'),
                                    'blocValue' => ''))
                                ?>

                                <?php echo $form->renderHiddenFields(); ?>
                            </div>

                            <div align="left">
                                <div align="right" style="width: 478px;">
                                    <table border="0" cellpadding="0" cellspacing="20">
                                        <tr>
                                            <td>
                                                <!-- Link back -->
                                                <?php include_component('interface', 'buttonText', array('name' => 'Retour', 'href' => url_for(array('module' => 'account', 'action' => 'edit')))) ?>
                                            </td>
                                            <td>
                                                <?php echo image_tag('interface/button/confirmChangePassword_' . $sf_user->getCulture() . '.png', array('id' => 'buttonSubmit', 'alt' => __('account_changePassword_buttonSubmit_alt_text'), 'border' => '0', 'style' => 'cursor: pointer;')); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </form>



                        <p style="height: 300px;"></p>

                    </div>

                </div>

            </div>
            <div class="interface_droite">

                <p style="margin:10px;">
                </p>

            </div>
        </div>
        <div style="clear:both;"></div>

    </div>

</div>

<script type="text/javascript">
    
    function verifWidgetText(widget) {
        var valueInWidget = $("#"+widget).val();
        if ( valueInWidget == '' ) {
            $("#"+widget).addClass("formInputVarcharError");
            $("#"+widget+'_bulle').fadeIn('fast');
            $("#"+widget).focus();
            return(false);
        }
        return(true);
    }

    function hideMessageErrorFromWidget(widget, widgetName) {
        $(".formInputVarchar").removeClass("formInputVarcharError");
        $('#'+widgetName+'_bulle').fadeOut('fast');
    }

    $(".formInputVarchar").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });

    $(".formInputVarchar").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });

    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });

    $("#buttonSubmit").click(function(){

        var formValide = true;

        if ( !verifWidgetText('oldPassword') )
            return(false);
        
        if ( !verifWidgetText('newPassword') )
            return(false);
        
        if ( !verifWidgetText('confirmationPassword') )
            return(false);
        
        document.formChangePassword.submit();
        
    });

</script>
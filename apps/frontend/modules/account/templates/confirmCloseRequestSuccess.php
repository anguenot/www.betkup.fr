<div class="moncompte">
    <div class="moncompte_onglets_navigation">
        <a href="#" title="My Betkup">
            <?php echo image_tag('moncompte/button_mybetkup.png', array('alt' => 'My Betkup', 'border' => '0', 'size' => '163x57')); ?></a><a href="#" title="Kups">
            <?php echo image_tag('moncompte/button_kups.png', array('alt' => 'Kups', 'border' => '0', 'size' => '157x57')); ?></a><a href="#" title="Rooms">
            <?php echo image_tag('moncompte/button_rooms.png', array('alt' => 'Rooms', 'border' => '0', 'size' => '154x57')); ?></a><a href="#" title="Community">
            <?php echo image_tag('moncompte/button_community.png', array('alt' => 'Community', 'border' => '0', 'size' => '156x57')); ?></a>
    </div>
    <a id="toppage"></a>
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
                            <li><a href="#moncomptebetkup">Demande de clôture</a></li>
                        </ul>
                    </div>
                    <?php include_component('account', 'title', array('racine' => 'cloturermoncompte', 'altImg' => 'Clôturer mon compte')) ?>
                    <div class="blocBlanc">
                        <p style="width: 680px; margin: 20px; margin-top: 20px; margin-bottom: 20px;">
                           <?php echo __("label_account_confirm_close_1"); ?>
                           <?php echo __("label_account_confirm_close_2"); ?>
                        </p>
                        <div align="left">
                            <div align="right" style="width: 478px;">
                                <table>
                                    <tr>
                                        <td>
                                            <?php include_component('interface', 'buttonText', array('name' => 'Retour', 'href' => url_for(array('module' => 'account', 'action' => 'edit')))) ?>
                                        </td>
                                        <td>
                                             <form name="formCloseRequest" id="formCloseRequest" method="post"
                                                   action="<?php echo url_for(array('module' => 'account', 'action' => 'closeRequest')) ?>">
                                                <input type="hidden" name="credit" value="<?php echo $userCredit; ?>"/>
                                                <input type="hidden" name="email" value="<?php echo $userEmail; ?>"/>
                                                <input type="image"
                                                       src="<?php echo '/images/moncompte/btconfirmCloturer_' . $sf_user->getCulture() . '.png' ?>" />
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="interface_droite">
                <p style="margin:10px;"></p>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
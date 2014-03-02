<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <a name="toppage"></a>

    <div class="interface">
        <?php echo image_tag('moncompte/top.png', array(
                                                       'alt'  => '', 'border' => '0',
                                                       'size' => '990x4'
                                                  )); ?>
        <div>
            <div class="interface_gauche">
                <div class="enteteGauche">
                    <p class="titre">
                        <?php echo image_tag('moncompte/titremoncompte_' . $sf_user->getCulture() . '.png', array(
                                                                                                                 'alt'    => '',
                                                                                                                 'border' => '0',
                                                                                                                 'size'   => '349x45'
                                                                                                            )); ?>
                    </p>
                    <?php include_component('account', 'menu', array(
                                                                    'ongletActif'   => $ongletActif,
                                                                    'labelsOnglets' => $labelsOnglets
                                                               )) ?>
                </div>
                <div class="corpsGauche">
                    <div class="blocBlanc">
                        <div class="margeGauche">
                            <div style="height: 27px;"></div>
                            <h1 style="border: 0px;">
                                Solde du compte : <?php echo $member_credit ?>€
                            </h1>

                            <div style="height: 20px; clear: both; "></div>
                            <?php if ($sf_user->hasCredential('member_gambling_fr')) : ?>
                            <?php include_component('interface', 'accountGamblingButtons') ?>
                            <?php endif; ?>
                            <div style="height: 30px; clear: both; "></div>
                            <?php include_component('interface', 'tableau', array('datas' => $data)) ?>

                            <?php if ($sf_user->hasCredential('member_gambling_fr')) : ?>
                            <div style="height: 20px; clear: both; "></div>
                            <?php include_component('interface', 'accountGamblingButtons') ?>
                            <?php else : ?>
                            <div style="margin-top: 25px; margin-right: 20px;">
                                <p style="margin-bottom: 1em;">
                                    <b><?php echo __('account_tab_prediction_title'); ?></b></p>

                                <p><?php echo __('account_tab_prediction_text_1'); ?></p>

                                <p style="margin-bottom: 1em;"><?php echo __('account_tab_prediction_text_2'); ?></p>

                                <p style="margin-bottom: 1em;"><?php echo __('account_tab_prediction_text_3'); ?></p>

                                <p style="margin-bottom: 1em;"><?php echo __('account_tab_prediction_text_4'); ?></p>

                                <p class="rappel"><a href="<?php echo url_for(array(
                                                                                   'module'  => 'account',
                                                                                   'action'  => 'updateSimpleAccount'
                                                                              )) ?>"><?php echo __('open_account_complet_to_bet'); ?></a>
                                </p>
                            </div>
                            <?php endif; ?>
                            <div style="height: 40px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="interface_droite">
                <p style="margin: 10px;"></p>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
<?php if (sfConfig::get('app_profile') == 'free') : ?>
<script type="text/javascript">
    $(function () {
        $('a[href="<?php echo url_for(array(
                                           'module' => 'account', 'action'  => 'updateSimpleAccount'
                                      )) ?>"]').attr('title', '<?php echo addslashes(__('open_account_complet_to_bet'))?>');
        $('a[href="<?php echo url_for(array(
                                           'module' => 'account', 'action'  => 'updateSimpleAccount'
                                      )) ?>"]').tipsy({fade:true, gravity:'n'}).attr("href", "#");
    });
</script>
<?php endif; ?>
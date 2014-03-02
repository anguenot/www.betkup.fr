<form name="formCredit" id="formCredit" method="post" action="">

    <?php if ($daysRemaining > 0) : ?>
    <div id="credit-form-bonus">
        <p>
            <?php echo __('text_account_credit_bonnus_box', array(
                                                                 '%smaller%'        => '<span class="smaller">',
                                                                 '%/smaller%'       => '</span>',
                                                                 '%maxDay%'         => $maxDay,
                                                                 '%accountDate%'    => date('d/m/Y', $accountDate),
                                                                 '%green%'          => '<b class="green">',
                                                                 '%/green%'         => '</b>',
                                                                 '%daysRemaining%' => $daysRemaining,
                                                                 '%moreInfos%' => link_to(__('link_footer_know_more'), url_for(array('module' => 'challenge', 'action' => 'promos', 'uuid' => 'promos_bonus_l1_2012')), array('target' => '_blank', 'class' => 'more-infos'))
                                                            )) ?>
        </p>
    </div>
    <?php endif; ?>
    <div style="height: 14px;"></div>
    <div align="left" style="margin-left: 20px;">
        <?php
        include_component('interface', 'select', array(
                                                      'bloc'            => 'credit_select',
                                                      'width1'          => '295',
                                                      'width2'          => '140',
                                                      'width3'          => '230',
                                                      'marginLeftError' => '386',
                                                      'messageError'    => __('account_credit_amountCreditSelect_messageError_text'),
                                                      'blocType'        => 'text',
                                                      'blocIcone'       => '',
                                                      'blocName'        => 'amountCreditSelect',
                                                      'blocLegende'     => __('account_credit_amountCreditSelect_legende_text'),
                                                      'blocValue'       => '10',
                                                      'blocChoices'     => Data::getPreselectedCBAmount(),
                                                      'blocHelp'        => __('register_credit_select_amount_help_text', array(
                                                                                                                              '%bet_min%'  => sfConfig::get('mod_account_credit_min'),
                                                                                                                              '%bet_max%'  => sfConfig::get('mod_account_credit_max')
                                                                                                                         ))
                                                 ))
        ?>
        <div id="bockAmountCreditPerso" style="display: none;">
            <?php include_component('interface', 'simpleWidget', array(
                                                                      'bloc'            => 'credit_amount',
                                                                      'width1'          => '160',
                                                                      'width2'          => '30',
                                                                      'marginLeftError' => '400',
                                                                      'messageError'    => __('account_credit_amountCreditPerso_messageError_text'),
                                                                      'blocType'        => 'text',
                                                                      'blocIcone'       => '',
                                                                      'blocName'        => 'amountCreditPerso',
                                                                      'blocLegende'     => __('account_credit_amountCreditPerso_legend_text'),
                                                                      'blocValue'       => $credit_amountCreditPerso,
                                                                      'blocHelp'        => __('register_credit_amount_perso_help_text')
                                                                 )) ?>
        </div>
        <?php
        include_component('interface', 'simpleWidget', array(
                                                            'bloc'            => 'credit',
                                                            'width1'          => '160',
                                                            'width2'          => '240',
                                                            'marginLeftError' => '400',
                                                            'messageError'    => __('account_credit_cardnumber_messageError_text'),
                                                            'blocType'        => 'text',
                                                            'blocIcone'       => '',
                                                            'blocName'        => 'cardnumber',
                                                            'blocLegende'     => __('NUMERO CARTE'),
                                                            'blocValue'       => $credit_card_digits,
                                                            'blocHelp'        => __('register_credit_numero_carte_help_text')
                                                       )) ?>

        <?php
        include_component('interface', 'cbExpiration', array(
                                                            'bloc'            => 'credit',
                                                            'width1'          => '160',
                                                            'width2'          => '240',
                                                            'marginLeftError' => '400',
                                                            'messageError'    => '',
                                                            'blocName'        => 'expiration',
                                                            'blocLegende'     => __('account_credit_expiration_legend_text'),
                                                            'blocChoices2'    => Util::getCBExpirationMonths(),
                                                            'blocChoices3'    => Util::getCBExpirationYears(),
                                                            'blocValue2'      => $credit_card_expire_2,
                                                            'blocValue3'      => $credit_card_expire_3,
                                                            'blocHelp'        => __('register_credit_expiration_date_help_text')
                                                       )) ?>

        <?php
        include_component('interface', 'simpleWidget', array(
                                                            'bloc'            => 'credit',
                                                            'width1'          => '160',
                                                            'width2'          => '240',
                                                            'marginLeftError' => '400',
                                                            'messageError'    => __('account_credit_crypto_messageError_text'),
                                                            'blocType'        => 'text',
                                                            'blocIcone'       => '',
                                                            'blocName'        => 'crypto',
                                                            'blocLegende'     => __('account_credit_crypto_legend_text'),
                                                            'blocValue'       => $credit_card_crypto,
                                                            'blocHelp'        => __('register_credit_crypto_help_text')
                                                       ))
        ?>


    </div>
    <input type="hidden" name="creditBefore" value="<?php echo $userCreditBefore; ?>"/>
    <input type="hidden" name="email" value="<?php echo $userEmail; ?>"/>
</form>
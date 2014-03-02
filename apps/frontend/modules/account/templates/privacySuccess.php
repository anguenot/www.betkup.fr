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
                    <div class="sommaire">
                        <ul>
                            <li><a href="#moncomptefacebook">Connexion à mon compte Facebook</a>
                            </li>
                            <li><a href="#mesnotifications">Mes notifications</a></li>
                        </ul>
                    </div>
                    <?php include_component('account', 'title', array(
                                                                     'racine'  => 'moncomptefacebook',
                                                                     'altImg'  => 'Mes notifications'
                                                                )) ?>

                    <div style="margin-left: 42px;">


                        <?php if ($sf_user->getAttribute('facebookId', '', 'subscriber') != '') : ?>
                        <?php include_component('interface', 'accountFacebookLinked') ?>
                        <?php endif ?>
                        <?php if ($sf_user->getAttribute('facebookId', '', 'subscriber') == '') : ?>
                        <?php include_component('interface', 'accountFacebookNolink') ?>
                        <?php endif ?>
                    </div>

                    <?php include_component('account', 'title', array(
                                                                     'racine'  => 'mesnotifications',
                                                                     'altImg'  => 'Mes notifications'
                                                                )) ?>
                    <div class="blocBlanc">

                        <div class="margeGauche">

                            <div class="texte" style="width: 650px;">
                                Vous souhaitez être au courant des dernières news et Kups Betkup ?
                                En la matière l'email reste l'outil le plus efficace. Nous avons
                                donc prévu de vous envoyer des notifications par email, du coup vous
                                êtes par défault abonné à la newsletter.
                            </div>
                            <div style="height: 25px;">
                                <div style="width: 100%; text-align: center;">

                                    <a class="orange" style="font-size: 12px; display: inline-block;" href="http://sofungaming.us1.list-manage.com/unsubscribe?u=2b6fe80bc042ea1bfc7daf2f8&id=4cf0f0bebe" target="_blank">
                                        Se désabonner de la newsletter
                                    </a>
                                    <div style="width: 20px; display: inline-block;"></div>
                                    <a class="orange" style="font-size: 12px; display: inline-block;" href="http://eepurl.com/hxCuo" target="_blank">
                                        S'abonner à la newsletter
                                    </a>
                                </div>
                                <!--
							<form name="formPrivacyNotif" id="formPrivacyNotif"
								method="post"
								action="<?php echo url_for(array(
                                                                'module'  => 'account',
                                                                'action'  => 'privacy'
                                                           )) ?>">
								<div style="height: 4px;"></div>

								<div class="texte" style="width: 600px;">
								<?php echo __('label_privacy_notification_introduction_text_1') ?>
									<br /> <br />
									<?php echo __('label_privacy_notification_introduction_text_2') ?>
									<br /> <br />
									<?php echo __('label_privacy_notification_introduction_text_3') ?>
								</div>
								<h1>
								<?php echo __('label_form_privacy_notification_participate_kup_title') ?>
								</h1>
								<div style="margin-bottom: 25px;">
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'KUP_FRIEND_PARTICIPATE',
                                                                                    'legende' => __('label_form_privacy_notification_friend_participate'),
                                                                                    'checked' => isset($notification_scheme['KUP_FRIEND_PARTICIPATE']) ? $notification_scheme['KUP_FRIEND_PARTICIPATE'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'KUP_NEW_RESULTS',
                                                                                    'legende' => __('label_form_privacy_notification_each_new_result'),
                                                                                    'checked' => isset($notification_scheme['KUP_NEW_RESULTS']) ? $notification_scheme['KUP_NEW_RESULTS'] : 'false'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'KUP_PREDICTION_REMINDER',
                                                                                    'legende' => __('label_form_privacy_notification_alert_prono_each_round'),
                                                                                    'checked' => isset($notification_scheme['KUP_PREDICTION_REMINDER']) ? $notification_scheme['KUP_PREDICTION_REMINDER'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'KUP_RANKING_UPDATED',
                                                                                    'legende' => __('label_form_privacy_notification_change_ranking'),
                                                                                    'checked' => isset($notification_scheme['KUP_RANKING_UPDATED']) ? $notification_scheme['KUP_RANKING_UPDATED'] : 'false'
                                                                               )) ?>
								</div>
								<h1>
								<?php echo __('label_form_privacy_notification_admin_room_title') ?>
								</h1>
								<div style="margin-bottom: 25px;">
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'TEAM_ADMIN_INVITE_ACCEPTED',
                                                                                    'legende' => __('label_form_privacy_notification_invitation_accept'),
                                                                                    'checked' => isset($notification_scheme['TEAM_ADMIN_INVITE_ACCEPTED']) ? $notification_scheme['TEAM_ADMIN_INVITE_ACCEPTED'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'TEAM_ADMIN_MEMBER_JOINED',
                                                                                    'legende' => __('label_form_privacy_notification_player_join_room'),
                                                                                    'checked' => isset($notification_scheme['TEAM_ADMIN_MEMBER_JOINED']) ? $notification_scheme['TEAM_ADMIN_MEMBER_JOINED'] : 'false'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'TEAM_ADMIN_NEW_COMMENT',
                                                                                    'legende' => __('label_form_privacy_notification_comment_post'),
                                                                                    'checked' => isset($notification_scheme['TEAM_ADMIN_NEW_COMMENT']) ? $notification_scheme['TEAM_ADMIN_NEW_COMMENT'] : 'false'
                                                                               )) ?>
								</div>
								<h1>
								<?php echo __('label_form_privacy_notification_membre_room_title') ?>
								</h1>
								<div style="margin-bottom: 25px;">
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'TEAM_MEMBER_NEW_KUP',
                                                                                    'legende' => __('label_form_privacy_notification_new_kup_activated'),
                                                                                    'checked' => isset($notification_scheme['TEAM_MEMBER_NEW_KUP']) ? $notification_scheme['TEAM_MEMBER_NEW_KUP'] : 'true'
                                                                               )) ?>
								</div>
								<h1>
								<?php echo __('label_form_privacy_notification_news_actu_title') ?>
								</h1>
								<div style="margin-bottom: 25px;">
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'BETKUP_NEW_KUP',
                                                                                    'legende' => __('label_form_privacy_notification_new_official_kup'),
                                                                                    'checked' => isset($notification_scheme['BETKUP_NEW_KUP']) ? $notification_scheme['BETKUP_NEW_KUP'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'BETKUP_NEW_TEAM',
                                                                                    'legende' => __('label_form_privacy_notification_new_official_room'),
                                                                                    'checked' => isset($notification_scheme['BETKUP_NEW_TEAM']) ? $notification_scheme['BETKUP_NEW_TEAM'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'BETKUP_NEWSLETTER',
                                                                                    'legende' => __('label_form_privacy_notification_newsletter_betkup'),
                                                                                    'checked' => isset($notification_scheme['BETKUP_NEWSLETTER']) ? $notification_scheme['BETKUP_NEWSLETTER'] : 'true'
                                                                               )) ?>
								<?php include_component('account', 'checkbox', array(
                                                                                    'name'    => 'BETKUP_PARTNERS_NEWSLETTER',
                                                                                    'legende' => __('label_form_privacy_notification_newsletter_partners'),
                                                                                    'checked' => isset($notification_scheme['BETKUP_PARTNERS_NEWSLETTER']) ? $notification_scheme['BETKUP_PARTNERS_NEWSLETTER'] : 'false'
                                                                               )) ?>
								</div>
								<div style="width: 580px; padding-top: 11px;" align="center">
									<input type="image" name="submit" src="/images/interface/boutonSave2_FR.png" border="0" alt="save">
								</div>
								<div style="height: 10px;"></div>
							</form>
                            -->
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
</div>

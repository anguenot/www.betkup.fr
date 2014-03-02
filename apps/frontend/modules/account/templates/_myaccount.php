<?php include_component('interface', 'widget', array(
                                                    'blocType'    => 'text',
                                                    'blocIcone'   => 'crayon',
                                                    'blocName'    => 'monComptePseudo',
                                                    'blocLegende' => 'PSEUDO',
                                                    'blocValue'   => $monComptePseudo
                                               )) ?>


<form name="form_my_account_avatar" action="" id="form_my_account_avatar" method="post" enctype="multipart/form-data">
    <?php include_component('interface', 'widgetDownload', array(
                                                                'bloc'            => 'my_account',
                                                                'width1'          => '222',
                                                                'width2'          => '230',
                                                                'col2_align'      => 'center',
                                                                'marginLeftError' => '400',
                                                                'messageError'    => __('label_form_create_account_avatar_error'),
                                                                'blocType'        => 'file',
                                                                'blocName'        => 'my_avatar',
                                                                'blocLegende'     => 'AVATAR',
                                                                'blocValue'       => $sf_user->getAttribute('avatar', '', 'subscriber'),
                                                                'blocHelp'        => __('label_form_create_account_avatar_legend'),
                                                                'displayHelp'     => false,
                                                                'formId'          => 'form_my_account_avatar',
                                                                'img_width'       => '150',
                                                                'img_height'      => '150',
                                                                'uploadName'      => $sf_user->getAttribute('subscriberId', '', 'subscriber') .'_avatar_'. time() .'.png',
                                                                'uploadPath'      => '/uploads/assets/',
                                                                'withThumb'       => false
                                                           )) ?>
</form>

<?php /*include_component('interface', 'avatar', array(
                                                    'blocIcone'   => 'crayon',
                                                    'blocName'    => 'monCompteAvatar',
                                                    'blocLegende' => 'AVATAR',
                                                    'blocValue' => ''
                                               ))*/
?>

<a class="account-button" href="<?php echo url_for(array(
                                                        'module' => 'account',
                                                        'action' => 'changePassword'
                                                   )) ?>">
    <?php echo __('Modifier mon mot de passe') ?>
</a>
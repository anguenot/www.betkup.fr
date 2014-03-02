<?php

/**
 * Betkup forms.
 *
 * @package    betkup.fr
 * @subpackage form
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: BaseForm.class.php 3669 2012-01-30 15:02:17Z jmasmejean $
 */
class BaseForm extends sfFormSymfony {

}

class ConnexionForm extends sfFormSymfony {

    public function configure() {

    	$max_year = date("Y") - sfConfig::get('mod_account_registration_simple_age') + 1;
    	$min_year = date("Y") - 77;

        $years = range($min_year, $max_year);
        $years = array_reverse($years);

        $this->setWidgets(array(
            'email' => new sfWidgetFormInput(array(), array('class' => 'input-text-popup')),
            'password' => new sfWidgetFormInputPassword(array(), array('class' => 'input-text-popup')),
            'birthdate' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%', 'years' => array_combine($years, $years)), array('class' => 'formInputSelect')),
        ));

        $this->widgetSchema->setNameFormat('connexion[%s]');
        
        $this->widgetSchema->setLabel('email', 'E-MAIL');
        $this->widgetSchema->setLabel('password', 'MOT DE PASSE');
        $this->widgetSchema->setLabel('birthdate', 'DATE DE NAISSANCE');
        $this->widgetSchema->setFormFormatterName('list');
        
        $this->setValidators(array(
            'email' => new sfValidatorEmail(
                    array('required' => true),
                    array(
                        'required' => "Email is required",
                        'invalid' => "Votre Email n'est pas correct, veuillez en fournir un autre."
                    )
            ),
            'password' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide a password.')
            ),
            'birthdate' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide your birthdate.')
            ),
        ));
    }

}

class ConnexionFormLogin extends sfFormSymfony {

    public function configure() {

    	$max_year = date("Y") - sfConfig::get('mod_account_registration_simple_age') + 1;
    	$min_year = date("Y") - 77;

        $years = range($min_year, $max_year);
        $years = array_reverse($years);

        $this->setWidgets(array(
            'email' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
            'password' => new sfWidgetFormInputPassword(array(), array('class' => 'input-text')),
            'birthdate' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%', 'years' => array_combine($years, $years)), array('class' => 'formInputSelect')),
        ));

        $this->widgetSchema->setNameFormat('connexionLogin[%s]');

        $this->widgetSchema->setLabel('email', 'E-MAIL');
        $this->widgetSchema->setLabel('password', 'MOT DE PASSE');
        $this->widgetSchema->setLabel('birthdate', 'DATE DE NAISSANCE');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'email' => new sfValidatorEmail(
                    array('required' => true),
                    array(
                        'required' => "Email is required",
                        'invalid' => "Votre Email n'est pas correct, veuillez en fournir un autre."
                    )
            ),
            'password' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide a password.')
            ),
            'birthdate' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide your birthdate.')
            ),
        ));
    }

}

class ForgottenForm extends sfFormSymfony {

    public function configure() {

        $this->setWidgets(array(
            'email' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
        ));

        $this->widgetSchema->setNameFormat('connexion[%s]');

        $this->widgetSchema->setLabel('email', 'VOTRE EMAIL');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'password' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide a password.')
            ),
        ));
    }

}

class ResetpasswdForm extends sfFormSymfony {

    public function configure() {

        $this->setWidgets(array(
            'passwd' => new sfWidgetFormInputPassword(array(), array('class' => 'input-text')),
            'confirmation' => new sfWidgetFormInputPassword(array(), array('class' => 'input-text')),
        ));

        $this->widgetSchema->setNameFormat('connexion[%s]');

        $this->widgetSchema->setLabel('passwd', 'NOUVEAU MOT DE PASSE');
        $this->widgetSchema->setLabel('confirmation', 'CONFIRMATION');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'passwd' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the new password.')
            ),
            'confirmation' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the confirmation.')
            ),
        ));
    }

}

class CreateForm extends sfFormSymfony {

    public function configure() {

        $this->setWidgets(array(
            'accountLastName' => new sfWidgetFormInput(array(), array('class' => 'input-text', 'value' => __('Nom'))),
            'accountFirstname' => new sfWidgetFormInput(array(), array('class' => 'input-text', 'value' => __('Pr??nom'))),
            'accountEmail' => new sfWidgetFormInput(array(), array('class' => 'input-text', 'value' => __('E-mail'))),
        ));

        $this->widgetSchema->setNameFormat('information[%s]');

        $this->widgetSchema->setLabel('accountLastName', 'VOTRE NOM');
        $this->widgetSchema->setLabel('accountFirstname', 'VOTRE PRENOM');
        $this->widgetSchema->setLabel('accountEmail', 'VOTRE EMAIL');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'accountLastName' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide a lastname.')
            ),
            'accountFirstname' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide a firstname.')
            ),
            'accountEmail' => new sfValidatorEmail(
                    array('required' => true),
                    array(
                        'required' => "Email is required",
                        'invalid' => "Votre Email n'est pas correct, veuillez en fournir un autre."
                    )
            ),
        ));

    }

}

class ChangePasswordForm extends sfFormSymfony {

    public function configure() {

        $this->setWidgets(array(
            'oldPassword' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
            'newPassword' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
            'confirmationPassword' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
        ));

        $this->widgetSchema->setNameFormat('changePassword[%s]');
        
        $this->widgetSchema->setLabel('oldPassword', 'Ancien mot de passe');
        $this->widgetSchema->setLabel('newPassword', 'Nouveau mot de passe');
        $this->widgetSchema->setLabel('confirmationPassword', 'Confirmation');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'oldPassword' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the old password.')
            ),
            'newPassword' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the new password.')
            ),
            'confirmationPassword' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the confirmation.')
            ),
        ));

    }
}

class ChangePasswordFormFacebook extends sfFormSymfony {

    public function configure() {

        $this->setWidgets(array(
            'newPassword' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
            'confirmationPassword' => new sfWidgetFormInput(array(), array('class' => 'input-text')),
        ));

        $this->widgetSchema->setNameFormat('changePassword[%s]');
        
        $this->widgetSchema->setLabel('newPassword', 'Mot de passe');
        $this->widgetSchema->setLabel('confirmationPassword', 'Confirmation');
        $this->widgetSchema->setFormFormatterName('list');

        $this->setValidators(array(
            'newPassword' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the new password.')
            ),
            'confirmationPassword' => new sfValidatorString(
                    array('required' => true),
                    array('required' => 'Please provide the confirmation.')
            ),
        ));

    }
}

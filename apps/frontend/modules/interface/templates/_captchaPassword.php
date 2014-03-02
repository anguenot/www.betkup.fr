<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -18px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">
        <?php echo $messageError ?>
    </p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="left" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;">
                    <?php echo $blocLegende ?>
                </span>
            </td>
            </tr>
            <tr>
            <td width="<?php echo $width2 ?>" align="left" height="28" valign="middle">
                <div id="<?php echo $blocName ?>_input">
                    <script>
                        var RecaptchaOptions = {
                            theme : 'white',
                            lang : 'fr'
                        };
                    </script>
                    <?php
                    $publickey = sfConfig::get('app_recaptcha_public_key');
                    $privatekey = sfConfig::get('app_recaptcha_private_key');

                    # the response from reCAPTCHA
                    $resp = null;

                    # the error code from reCAPTCHA, if any
                    $error = null;

                    # was there a reCAPTCHA response?
                    if (isset($recaptcha_response_field)) {

                        $resp = recaptcha_check_answer($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

                        if ($resp->is_valid) {
                            echo "You got it!";
                        } else {
                            # set the error code so that we can display it
                            $error = $resp->error;
                        }
                    }
                    echo recaptcha_get_html($publickey, $error, true);
                    ?>
                </div>
            </td>
        </tr>
    </table>
</div>




<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width ?>" align="right" height="28" valign="top">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="252" align="center" height="28" valign="top">

                <div id="<?php echo $blocName ?>_input" style="position: relative; margin-left: 10px; <?php echo ($blocIcone != "") ? 'display: none;' : '' ?>">

                    <form name="form_<?php echo $blocName ?>" id="form_<?php echo $blocName ?>" method="post" action="" enctype="multipart/form-data">
                        <input type="file" id="<?php echo $blocName ?>_gadget" name="<?php echo $blocName ?>" value="<?php echo $blocValue ?>" style="padding-left: 7px; font-family: Arial; font-size: 12px; font-weight: normal; text-decoration: none; color: #8A8A8A; background-color: #F4F4F4; width: 224px; height: 24px; border-top: 2px solid #F5C95B; border-left: 2px solid #F5C95B; border-right: 2px solid #F4DA96; border-bottom: 2px solid #F4DA96;">
                    </form>
                </div>
                <?php if ($avatar != ""): ?>
                <?php include_component('interface', 'userAvatar', array(
                                                                        'avatarPath' => $avatar,
                                                                        'canvasSize' => '150x150',
                                                                        'style'      => 'border: 8px solid #F4F4F4;-webkit-box-shadow:  0px 0px 5px 0px rgba(0, 0, 0, 0.4);box-shadow:  0px 0px 5px 0px rgba(0, 0, 0, 0.4);'
                                                                   )) ?>
                <?php endif ?>

                <div id="<?php echo $blocName ?>_txt" class="<?php echo $blocName ?>_crayon" style="width: 230px; float: left; margin-left: 20px; line-height: 25px; height: 25px; cursor: pointer;">
                    <span id="<?php echo $blocName ?>_span" style="line-height: 28px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;"><?php echo $blocValue ?></span>
                </div>

            </td>
            <td align="left" height="28" valign="top">
                <div>
                    <?php if ($blocIcone == "crayon"): ?>
                    <img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/crayon.png" border="0" style="cursor: pointer;" alt="Editer">
                    <?php else: ?>
                    <?php if ($blocIcone == "cadenas"): ?>
                        <img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/cadenas.png" border="0" style="cursor: pointer;" alt="Locked">
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div style="width: 200px;">
                    <?php if (isset($blocHelp)): ?>
                    <span class="help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                    <img id="<?php echo $blocName ?>_save" src="/images/interface/boutonSave_FR.png" border="0" class="widgetSave" alt="Save">
                    <img id="<?php echo $blocName ?>_cancel" src="/images/interface/boutonAnnuler_FR.png" border="0" class="widgetCancel" alt="Cancel">
                </div>
            </td>
        </tr>
    </table>
</div>

<?php if ($blocIcone == "crayon"): ?>

<script type="text/javascript">

    $(".<?php echo $blocName ?>_crayon").hover(function () {
        $('#<?php echo $blocName ?>_img').attr("src", "/images/interface/crayonOn.png");
    });

    $(".<?php echo $blocName ?>_crayonClik").hover(function () {
        $('#<?php echo $blocName ?>_img').attr("src", "/images/interface/crayonClick.png");
    });

    $(".<?php echo $blocName ?>_crayon").mouseleave(function () {
        $('#<?php echo $blocName ?>_img').attr("src", "/images/interface/crayon.png");
    });

    $(".<?php echo $blocName ?>_crayonClik").mouseleave(function () {
        $('#<?php echo $blocName ?>_img').attr("src", "/images/interface/crayon.png");
    });

    $(".<?php echo $blocName ?>_crayonClik").click(function () {
        $('#<?php echo $blocName ?>_span').fadeOut('fast', function () {
            $('#<?php echo $blocName ?>_input').fadeIn('fast');
        });
        $('#<?php echo $blocName ?>_img').fadeOut('fast', function () {
            $('#<?php echo $blocName ?>_save').fadeIn('fast', function () {
                $('#<?php echo $blocName ?>_cancel').fadeIn('fast');
            });
        });
    });

    $("#<?php echo $blocName ?>_cancel").click(function () {

        // On fait disparaitre le input pour faire apparaitre le texte
        $('#<?php echo $blocName ?>_input').fadeOut('fast', function () {
            $('#<?php echo $blocName ?>_span').fadeIn('fast');
        });

        // On cache les 2 boutons
        $('#<?php echo $blocName ?>_cancel').fadeOut('fast', function () {
            $('#<?php echo $blocName ?>_save').fadeOut('fast', function () {
                $('#<?php echo $blocName ?>_img').fadeIn('fast');
            });
        });

    });

    $("#<?php echo $blocName ?>_img").click(function () {
        //$("#<?php echo $blocName ?>_txt").css({ "background-color": "red" });
        //$("#<?php echo $blocName ?>_txt").css({ "color": "black" });
    });

    // On enregistre
    $("#<?php echo $blocName ?>_save").click(function () {

        if (document.getElementById('<?php echo $blocName ?>_gadget').value == '') {
            // Le champ est vide, on affiche une bulle d'erreur
            $("#<?php echo $blocName ?>_gadget").css({ "border-top":"2px solid #e6332b" });
            $("#<?php echo $blocName ?>_gadget").css({ "border-left":"2px solid #e6332b" });
            $("#<?php echo $blocName ?>_gadget").css({ "border-bottom":"2px solid #ec807b" });
            $("#<?php echo $blocName ?>_gadget").css({ "border-right":"2px solid #ec807b" });

            $('#<?php echo $blocName ?>_bulle').fadeIn('fast');
        }
        else {
            $('#form_<?php echo $blocName ?>').submit();
        }

    });

    $("#<?php echo $blocName ?>_gadget").click(function () {
        $("#<?php echo $blocName ?>_gadget").css({ "border-top":"2px solid #F5C95B" });
        $("#<?php echo $blocName ?>_gadget").css({ "border-left":"2px solid #F5C95B" });
        $("#<?php echo $blocName ?>_gadget").css({ "border-bottom":"2px solid #F4DA96" });
        $("#<?php echo $blocName ?>_gadget").css({ "border-right":"2px solid #F4DA96" });
        $('#<?php echo $blocName ?>_bulle').fadeOut('fast');
    });

</script>

<?php endif ?>
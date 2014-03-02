<?php use_javascript('ajaxfileupload.js') ?>
<?php use_stylesheet('fancybox.css', 'first') ?>
<?php use_javascript('jquery.fancybox.js') ?>
<?php use_javascript('jquery.Jcrop.min.js') ?>
<?php use_stylesheet('widgetdownload.css', 'first') ?>
<?php use_stylesheet('jcrop.css', 'first') ?>

<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div id="<?php echo $blocName ?>_contener" style="margin-top: 4px; margin-bottom: 19px;">
    <table class="widget-download-table" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: <?php echo isset($width1) ? $width1 . 'px' : 'auto' ?>; text-align: right;">
                <span style="font-family: Arial; font-size: 12px; <?php echo ($bloc == 'gold' ? 'font-weight: normal;' : 'font-weight: bold;') ?> color: #6A6A69;">
                    <?php echo $blocLegende ?>
                </span>
            </td>
            <td width="<?php echo $width2 ?>" align="<?php echo $col2_align ?>" height="28">
                <div id="<?php echo $blocName ?>_input" style="margin-left: 15px;">
                    <div id="file-image-container">
                        <div class="modal-progress"></div>
                        <div id="file-progress-bar">
                            <div class="progress">
                                <div class="bar"></div>
                                <div class="percent">0%</div>
                            </div>
                        </div>
                        <?php if ($blocValue != ''): ?>
                        <img id="img_upload" style="padding: 10px; border: 1px solid #d0d0d0; margin-bottom: 10px;" src="<?php echo $blocValue ?>" border="0" width="<?php echo $img_width ?>" height="<?php echo $img_height ?>"/>
                        <?php endif ?>
                    </div>
                    <div class="upload">
                        <input type="file" onchange="ajaxFileUpload();" id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" value="<?php echo $blocValue ?>" class="upload_file">

                        <div class="fakefile">
		                	<span>
		                	<?php echo __('text_widget_download_choose_image')?>
		                	</span>
                        </div>
                    </div>
                </div>
            </td>
            <td align="left" height="28" valign="top">
                <div style="<?php echo 'width:' . $width3 . 'px;' ?> margin-left: 15px;">
                    <?php if (isset($blocHelp)): ?>
                    <span class="help" style="display: none;" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                    <img id="<?php echo $blocName ?>_save" src="/images/interface/boutonSave_FR.png" border="0" class="widgetSave" alt="Save">
                    <img id="<?php echo $blocName ?>_cancel" src="/images/interface/boutonAnnuler_FR.png" border="0" class="widgetCancel" alt="Cancel">
                </div>
            </td>
        </tr>
    </table>
</div>
<div style="display: none">
    <input type="hidden" value="<?php echo $blocValue ?>" name="<?php echo $bloc ?>[path_to_picture]" id="path_to_picture"/>
    <input type="hidden" value="" name="<?php echo $bloc ?>[path_to_thumb]" id="path_to_thumb"/>
    <input type="hidden" value="" name="<?php echo $bloc ?>[picture_name]" id="picture_name"/>
    <input type="hidden" value="" name="<?php echo $bloc ?>[thumb_name]" id="thumb_name"/>
    <input type="hidden" value="<?php echo $img_width ?>" name="min_width" id="min_width"/>
    <input type="hidden" value="<?php echo $img_height ?>" name="min_height" id="min_height"/>
    <input type="hidden" value="<?php echo $uploadPath ?>" name="upload_path" id="upload_path"/>
    <input type="hidden" value="<?php echo $uploadName ?>" name="upload_name" id="upload_name"/>
    <input type="hidden" value="<?php echo $bloc ?>" name="temp_file_index" id="temp_file_index"/>
    <input type="hidden" value="<?php echo $blocName ?>" name="temp_file_name" id="temp_file_name"/>
    <input type="hidden" value="<?php echo $withThumb ?>" name="with_thumb" id="withThumb"/>
    <input type="hidden" value="<?php echo $formId ?>" name="formId" id="formId" />
</div>
<a id="fancy-link" href="#data"></a>
<div style="display:none" id="content-fancy-link">
    <div id="data"></div>
</div>

<script type="text/javascript">
    $(function () {

        if ($.browser.msie) {
            var msg = '<p class="msg-ie"><?php echo __('text_upload_file_message_ie')?></p>';
            $('.upload').after(msg);
        }

    <?php if (isset($blocHelp) && !$displayHelp): ?>

            $("#<?php echo $blocName; ?>_contener").hover(function () {
                $("#<?php echo $blocName; ?>_help").fadeIn(500);
            }, function () {
                if ($("#<?php echo $blocName; ?>").is(":focus")) {
                } else {
                    $("#<?php echo $blocName; ?>_help").fadeOut(500);
                }
            });
            <?php endif ?>

        $('a#fancy-link').fancybox({
            type:'inline',
            width:1080,
            height:800,
            padding:0,
            margin:0,
            opacity:true,
            autoDimensions:true,
            enableEscapeButton:false,
            hideOnOverlayClick:false,
            hideOnContentClick:false,
            onClosed:function () {
                $('#img_upload').attr('src', $('#path_to_picture').val());
            }
        });
    });

    function ajaxFileUpload() {
        var oldAction = $('#<?php echo $formId?>').attr('action');
        $('#<?php echo $formId?>').attr('action', '<?php echo url_for('room/uploadFile')?>');

        var bar = $('.bar'), percent = $('.percent'), percentVal;
        $.fancybox.showActivity();

        $('#<?php echo $formId?>').ajaxSubmit({
            beforeSend:function () {
                percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);

                $('#file-progress-bar').show();
                $('.modal-progress', $('#file-image-container')).show();

            }, uploadProgress:function (event, position, total, percentComplete) {
                percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                console.log(percentVal);
            },
            success:function (xhr) {
                $('#<?php echo $formId?>').attr('action', oldAction);
                $('#file-progress-bar').hide();
                $('.modal-progress', $('#file-image-container')).hide();

                if ($.browser.msie) {
                    xhr = xhr.replace(/(<([^>]+)>)/ig, "");
                    xhr = html_entity_decode(xhr);
                }

                $('#data', $('#content-fancy-link')).html(xhr);
                $('#fancy-link').trigger('click');
            }
        });
        return false;
    }
</script>

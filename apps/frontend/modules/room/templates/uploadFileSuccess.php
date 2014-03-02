<?php if (!$isXhr) : ?>
<textarea>
<?php endif; ?>
    <script type="text/javascript">
        $(function () {
            $('#popup-form').ajaxForm({
                complete:function (data) {
                    var datas = JSON.parse(data.responseText);

                    parent.$('#path_to_picture').val(datas.picture_path);
                    parent.$('#path_to_thumb').val(datas.thumb_path);
                    parent.$('#picture_name').val(datas.picture_name);
                    parent.$('#thumb_name').val(datas.thumb_name);

                    <?php if ($uploadPath == '/uploads/assets/') : ?>
                        var formId = $('#formId').val();
                        $('#' + formId).attr('action', '').submit();
                    <?php else : ?>
                    parent.jQuery.fancybox.close();
                    <?php endif; ?>
                }
            });

            $('#popup-cancel-btn').click(function () {

                parent.$("input[type=file]").val('');
                parent.$('#path_to_picture').val('');
                parent.$('#path_to_thumb').val('');
                parent.$('#picture_name').val('');
                parent.$('#thumb_name').val('');

                parent.jQuery.fancybox.close();
            });

            var jcrop_api, boundx, boundy;

            $('#target').Jcrop({
                bgColor:'transparent',
                setSelect:[ 0, 0, parseInt('<?php echo $minWidth ?>', 10), parseInt('<?php echo $minHeight ?>', 10)],
                onChange:updatePreview,
                onSelect:updatePreview,
                aspectRatio:parseInt('<?php echo $minWidth ?>', 10) / parseInt('<?php echo $minHeight ?>', 10)
            }, function () {
                // Use the API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
                // Store the API in the jcrop_api variable
                jcrop_api = this;
            });

            function updatePreview(c) {
                if (parseInt(c.w) > 0) {
                    $('#x').val(c.x);
                    $('#y').val(c.y);
                    $('#w').val(c.w);
                    $('#h').val(c.h);

                    var rx = parseInt('<?php echo $minWidth ?>', 10) / c.w;
                    var ry = parseInt('<?php echo $minHeight ?>', 10) / c.h;

                    $('#preview').css({
                        width:Math.round(rx * boundx) + 'px',
                        height:Math.round(ry * boundy) + 'px',
                        marginLeft:'-' + Math.round(rx * c.x) + 'px',
                        marginTop:'-' + Math.round(ry * c.y) + 'px'
                    });
                }
            }
        })
        ;
    </script>
    <div id="popup-contener">
        <div id="title-top">
            <h2>
                <?php echo __('text_upload_file_resize_picture')?>
            </h2>
        </div>
        <div id="center-content">
            <p>
                <?php echo __('text_upload_file_resize_description', array('%br%' => '<br />'))?>
            </p>
            <br/>
            <table id="popup-table">
                <thead>
                <tr>
                    <th>
                        <h2>
                            <?php echo __('text_upload_file_resize_picture_original')?>
                        </h2>
                    </th>
                    <th width="240">
                        <h2>
                            <?php echo __('text_upload_file_resize_picture_final')?>
                        </h2>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div id="popup-original-picture" style="width: <?php echo $width?>px; height: <?php echo ($height < 461) ? $height : '461' ?>px;">
                            <?php echo image_tag($picture, array(
                                                                'size' => $size, 'id'    => 'target'
                                                           ))?>
                        </div>
                    </td>
                    <td class="top">
                        <div id="popup-preview-picture" style="width: <?php echo $minWidth ?>px; height: <?php echo $minHeight ?>px;">
                            <?php echo image_tag($picture, array(
                                                                'size'  => $size, 'id' => 'preview',
                                                                'alt'   => 'Preview'
                                                           ))?>
                        </div>
                        <div id="popup-btn-contener">
                            <form id="popup-form" action="<?php echo url_for('room/cropFile');?>" method="post">
                                <input type="hidden" id="x" name="x" value=""/>
                                <input type="hidden" id="y" name="y" value=""/>
                                <input type="hidden" id="w" name="w" value=""/>
                                <input type="hidden" id="h" name="h" value=""/>
                                <input type="hidden" id="imageSource" name="image_source" value="<?php echo $picture;?>"/>
                                <input type="hidden" id="imageName" name="image_name" value="<?php echo $pictureName;?>"/>
                                <input type="hidden" id="withThumb" name="with_thumb" value="<?php echo $withThumb ?>"/>
                                <input type="hidden" value="<?php echo $uploadPath ?>" name="upload_path" id="uploadPath"/>
                                <input type="hidden" value="<?php echo $uploadName ?>" name="upload_name" id="uploadName"/>
                                <input type="hidden" value="<?php echo $minWidth ?>" name="min_width" id="minWidth"/>
                                <input type="hidden" value="<?php echo $minHeight ?>" name="min_height" id="minHeight"/>
                                <input type="hidden" value="<?php echo $formId ?>" name="formId" id="formId"/>
                                <input type="submit" id="popup-save-btn" value="Enregistrer"/>
                                <input type="reset" id="popup-cancel-btn" value="Annuler"/>
                            </form>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div style="height: 40px;"></div>
        </div>
    </div>
<?php if (!$isXhr) : ?>
</textarea>
<?php endif; ?>
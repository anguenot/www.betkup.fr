<?php if ($isAnimate) : ?>
<?php use_stylesheet('tipsy/tipsy.css') ?>
<?php use_javascript('jquery.tipsy.js') ?>
<?php endif ?>
<style type="text/css">
    .user-avatar {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        width: <?php echo $cWidth ?>px;
        height: <?php echo $cHeight ?>px;
        text-align: center;
        overflow: hidden;
    }

    .tipsy {
        padding: 5px;
        font-size: 10px;
        opacity: 1;
        filter: alpha(opacity=100);
    }

    .tipsy-inner {
        padding: 8px;
        background-color: black;
        color: white;
        max-width: 300px;
        text-align: center;
    }
</style>
<span id="<?php echo $id ?>" class="user-avatar <?php echo $class ?>" style="<?php echo $style ?>">
    <?php echo image_tag($avatarPath, array(
                                           'alt' => $alt, 'title' => $alt, 'size' => $avatarSize
                                      )) ?>
</span>
<script type="text/javascript">
    <?php if ($isAnimate) : ?>
    $('#<?php echo $id ?>').tipsy({
        gravity:'w',
        html:true,
        offset:10,
        opacity:1.0,
        title:function () {
            return eval($(document.createElement('img')).attr({
                'src':'<?php echo $avatarPath ?>',
                'alt':'<?php echo $alt ?>'
            }).css({
                        'width':'<?php echo $wAnimateTo ?>',
                        'height':'<?php echo $hAnimateTo ?>'
                    }));
        }
    });
        <?php endif ?>
</script>
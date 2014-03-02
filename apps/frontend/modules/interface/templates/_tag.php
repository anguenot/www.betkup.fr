<div id="tag_<?php echo $tag["name"] ?>" class="tag" style="cursor: pointer; float: left; height: 26px; background: url('/images/interface/tag/background.png'); margin-right: 15px; margin-bottom: 9px;">
    <div style="float: left; margin-left: 8px; margin-right: 14px; line-height: 26px;">
        <span class="name" id="tag_name_<?php echo $tag["name"] ?>"><?php echo $tag["name"] ?></span>
    </div>
    <div id="tag_right_<?php echo $tag["name"] ?>" style="float: left; width: 32px; line-height: 26px; text-align: center; height: 26px; background: url('/images/interface/tag/right.png'); margin: 0px; padding: 0px;">
        <span class="score"><?php echo $tag["score"] ?></span>
    </div>
</div>

<script type="text/javascript">
    
    $("#tag_<?php echo $tag["name"] ?>").mouseover(function(key) {
        var tag_clicked = $("#input_room_tag_<?php echo $tag["name"] ?>").val();
        if ( tag_clicked == '' ) {
            $("#tag_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/backgroundOver.png')");
            $("#tag_right_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/rightOver.png')");
            $("#tag_name_<?php echo $tag["name"] ?>").css("color", "white");
        }
    });
    
    $("#tag_<?php echo $tag["name"] ?>").mouseleave(function(key) {
        var tag_clicked = $("#input_room_tag_<?php echo $tag["name"] ?>").val();
        if ( tag_clicked == '' ) {
            $("#tag_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/background.png')");
            $("#tag_right_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/right.png')");
            $("#tag_name_<?php echo $tag["name"] ?>").css("color", "#696967");
        }
    });

    $("#tag_<?php echo $tag["name"] ?>").click(function(key) {
        var tag_clicked = $("#input_room_tag_<?php echo $tag["name"] ?>").val();
        if ( tag_clicked == '' ) {
            $("#tag_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/backgroundOver.png')");
            $("#tag_right_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/rightOver.png')");
            $("#tag_name_<?php echo $tag["name"] ?>").css("color", "white");
            $("#input_room_tag_<?php echo $tag["name"] ?>").val('1');
        }
        else {
            $("#tag_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/background.png')");
            $("#tag_right_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/right.png')");
            $("#tag_name_<?php echo $tag["name"] ?>").css("color", "#696967");
            $("#input_room_tag_<?php echo $tag["name"] ?>").val('');
        }
    });

    <?php if ( $actif ): ?>
        $("#tag_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/backgroundOver.png')");
        $("#tag_right_<?php echo $tag["name"] ?>").css("background", "url('/images/interface/tag/rightOver.png')");
        $("#tag_name_<?php echo $tag["name"] ?>").css("color", "white");
        $("#input_room_tag_<?php echo $tag["name"] ?>").val('1');
    <?php endif ?>
    
</script>
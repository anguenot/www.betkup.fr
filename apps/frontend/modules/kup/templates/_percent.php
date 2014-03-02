<div class="blocPercent">
    <p class="events">
        <?php echo image_tag('kup/home/tools_evenements.png', array('align'=>'absmiddle', 'alt'=>'Événements', 'size'=>'21x16') ) ?>
        Événements pris en compte : <span class="dataValue"><?php echo $nbEvents ?> / <?php echo $nbEventsTotal ?></span></p>
    <div class="percentBar">
        <div class="percentProgress" style="width:<?php echo $sizePercentToPx ?>px;"></div>
        <div class="percentProgressLabel" style="width:<?php echo $sizePxLabel ?>px;"><p><?php echo $progress ?> %</p></div>
    </div>
</div>
<div style="clear:both"></div>
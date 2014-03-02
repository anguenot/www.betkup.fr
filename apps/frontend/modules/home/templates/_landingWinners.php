<!-- <a class="arrow arrow-previous" href="#prev"></a> -->
<div class="carousel-kups">
    <ul id="carousel-winners-container" class="landing-winners-container" style="width: <?php echo count($winnersData) * 102 ?>px">
        <?php if (count($winnersData) > 0) : ?>
        <?php foreach ($winnersData as $winners) : ?>
            <li class="carousel-box">
                <h3 class="nobr" title="<?php echo $winners['name'] ?>">
                    <?php echo $winners['name'] ?>
                </h3>

                <div class="image-container">
                    <?php echo image_tag($winners['avatar'], array(
                                                                  'size'  => '50x50',
                                                                  'alt'   => 'avatar ' . $winners['name']
                                                             )) ?>
                </div>
                <ul class="kups-infos">
                    <li>
                        <span class="img-jackpot"></span>
                        <?php echo __('text_landing_page_jackpot_text') ?> : <b><?php echo $winners['jackpot'] ?>€</b>
                    </li>
                    <li>
                        <span class="img-stake"></span>
                        <?php echo __('text_landing_page_stake_text') ?> : <b><?php echo $winners['stake'] ?>€</b>
                    </li>
                    <li>
                        <span class="img-sport" style="background: url('<?php echo $winners['picto_sport'] ?>') center no-repeat;"></span>
                        <?php echo $winners['sport'] ?>
                    </li>
                </ul>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
<!-- <a class="arrow arrow-next" href="#next"></a> -->

<script type="text/javascript">
    var tweenKups = null;

    $(function () {
        $('a.arrow', $('.layout-tabs-container')).click(function () {

            if (tweenKups && tweenKups.isPlaying) {
                return false;
            }
            var href = $(this).attr('href'),
                carouselContainer = $('#carousel-container'),
                currentLeft = parseInt(carouselContainer.css('left').replace('px', ''), 10),
                currentRight = parseInt(carouselContainer.css('right').replace('px', ''), 10),
                carouselNumberBox = $('li.carousel-box', carouselContainer).length,
                carouselBox = $('li.carousel-box:first', carouselContainer),
                unitWidth = carouselBox.width(),
                boxMargin = parseInt(carouselBox.css('margin-left').replace('px', ''), 10),
                boxWidth = unitWidth + boxMargin,
                maxWidth = boxWidth * carouselNumberBox,
                end = null,
                boxToDisplay = 4;

            if (href == '#prev') {
                if (currentLeft == 0) {
                    end = (boxToDisplay * boxWidth) - maxWidth;
                    tweenKups = new Tween(carouselContainer.get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
                    tweenKups.start();
                    return false;
                }
                end = currentLeft + boxWidth;
            } else {
                end = currentLeft - boxWidth;
            }

            if (href == '#next' && (maxWidth - Math.abs(currentLeft) - boxToDisplay * boxWidth) < boxWidth) {
                end = "0";
                tweenKups = new Tween(carouselContainer.get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
                tweenKups.start();
                return false;
            }

            tweenKups = new Tween(carouselContainer.get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
            tweenKups.start();

            return false;
        });
    });
</script>
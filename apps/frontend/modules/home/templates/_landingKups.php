<a class="arrow arrow-previous" href="#prev"></a>
<div class="carousel-kups">
    <ul id="carousel-container" class="landing-kups-container" style="width: <?php echo count($kupsData) * 125 ?>px">
        <?php if (count($kupsData) > 0) : ?>
        <?php foreach ($kupsData as $kupData) : ?>
            <li class="carousel-box">
                <h3 class="nobr" title="<?php echo isset($kupData['name']) ? $kupData['name'] : '' ?>">
                    <?php echo isset($kupData['name']) ? $kupData['name'] : '' ?>
                </h3>

                <div class="image-container">
                    <?php if (isset($kupData['ui']) && isset($kupData['ui']['vignette_kup_view'])) : ?>
                    <?php echo image_tag($kupData['ui']['vignette_kup_view'], array('height' => '130', 'alt' => isset($kupData['description']) ? $kupData['description'] : '')) ?>
                    <?php endif; ?>
                    <div class="play-button">
                        <a href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kupData['uuid'])) ?>">
                            <?php echo isset($kupData['button']) ? $kupData['button'] : '' ?>
                        </a>
                    </div>
                </div>
                <ul class="kups-infos">
                    <?php if ($kupData['type'] == sfConfig::get('mod_home_kup_type_gambling_fr')) : ?>
                    <li>
                        <span class="img-jackpot"></span>
                        <?php echo __('text_landing_page_jackpot_text') ?> : <b><?php echo $kupData['jackpot'] ?>€</b>
                    </li>
                    <li>
                        <span class="img-stake"></span>
                        <?php echo __('text_landing_page_stake_text') ?> : <b><?php echo $kupData['stake'] ?>€</b>
                    </li>
                    <?php else : ?>
                    <li>
                        <span class="img-jackpot"></span>
                        <?php echo __('text_landing_page_prizes_text') ?> : <b><?php echo $kupData['prizes'] ?>€</b>
                    </li>
                    <li>
                        <span class="img-stake"></span>
                        <?php echo __('text_landing_page_stake_text') ?> : <b><?php echo __('text_landing_page_free') ?></b>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
<a class="arrow arrow-next" href="#next"></a>

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
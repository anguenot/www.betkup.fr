<?php if ($quote["text"] != ""): ?>
    <div class="theyLikeBetkupBloc">
        <div style="float: left;">
            <img src="<?php echo $quote["picture"] ?>" border="0" style="margin: 0px; margin-top: 2px;">
        </div>
        <div style="<?php if(isset($featured) && $featured) : ?> background: url(/image/<?php echo $sf_user->getCulture(); ?>/home/quote/featured.png) no-repeat 230px 0;<?php endif; ?>">
            <div style="height: 12px;"></div>
            <div class="message"><?php echo __($quote["text"]) ?></div>
            <div class="auteur"><?php echo __($quote["author"]) ?></div>
        </div>
    </div>
<?php endif ?>
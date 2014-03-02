<div class="mainFooter">
    <?php include_component('footer', 'tweets') ?>
	<div class="follow-us">
        <h1><?php echo __('label_footer_follow_us'); ?></h1>
        <a href="http://www.facebook.com/betkup" target="_blank">
			<?php echo image_tag('/image/default/footer/facebook.png', 
					array(
						'alt' => __('label_footer_facebook'), 
						'size' => '23x23',
						'onmouseover' => 'this.src=\'/image/default/footer/facebook_hover.png\'',
						'onmouseout' => 'this.src=\'/image/default/footer/facebook.png\''
						)
					) ?>
		</a>
        <a href="http://twitter.com/betkup" target="_blank">
			<?php echo image_tag('/image/default/footer/twitter.png', 
					array(
						'alt' => __('label_footer_twitter'), 
						'size' => '23x23',
						'onmouseover' => 'this.src=\'/image/default/footer/twitter_hover.png\'',
						'onmouseout' => 'this.src=\'/image/default/footer/twitter.png\''
						)
					) ?>
		</a>
			<?php echo mail_to('contact@betkup.com',image_tag('/image/default/footer/mail.png', array(
						'alt' => __('label_footer_mail'), 
						'size' => '23x23',
						'onmouseover' => 'this.src=\'/image/default/footer/mail_hover.png\'',
						'onmouseout' => 'this.src=\'/image/default/footer/mail.png\''
						)
					),array('target'=>'_blank')) ?>
        <a href="#top" title="top page" class="toppage"> 
            <img alt="Top page" border="0" src="/images/moncompte/ancretop.png" height="53" width="22" />
        </a> 
    </div>
    <div class="infos" align="center">
        <div class="about">
            <H1><?php echo __('label_footer_about_us'); ?></H1>
            <ul>
                <li><?php echo link_to(__('link_footer_who_are_we'),'http://blog.betkup.fr/post/32877508285/qui-sommes-nous') ?></li>
                <li><?php echo link_to(__('link_footer_faq'), url_for('home/faq'), array('onclick' => 'openPopup(this); return false;')) ?></li>
                <li><?php echo link_to(__('link_footer_how_it_works'),url_for(array('module' => 'home', 'action' => 'howto'))) ?></li>
                <li><a id="video-pop-up" href="https://www.youtube.com/watch?v=4EV-6M1ylHI" title="Betkup, 1er site de paris sportifs communautaire.">Teaser vidéo</a></li>
            </ul>
        </div>
        <div class="legal">
            <H1><?php echo __('label_footer_legal_rights'); ?></H1>
            <ul>
                <li><a href="<?php echo $cguUrl; ?>" target="new"><?php echo __('link_footer_terms_of_use'); ?></a></li>
                <li><a href="<?php echo $rulesUrl; ?>" target="new"><?php echo __('link_footer_rules'); ?></a></li>
                <li><?php echo link_to(__('link_footer_responsible_gaming'),'/doc/responsible_gaming.pdf');?></li>
                <li>
                    <?php echo link_to('Plan du site', url_for('sitemap_page')) ?>
                </li>
            </ul>
        </div>
        <div class="more">
            <H1><?php echo __('label_footer_further_infos'); ?></H1>
            <ul>
            	<li><?php echo link_to(__('link_footer_blog'),'http://blog.betkup.fr/');?></li>
                <li><?php echo link_to(__('link_footer_site_corpo'),'http://www.sofungaming.com/');?></li>
                <li><?php echo link_to(__('link_footer_appli_f1'),'http://apps.facebook.com/pronos-formule-un');?></li>
            	<li><a href="mailto:contact@betkup.com"><?php echo __('link_footer_contact_us'); ?></a></li>
            </ul>
        </div>
    	<?php if (sfConfig::get('app_profile') != 'free') { ?>
        <div class="legality">
            <strong class="bets"><?php echo __('label_footer_bets'); ?></strong><br />
            <strong class="in-all"><?php echo __('label_footer_legality'); ?></strong>
            <p><?php echo __('text_footer_authority_agreement'); ?></p>
            <a class="know-more" href="<?php echo url_for('home/betTrust')?>#bet_law"><?php echo __('link_footer_know_more'); ?></a>
            <?php echo image_tag('/images/footer/arjel.png',array('class'=>'sponsor'))?>
        </div>
    
        <div class="reliability">
            <strong class="bets"><?php echo __('label_footer_bets'); ?></strong><br />
            <strong class="in-all"><?php echo __('label_footer_reliability'); ?></strong>
            <p><?php echo __('text_footer_secure_paiements'); ?></p> 
            <a class="know-more" href="<?php echo url_for('home/betTrust')?>#bet_trust"><?php echo __('link_footer_know_more'); ?></a>
            <img class="sponsor" src="/images/footer/mastercard.png" />
            <img class="sponsor" src="/images/footer/visa.png" />
            <div style="clear: left;"></div>
            <img class="sponsor" src="/images/footer/credit-mutuel-arkea.png" />
            <img class="sponsor" src="/images/footer/payline.png" />
        </div>
    
        <div class="transparency">
            <strong class="bets"><?php echo __('label_footer_bets'); ?></strong><br />
            <strong class="in-all"><?php echo __('label_footer_transparency'); ?></strong>
            <p><?php echo __('text_footer_money_refund'); ?></p> 
            <a class="know-more" href="<?php echo url_for('home/betTrust')?>#bet_transparency"><?php echo __('link_footer_know_more'); ?></a>
            <img class="sponsor" src="/images/footer/ffr.png" />
            <img class="sponsor" src="/images/footer/lnr.png" />
        </div>
        <?php } ?>
    </div>
    <div class="game_interdiction">
    	<h1>
    		<a target="_new" href="http://www.interieur.gouv.fr/sections/a_votre_service/vos_demarches/interdiction-jeux/view">
    			<?php echo __('text_game_interdiction_title') ?>
    		</a>
    	</h1>  
    	<p>
    		<a target="_new" href="http://www.interieur.gouv.fr/sections/a_votre_service/vos_demarches/interdiction-jeux/view">
    			<?php echo __('text_game_interdiction_text') ?>
			</a>
		</p>
    </div>
</div>
<?php if (sfConfig::get('app_profile') == 'free') : ?>
<script type="text/javascript">
$('.mainFooter').css('height','300px').css('background-position','top center');
</script>
<?php endif; ?>
<script type="text/javascript"> 
$(function() {

	$('#video-pop-up, .video-pop-up').click(function() {
		$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: $(this).attr('title'),
			'width'			: 640,
			'height'		: 360,
			'href'			: $(this).attr('href').replace(new RegExp("watch\\?v=", "i"), 'v/') + '&autoplay=1',
			'type'			: 'swf',
			'hideOnOverlayClick' : false,
			'swf'			: {
			   	'wmode'		: 'transparent',
				'allowfullscreen'	: 'true'
			}
		});
		return false;
	});
});

function openPopup(obj) {
    var href = $(obj).attr('href');
    window.open(href, 'FAQ', config='height=842, width=730, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');

    return false;
}
</script>
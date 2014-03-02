<div id="faq-contener">
	<div id="faq-header">
		<div id="title-faq-header"></div>
		<div id="logo-faq-header"></div>
	</div>
	<div id="faq-menu">
		<a href="<?php echo url_for('home/faqRegister') ?>" class="menu-link selected">
			<span class="link-text pen">
			<?php echo __('text_faq_title_register')?>
			</span>
		</a>
		<a href="<?php echo url_for('home/faqAccount') ?>" class="menu-link">
			<span class="link-text people">
			<?php echo __('text_faq_title_account')?>
			</span>
		</a>
		<a href="<?php echo url_for('home/faqPayment') ?>" class="menu-link">
			<span class="link-text bill">
			<?php echo __('text_faq_title_payments')?>
			</span>
		</a>
		<a href="<?php echo url_for('home/faqKupRoom') ?>" class="menu-link">
			<span class="link-text kup">
			<?php echo __('text_faq_title_rooms_kups')?>
			</span>
		</a>
		<a href="<?php echo url_for('home/faqPredictions') ?>" class="menu-link">
			<span class="link-text grid">
			<?php echo __('text_faq_title_predictions')?>
			</span>
		</a>
	</div>
	<div id="faq-content">
		<div id="top-content"></div>
		<div id="middle-content">
		</div>
		<div id="bottom-content"></div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	
	var loadContent = function(_url) {
		
		var jxhr = $.ajax({
			url : _url,
			type: 'GET',
			dataType : 'html' 
		});

		jxhr.done(function(html) {
			$('#middle-content').html(html);
		});
	};

	$('.menu-link').click(function() {
		$('.menu-link').removeClass('selected');
		$(this).addClass('selected');
		var url = $(this).attr('href');
		loadContent(url);
		return false;
	});

	var selectedLink = $('.selected').attr('href');
	loadContent(selectedLink);
});
</script>
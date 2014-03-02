<div id="promo-image">
	<table>
		<tr>
			<td>
				<?php echo image_tag('/image/default/challenge/logo_euro2012.png', array('size' => '80x95'))?>
			</td>
			<td>
				<?php echo image_tag('/image/default/challenge/promos/promo_euro_2012_bonnus_img.png', array('size' => '382x95'))?>
			</td>
			<td>
				<?php echo image_tag('/image/default/challenge/logo_euro2012.png', array('size' => '80x95'))?>
			</td>
		</tr>
	</table>
</div>
<div id="promo-description">
	<p>
	<?php echo __('text_promo_euro_2012_introduction', array('%br%' => '<br />', '%important%' => '<span class="important">', '%/important%' => '</span>'))?>
	</p>
	<div style="height: 15px;"></div>
	<a class="more-infos-link" href="#more-infos">
	<?php echo __('text_promo_euro_2012_more_infos_link')?>
	</a>
</div>

<div id="promo-bonnus">
	<h2></h2>
	<table>
		<tbody>
			<tr>
				<td class="pellet-td">
					<span class="pellet">1</span>
				</td>
				<td>
					<p>
					<?php echo __('text_promo_euro_2012_condition_1', array('%br%' => '<br />', '%span%' => '<span class="small">', '%/span%' => '</span>'))?>
					</p>
				</td>
				<td class="arrow-td">
				<div class="arrow-left"></div>
				</td>
				<td class="colored">
				<?php echo __('text_promo_euro_2012_prize_1')?>
				</td>
			</tr>
			<tr>
				<td class="pellet-td">
					<span class="pellet">2</span>
				</td>
				<td>
					<p>
					<?php echo __('text_promo_euro_2012_condition_2')?>
					</p>
				</td>
				<td class="arrow-td">
				<div class="arrow-left"></div>
				</td>
				<td class="colored">
				<?php echo __('text_promo_euro_2012_prize_2')?>
				</td>
			</tr>
			<tr>
				<td class="pellet-td">
					<span class="pellet">3</span>
				</td>
				<td>
					<p>
					<?php echo __('text_promo_euro_2012_condition_3')?>
					</p>
				</td>
				<td class="arrow-td" >
				<div class="arrow-left"></div>
				</td>
				<td class="colored">
				<?php echo __('text_promo_euro_2012_prize_3')?>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="register">
					<a href="<?php echo url_for(array('module' => 'account', 'action' => 'registerAdvanced'))?>">
						<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '156x63'))?>
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="td-how-to">
					<div class="box-how-to-link">
						<span class="table-promos-link-or">ou</span><br />
						<table class="table-promos-link-how-to">
							<tr>
								<td>
									<div class="picto"></div>	
								</td>
								<td>
									<a href="<?php echo url_for('home/howto')?>">
										En savoir plus sur le fonctionnement 
									</a>
								</td>
							</tr>
						</table>
						
						
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div id="promo-warning">
	<table>
		<tr>
			<td id="promo-plus" class="img-more-info"></td>
			<td id="more-infos">
				<?php echo __('text_promo_euro_2012_more_infos')?>
			</td>
		</tr>
	</table>
	<div id="more-infos-contener">
	<p>
	<?php echo __('text_promo_euro_2012_rules', array('%br%' => '<br />', '%b%' => '<b>', '%/b%' => '</b>'))?>
	</p>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#promo-plus').click(function() {
		
		if($(this).parent().hasClass('open')) {
			$(this).parent().removeClass('open');
			$('#more-infos-contener').hide();
		} else {	
			$(this).parent().addClass('open');
			$('#more-infos-contener').show();
		}
	});
	$('.more-infos-link').click(function() {
		$('#promo-plus').parent().addClass('open');
		$('#more-infos-contener').show();
	});
});
</script>
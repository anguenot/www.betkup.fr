<div class="layoutIntAllBlanc" style="margin-top: 95px;">
	<div class="interface">
		<div id="slice_top"></div>
		<div id="top_page"></div>
		<div id="why_betkup">
			<?php echo image_tag('/image/'.$culture.'/bettrust/why_betkup.png', array('size' => '450x63', 'style' => 'margin-top:20px; margin-left: 10px;'));?>
		</div>
		<div id="black_line"></div>
		<div id="first_menu">
			<ul>
				<li><a href="#bet_law"><?php echo __('text_static_bet_law'); ?></a></li>
				<li><a href="#bet_trust"><?php echo __('text_static_bet_trust'); ?></a></li>
				<li><a href="#bet_transparency"><?php echo __('text_static_bet_transparency'); ?></a></li>
			</ul>
		</div>
		<div id="bet_law">
			<a href="#bet_law">
				<?php echo image_tag('/image/'.$culture.'/bettrust/bet_law.png', array('size' => '545x65'))?>
			</a>
			<a href="#top_page">
				<?php echo image_tag('/images/moncompte/ancretop.png', array('size' => '22x53', 'alt' => 'Top page', 'style' => 'float: right; margin-top: 10px; margin-right: 10px;'))?>
			</a>
		</div>
		<div id="bloc1_law">
			<div>
				<?php echo __('text_bloc1_law'); ?>
			</div>
		</div>
		<div id="bloc2_law">
			<table>
				<tr>
					<td>
						<?php echo image_tag('/image/'.$culture.'/bettrust/logo_arjel.png', array('size' => '117x125', 'style' => 'margin-top: 20px; margin-left: 45px;' ))?>
					</td>
					<td>
						<ul>
							<li>
								<?php echo __('text_bloc2_law_first') ?>
								<br />
								<a href="http://www.arjel.fr/Decisions-adoptees-le-10-novembre.html"><?php echo __('link_bloc2_law_first') ?></a>
							</li>
							<li>
								<?php echo __('text_bloc2_law_second') ?>
								<br />
								<a href="http://www.arjel.fr/Decisions-adoptees-le-10-novembre.html"><?php echo __('link_bloc2_law_second') ?></a>
							</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
		<div id="bet_trust">
			<a href="#bet_trust">
				<?php echo image_tag('/image/'.$culture.'/bettrust/bet_trust.png', array('size' => '545x65'))?>
			</a>
			<a href="#top_page">
				<?php echo image_tag('/images/moncompte/ancretop.png', array('size' => '22x53', 'alt' => 'Top page', 'style' => 'float: right; margin-top: 10px; margin-right: 10px;'))?>
			</a>
		</div>
		<div id="bloc_trust">
			<table>
				<tr>
					<td style="border-right: 2px solid #CCC;">
						<div class="bloc_trust_title">
							<?php echo __('text_bloc_trust_title_1')?>
						</div>
						<div class="bloc_trust_corp">
							<?php echo image_tag('/image/'.$culture.'/bettrust/logo_mastercard_visa.png', array('size' => '98x107', 'style' => 'float: left;'))?>
							<div style="padding-left: 50px;">
								<?php echo __('text_bloc_trust_visa');?>
							</div>
						</div>
						<div class="bloc_trust_corp" >
							<?php echo image_tag('/image/'.$culture.'/bettrust/logo_payline.png', array('size' => '149x45', 'style' => 'float: right; margin-top: 40px;'))?>
							<div style="margin-left: 0px;">
								<?php echo __('text_bloc_trust_payline');?>
							</div>
						</div>
						<div class="bloc_trust_corp">
							<?php echo image_tag('/image/'.$culture.'/bettrust/logo_creditmutuel_arkea.png', array('size' => '170x15', 'style' => 'float: left; margin-top: 80px;'))?>
							<div style="padding-left: 40px;">
								<?php echo __('text_bloc_trust_arkea');?>
							</div>
						</div>
					</td>
					<td>
						<div class="bloc_trust_title">
							<?php echo __('text_bloc_trust_title_2')?>
						</div>
						<br /><br />
						<div class="bloc_trust_corp" style="margin-left:10px; text-align: center;">
							<?php echo __('text_bloc_trust_arkea_garanty');?>
							<br /><br />
							<?php echo image_tag('/image/'.$culture.'/bettrust/logo_creditmutuel_arkea.png', array('size' => '170x15', 'style' => 'margin-top: 20px;'))?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div id="bet_transparency">
			<a href="#bet_transparency">
				<?php echo image_tag('/image/'.$culture.'/bettrust/bet_transparency.png', array('size' => '545x65'))?>
			</a>
			<a href="#top_page">
				<?php echo image_tag('/images/moncompte/ancretop.png', array('size' => '22x53', 'alt' => 'Top page', 'style' => 'float: right; margin-top: 10px; margin-right: 10px;'))?>
			</a>
		</div>
		<div id="bloc_transparency">
			<div class="bloc_transparency_title">
				<?php echo __('text_bet_transparency_title_right') ?>
			</div>
			<br /><br />
			<p>
				<?php echo __('text_bet_transparency_law_text')?>
			</p>
			<br /><br />
			<div id="transparency_images">
				<?php echo image_tag('/image/'.$culture.'/bettrust/logo_ffr.png', array('size' => '102x87'))?>
				<?php echo image_tag('/image/'.$culture.'/bettrust/logo_lnr.png', array('size' => '91x86'))?>
				<?php echo image_tag('/image/'.$culture.'/bettrust/logo_fff.png', array('size' => '98x97'))?>
				<?php echo image_tag('/image/'.$culture.'/bettrust/logo_lfp.png', array('size' => '63x91'))?>
			</div>
			<br /><br />
			<div class="bloc_transparency_title">
				<?php echo __('text_bet_transparency_title_tarification') ?>
			</div>
			<br /><br />
			<p>
				<?php echo __('text_bet_transparency_tarification_text')?>
			</p>
			<br /><br />
			<table>
				<tr>
					<td><?php echo __('text_bet_transparency_table_kup')?></td>
					<td><?php echo __('text_bet_transparency_table_kup_2_5')?></td>
					<td><?php echo __('text_bet_transparency_table_kup_6_50')?></td>
					<td><?php echo __('text_bet_transparency_table_kup_51_500')?></td>
					<td><?php echo __('text_bet_transparency_table_kup_500_1000')?></td>
					<td><?php echo __('text_bet_transparency_table_kup_1000')?></td>
				</tr>
				<tr>
					<td><?php echo __('text_bet_transparency_table_commission')?></td>
					<td>13%</td>
					<td>15%</td>
					<td>20%</td>
					<td>25%</td>
					<td>30%</td>
				</tr>
			</table>
			<div id="bloc_chart">
				<p style="margin: 0px; line-height: 20px;">
					<b><?php echo __('text_where_go_money')?></b>
					<br />
					<?php echo __('text_where_go_money_text')?>
				</p>
				<br />
				<div>
					<?php echo image_tag('/image/'.$culture.'/bettrust/chart.png', array('size' => '155x155'))?>
				<ul>
					<li>
						<?php echo image_tag('/image/'.$culture.'/bettrust/grey_circle.png', array('size' => '20x20'))?>
						<span><?php echo __('text_legend_chart_state')?></span>
					</li>
					<li>
						<?php echo image_tag('/image/'.$culture.'/bettrust/orange_circle.png', array('size' => '20x20'))?>
						<span><?php echo __('text_legend_chart_provider')?></span>
					</li>
					<li>
						<?php echo image_tag('/image/'.$culture.'/bettrust/green_circle.png', array('size' => '20x20'))?>
						<span><?php echo __('text_legend_chart_bank')?></span>
					</li>
					<li>
						<?php echo image_tag('/image/'.$culture.'/bettrust/blue_circle.png', array('size' => '20x20'))?>
						<span><?php echo __('text_legend_chart_federation')?></span>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="contents">
	<table id="table-top">
		<thead>
			<tr>
				<th colspan="2">
				<p>
				<?php echo __('text_facebook_f1_rules_p1')?>
				</p>
				<h1>
				<?php echo __('text_facebook_f1_rules_how_to')?>
				</h1>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<h2>
					<?php echo __('text_facebook_f1_rules_prediction_challenge')?>
					</h2>
					<p>
					<?php echo __('text_facebook_f1_rules_prediction_challenge_p')?>
					</p>
				</td>
				<td>
				<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/predictions.png', array('size' => '293x169'))?>
				<div class="line-separator"></div>
				</td>
			</tr>
			<tr class="no-style">
				<td>
				<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/ranking.png', array('size' => '310x180'))?>
				<div class="line-separator"></div>
				</td>
				<td>
					<h2>
					<?php echo __('text_facebook_f1_rules_full_prono')?>
					</h2>
					<p>
					<?php echo __('text_facebook_f1_rules_full_prono_p')?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="prizes">
	<table id="table-bottom">
		<thead>
			<tr>
				<th colspan="3">
					<h2 class="center">
					<?php echo __('text_facebook_f1_rules_win_prizes')?>
					</h2>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="3">
					<table class="title-td-table">
						<tr>
							<td>
							<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/ticker_win.png', array('class' => 'left', 'size' => '40x37'))?>
							</td>
							<td>
								<h3>
								<?php echo __('text_facebook_f1_rules_win_prizes_gp')?>
								</h3>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="center">
					<div class="bg-pics jackpot">
					<p>
						<?php echo __('label_kup_first_each_gp')?>
					</p>
					<br />
					<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/jackpot.png', array('size' => '320x165'))?>
					<div class="offered-by">
						<h4>Offert par</h4>
						<a target="_blank" href="http://www.bigben.fr/">
						<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/logo_bigben.png', array('size' => '213x55'))?>
						</a>
					</div>
					<br />
					<h4>
					<?php echo __('text_facebook_sport24_rules_prize')?>
					</h4>
					<p>
					<?php echo __('text_facebook_sport24_rules_prize_p')?>
					</p>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table class="title-td-table">
						<tr>
							<td>
							<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/ticker_win.png', array('class' => 'left', 'size' => '40x37'))?>
							</td>
							<td>
								<h3>
								<?php echo __('text_facebook_f1_rules_win_prizes_season')?>
								</h3>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="center">
					<div class="bg-pics jackpot">
					<p>
						<?php echo __('label_kup_first_end_season')?>
					</p>
					<br />
					<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/jackpot.png', array('size' => '320x165'))?>
					<div class="offered-by">
						<h4>Offert par</h4>
						<a target="_blank" href="http://www.bigben.fr/">
						<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/logo_bigben.png', array('size' => '213x55'))?>
						</a>
					</div>
					<br />
					<h4>
					<?php echo __('text_facebook_sport24_rules_prize')?>
					</h4>
					<p>
					<?php echo __('text_facebook_sport24_rules_prize_p')?>
					</p>
					</div>
				</td>
			</tr>
			<tr class="center">
				<td colspan="3">
					<table class="table-oreca">
						<tr>
							<td>
								<div class="line-separator"></div>
								<div class="bg-pics voucher">
								<p>
									<?php echo __('label_kup_second')?>
								</p>
								<br />
								<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/voucher_100e.png', array('size' => '186x95'))?>
								<br />
								<h4>
								100€
								</h4>
								<p>
								<?php echo __('text_facebook_sport24_rules_voucher')?>
								</p>
								<div class="line-separator"></div>
								</div>
							</td>
							<td>
								<div class="line-separator"></div>
								<div class="bg-pics voucher">
								<p>
									<?php echo __('label_kup_third')?>
								</p>
								<br />
								<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/voucher_50e.png', array('size' => '186x95'))?>
								<br />
								<h4>
								50€
								</h4>
								<p>
								<?php echo __('text_facebook_sport24_rules_voucher')?>
								</p>
								<div class="line-separator"></div>
								</div>
							</td>
						</tr>
					</table>
					<div class="oreca-store">
						<a target="_blank" href="http://www.oreca-store.com/">
						<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/rules/logo_oreca_store.png', array('size' => '199x58'))?>
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">
				<a href="/partner/sport24/rules.pdf" target="_blank" class="rules-link">
				<?php echo __('text_facebook_sport24_rules_link')?>
				</a>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>
<?php use_stylesheet('challenge/challenge.css')?>
<div class="" style="margin-left: 8px;">
<?php include_component('room', 'header', array ('data'=>$dataRoom, 'roomUI' => $roomUI)) ?>
</div>
<?php include_component('room', 'tabsHome', array('numTab' => '1', 'id' => '1', 'roomUI' => $roomUI, 'tabs' => $dataTabs)) ?>
<?php include_component('interface', 'areaOneBegin') ?>
<div style="height: 30px;"></div>
<div style="margin-left: 15px; width: 682px; height: 167px; position: relative; background: url('/image/default/challenge/bg_welcome.png') center no-repeat;">
	<div id="pic-challenge-welcome"></div>
	<table style="width: 670px; border-collapse: collapse; border-spacing: 0px;">
		<tr>
			<td width="120"
				style="vertical-align: top; padding-top: 5px; text-indent: 20px; font-family: Verdana; font-size: 12px; color: #FFFFFF;">
				<?php echo __('text_room_home_welcome')?>
			</td>
			<td style="vertical-align: top; padding-top: 40px; font-family: Verdana; font-size: 12px; color: #6A6A69;">
				<?php echo __('text_challenge_home_welcome_description_wimbledon_2012', array('%br%' => '<br />', '%b%' => '<b>', '%/b%' => '</b>', '%author%' => $dataRoom['author_nickname'], '%name%' => $dataRoom['name']))?>
			</td>
		</tr>
	</table>
</div>
<div style="height: 10px;"></div>
<h2 id="challenge-elite">
	Relève le défi sur le tournoi et rentre dans la légende Betkup !
</h2>
<div style="height: 10px;"></div>
<div id="challenge-view-container">
	<h3 class="principle">
	Le principe
	</h3>
	<p>
	Pronostique tout les jours sur les kups du jour, et partage la somme promise aux vainqueurs chaque journées. 
	</p>
	<p>
	Ce faisant tu marques des points et prends automatiquement part au Challenge Wimbledon. Les 3 premiers à la fin de la compétition se partageront le jackpot de 400€.
	</p>
	<div style="height: 20px;"></div>
	<table class="challenge-table">
		<tbody>
			<tr>
				<td colspan="3">
					<div class="challenge-tree-bloc">
						<h4>1</h4>
						<p>Je pronostique sur la kup du jour</p>
					</div>
					<div class="arrow-container">
						<div class="arrow-down-left"></div>
						<div class="arrow-down-right"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="challenge-tree-bloc">
						<h4>2</h4>
						<p>Je termine dans les places payées pour partager la cagnotte du jour (2600 euros sur les 14 jours)</p>
					</div>
				</td>
				<td class="challenge-bloc-plus">
					<div>
						<p>+</p>
					</div>
				</td>
				<td>
					<div class="challenge-tree-bloc">
						<h4>2'</h4>
						<p>Je rejoins le classement générale du Challenge</p>
					</div>
					<div class="arrow-down"></div>
				</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>
					<div class="challenge-tree-bloc">
						<h4>3</h4>
						<p>Je partage les 400€ de cagnotte si je termine dans les 3 premiers</p>
					</div>
					<div style="height: 40px;"></div>
				</td>
			</tr>
		</tbody>
	</table>
	
	<a href="<?php echo url_for(array('module' => 'kup', 'action' => 'home'))?>" class="prediction-link">Pronostiquer</a>
</div>

<div style="width: 100%; height: 50px;">&nbsp;</div>
<?php include_component('interface', 'areaOneEnd') ?>
<script type="text/javascript">
$(function() {
	$('div.rightroom').css('margin-left','0px').css('position','inherit');
});
</script>
<div class="infos">
	<div class="picture">
		<?php echo image_tag($driver['picture'], array('size' => '130x185')) ?>
	</div>
	<div class="block-right">
		<table class="block-table">
			<tr>
				<td class="driver-name">
					<b><?php echo $driver['driver'];?></b>
				</td>
			</tr>
			<tr>
				<td class="bande-haut">
					<?php echo image_tag($driver['flag'], array('width' => '40'))?>
					<?php echo image_tag($driver['helmet'], array('class' => 'helmet-picture', 'width' => '40'))?>
				</td>
			</tr>
			<tr>
				<td class="driver-team">
					Team : <?php echo $driver['team'];?>
				</td>
			</tr>
			<tr>
				<td>
					Nationalité : <?php echo $driver['nationality'];?>
				</td>
			</tr>
			<tr>
				<td>
					Position l'an dernier à la même course : <?php echo $driver['lastRank'];?>
				</td>
			</tr>
			<tr>
				<td>
				    <?php if (isset($canSavePredictionsRace) && $canSavePredictionsRace) :?>
					<a href="javascript:void(0);" class="btn-save" id="<?php echo $driver['uuid'];?>">
						<?php echo image_tag('/image/default/f1/interface/choose_button.png', array('size' => '76x22'))?>
					</a>
					<a href="javascript:void(0);" onclick="_close();" class="" id="<?php echo $driver['uuid'];?>">
						<?php echo image_tag('/image/default/f1/interface/close_popup_btn.png', array('size' => '76x22'))?>
					</a>
					<?php endif ?>
				</td>
			</tr>
		</table>
	</div>
</div>

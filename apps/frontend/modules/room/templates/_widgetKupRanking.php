<?php if(count($kupData) > 0) :?>
<div id="widget-prizes">
	<table>
		<tr>
			<td>
				<div class="widget-picto-prize"></div>
			</td>
			<td>
			Lots : <span class="widget-prize-colored"><?php echo $kupData['jackpot'] ?> €</span>
				
			</td>
		</tr>
	</table>
</div>
<?php endif; ?>
<?php if(count($kupRanking) > 0) :?>
<table id="widget-ranking-table">
	<thead>
		<tr>
			<th class="widget-ranking-thead1">
				<?php echo __('text_widget_ranking_rank')?>
			</th>
			<th class="widget-ranking-thead1">
				<?php echo __('text_widget_ranking_nickname')?>
			</th>
			<th class="widget-ranking-thead1">
				<?php echo __('text_widget_ranking_points')?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach($kupRanking as $ranking) :?>
		<?php if(isset($ranking['position'])) :?>
		<tr class="<?php echo ($i%2 ==1) ? 'odd' : 'even' ?>">
			<td>
				<?php echo $ranking['position']?>
			</td>
			<td class="nickName">
				<?php echo $ranking['member']['nickName']?>
			</td>
			<td>
				<?php echo $ranking['value']?>
			</td>
		</tr>
		<?php endif;?>
		<?php $i++; endforeach;?>
	</tbody>
</table>
<?php endif;?>
<a id="widget-link-ranking" href="http://www.20minutes.fr/sport/football/euro/pronos" target="_blank">
	<span id="picto"></span>
	<span><?php echo __('text_widget_ranking_link')?></span>
</a>

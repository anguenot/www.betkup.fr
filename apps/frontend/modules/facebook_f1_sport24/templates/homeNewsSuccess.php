<div id="news">
	<div class="title-box">
		<h2 class="title2">
		<?php echo __('title_facebook_f1_news')?>
		</h2>
		<?php echo image_tag('/image/default/sport24/logoS24.png', array('class' => 'news-logo','size' => '106x25'))?>
	</div>
	<div class="content-box content-box-right">
	<table>
		<tbody>
			<?php if(!isset($rssFeed['error'])) :?>
			<?php foreach($rssFeed['feed'] as $feed) :?>
			<tr>
				<td>
					<h4>
						<a target="_blank" href="<?php echo $feed['link']; ?>">
							<?php echo date('\L\e d/m/Y à h:i:s', strtotime($feed['pubDate']))?>
						</a>
					</h4>
					<p>
						<a target="_blank" href="<?php echo $feed['link']; ?>">
							<?php echo $feed['title']?>
						</a>
					</p>
				</td>
			</tr>
			<?php endforeach;?>
			<?php else :?>
			<tr>
				<td>
					<p>
					<?php echo __($rssFeed['error']['message']);?>
					</p>
				</td>
			</tr>
			<?php endif;?>
		</tbody>
	</table>
	</div>
	<div class="fade-effect"></div>
</div>
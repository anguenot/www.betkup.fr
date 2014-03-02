<div id="how-to">
	<div class="title-box">
		<h2 class="title2">
		<?php echo __('title_facebook_f1_how_to')?>
		</h2>
	</div>
	<div class="content-box content-box-right">
	<p>
		<?php echo __('text_facebook_sport24_how_to_p0')?>
	</p>
	<table>
		<tbody>
			<tr>
				<td class="pellet">
					<p>1</p>
				</td>
				<td>
					<p>
						<?php echo __('text_facebook_sport24_how_to_p1', array('%span%' => '<span class="red">', '%/span%' => '</span>', '%br%' => '<br />'))?>
					</p>
				</td>
			</tr>
			<tr>
				<td class="pellet">
					<p>2</p>
				</td>
				<td>
					<p>
						<?php echo __('text_facebook_sport24_how_to_p2',  array('%span%' => '<span class="red">', '%/span%' => '</span>', '%br%' => '<br />'))?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<a href="<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'rules'))?>">
		<?php echo __('text_facebook_sport24_how_to_link')?>
	</a>
	</div>
</div>
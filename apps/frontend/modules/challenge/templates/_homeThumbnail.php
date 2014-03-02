<div class="challenge-box">
	<table>
		<tbody>
			<tr>
				<td class="avatar">
					<div class="challenge-avatar">
						<?php echo image_tag($challenges['avatar'], array('size' => '170x130'))?>
					</div>
				</td>
				<td class="infos">
					<div class="challenge-name">
						<h2>
							<?php echo __($challenges['title'], array('%orange%' => '<span class="orange">', '%/orange%' => '</span>'))?>
						</h2>
					</div>
					<?php foreach ($challenges['arguments'] as $arguments) :?>
					<div class="arguments-line">
						<table>
							<tbody>
								<tr>
									<td class="ticker">
										<div></div>
									</td>
									<td>
										<p>
										<?php echo __($arguments, array('%orange%' => '<span class="orange">', '%/orange%' => '</span>'))?>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php endforeach;?>
					<div class="go-to">
						<a href="<?php echo $challenges['link']?>">
							<span class="picto"></span>
							<span>
								<?php echo __($challenges['link_label'])?>
							</span>
						</a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
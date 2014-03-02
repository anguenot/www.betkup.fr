<div class="theyLikeBetkup">
	<div class="content">
	<?php echo image_tag('/image/' . $sf_user->getCulture(). '/home/quote/header.png', array('alt' => __('label_home_like_betkup'), 'size' => '910x43')) ?>
		<table style="margin-bottom: 30px;">
			<tr>
				<td width="314" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[0] , 'featured' => true )) ?>
				</td>
				<td width="314" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[1] )) ?>
				</td>
				<td width="282" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[2] )) ?>
				</td>
			</tr>
			<tr>
				<td width="314" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[3] )) ?>
				</td>
				<td width="314" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[4] )) ?>
				</td>
				<td width="282" height="132" align="left" valign="top">
				<?php include_component('home', 'quote', array( 'quote' => $quotesData[5] )) ?>
				</td>
			</tr>
		</table>
	<?php include_component('home', 'press', array()) ?>
	</div>
</div>

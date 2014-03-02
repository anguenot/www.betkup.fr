<div id="top" class="mainHeader">
 	<div style="width: 528px; height: 60px; margin-left: -264px; left: 50%; right: 50%; position: absolute; z-index: 1;">
 		<a id="header_image" href="http://www.joueurs-info-service.fr/"  target="_new">
			<?php echo image_tag('/image/'.$sf_user->getCulture().'/header/'.$selectedBackground, array('size' => '528x60', 'id' => 'image_source'))?>	
 		</a>
 	</div>
 	<div style="position: absolute; right: 50%; margin-right: -480px; z-index: 1; width:170px; height:60px;">
	 	<a href="http://www.joueurs-info-service.fr/"  target="_new">
		 	<?php echo image_tag('/images/header/child_'.$sf_user->getCulture().'.png', array('style' => 'z-index: 1; position: absolute;', 'size' => '170x55'))?>
	 	</a>
 	</div>
</div>
<script type="text/javascript">
$(function() {
		var imagesList = new Array();
		var selectedBgIndex = <?php echo $randomIndex; ?>;
		// Delay time : 3min = 180000 ms
		var delay = 180000;
		var populateArray = function() {
			<?php foreach($backgroundList as $key => $background) :?>
				<?php echo 'imagesList['.$key.'] = \'/image/'.$sf_user->getCulture().'/header/'.$background.'\';'."\n"; ?>
			<?php endforeach; ?>
		};

		var changeImage = function() {
			if(selectedBgIndex < imagesList.length) {
			
				displayImage(imagesList[selectedBgIndex]);
				selectedBgIndex++;
				
			} else {
				selectedBgIndex = 1;
				displayImage(imagesList[0]);
			}
		};

		var displayImage = function(image) {
			$('#image_source').attr('src', image);
		};

		var imageChanger = function() {
			populateArray();
			setInterval(changeImage, delay);
		};
		imageChanger();
});
</script>
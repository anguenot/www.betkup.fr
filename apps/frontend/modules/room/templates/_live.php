<div class="live">
	<div class="content" style="position: relative; height: 245px;">
		<img src="/images/home/live/header.png" border="0" alt="" />
		<div class="col1">
		  <?php include_component('room', 'feed', array('feedData' => $feedData, 'kupsNames' => $kupsNames)) ?>
		</div>
		<div class="col2">
		  <?php include_component('room', 'ranking', array('rankingData' => $rankingData, 'kupsNames' => $kupsNames)) ?>
		</div>
	</div>
</div>

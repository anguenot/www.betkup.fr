<?php if($kup_uuid == 0) :?>
	<?php include_component('room', 'widgetKupRanking', array('kupData' => $kupData, 'kupRanking' => $kupRanking, 'urlToLink' => $urlToLink))?>
<?php elseif((($kupData['startDate']/1000) - (strtotime('now'))) > 0 && $kupData['status'] != -1) :?>
	<?php include_component('room', 'widgetCountDown', array('kupData' => $kupData, 'urlToLink' => $urlToLink))?>
<?php else :?>
	<?php include_component('room', 'widgetKupRanking', array('kupData' => $kupData, 'kupRanking' => $kupRanking, 'urlToLink' => $urlToLink))?>
<?php endif;?>
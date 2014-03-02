<?php $arrayActionKup = array('view', 'ranking', 'invite', 'results', 'news', 'rules','bet','predictionFixtures','predictionKnockout'); ?>
<?php $arrayActionRoom = array('view','edit','invite','kups','members'); ?>
<?php $arrayActionKupRoom = array('kup','kupRanking','kupResults','kupRules','kupPrediction','kupPredictionFixtures','kupPredictionKnockout','kupNews'); ?>
<?php if($module == 'facebook_ligue1_2012' && $action == 'landingPage' && $sf_request->getParameter('kup_uuid', "") != '') : ?>
    <meta property="fb:app_id" content="<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id') ?>" />
    <meta property="og:type"   content="<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns') ?>:matchday" />
    <meta property="og:url"    content="<?php echo $siteUrl.url_for('facebook_ligue1_2012_open_graph_kup_url', array('kup_uuid' => $sf_request->getParameter('kup_uuid', ""))) ?>" />
    <meta property="og:title"  content="<?php echo __($kupData["title"]) ?>" />
    <meta property="<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns') ?>:prizes" content="Lots : 1 jeu Fifa 13 et 70€ de bonus Betkup par journée" />
    <meta property="<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns') ?>:enddate" content="Vous avez jusqu'au <?php echo util::displayDateFromTimestampComplet($kupData["endDate"]); ?> pour valider vos pronos." />
    <meta property="og:description" content="<?php echo $kupData["description"]; ?>" />
    <meta property="og:image" content="<?php echo $siteUrl.$kupData["ui"]['vignette_edition_kup'] ?>" />
    <meta property="og:locale" content="fr_FR"/>
    <meta property="og:locale:alternate" content="en_US"/>
<?php elseif ($module == 'room' && (in_array($action, $arrayActionRoom))): ?>
    <?php if($sf_request->getAttribute('roomUI',"")){$roomUI=$sf_request->getAttribute('roomUI', "");} ?>
	<meta property="og:title" content="<?php echo  isset($dataRoom['name']) ? 'Room : '. $dataRoom['name'] : '' ?>" />
	<meta property="og:type" content="sports_team" />
	<meta property="og:url" content="<?php echo $siteUrl.url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>isset($dataRoom['id']) ? $dataRoom['id'] : '' )) ?>" />
	<meta property="og:image" content="<?php if (isset($roomUI)){echo $siteUrl.$roomUI["avatar-room"];}else{echo isset($dataRoom["picture"]) ? $siteUrl.$dataRoom["picture"] : '';} ?>" />
	<meta property="og:site_name" content="www.betkup.fr" />
	<meta property="og:description" content="<?php echo isset($dataRoom["description"]) ? $dataRoom["description"] : "" ; ?>" />
	<meta property="fb:admins" content="734535759,100002329493032,619372683" />
	<meta property="og:locale" content="fr_FR"/>
	<meta property="og:locale:alternate" content="en_US"/>
<?php elseif ($module == 'room' && (in_array($action, $arrayActionKupRoom))): ?>
	<?php if($sf_request->getAttribute('roomUI',"")){$roomUI=$sf_request->getAttribute('roomUI', "");} ?>
	<meta property="og:title" content="<?php echo 'Kup : '.__($kupData["title"]); ?>" />
	<meta property="og:type" content="sports_team" />
	<meta property="og:url" content="<?php echo $siteUrl.url_for(array('module'=>'room', 'action'=>'kup', 'room_uuid'=>$roomUuid,'kup_uuid'=>$kupData["uuid"])) ?>" />
	<meta property="og:image" content="<?php if (isset($roomUI)){echo $siteUrl.$roomUI["avatar-room"];}else{echo isset($dataRoom["picture"]) ? $siteUrl.$dataRoom["picture"] : '';} ?>" />
	<meta property="og:site_name" content="www.betkup.fr" />
	<meta property="og:description" content="<?php echo $kupData["description"]; ?>" />
	<meta property="fb:admins" content="734535759,100002329493032,619372683" />
	<meta property="og:locale" content="fr_FR"/>
	<meta property="og:locale:alternate" content="en_US"/>
<?php elseif ($module == 'kup' && (in_array($action, $arrayActionKup))): ?>
	<meta property="og:title" content="<?php echo 'Kup : '.__($kupData["config"]["kupName"]) ?>" />
	<meta property="og:type" content="sports_team" />
	<meta property="og:url" content="<?php echo $siteUrl.url_for(array('module'=>'kup', 'action'=>'view', 'uuid'=>$kupData["uuid"])) ?>" />
	<meta property="og:image" content="<?php echo $siteUrl.'/betkup.png'?>" />
	<meta property="og:site_name" content="www.betkup.fr" />
	<meta property="og:description" content="<?php echo $kupData["description"] ?>" />
	<meta property="fb:admins" content="734535759,100002329493032,619372683" />
	<meta property="og:locale" content="fr_FR"/>
	<meta property="og:locale:alternate" content="en_US"/>
<?php else: ?>
	<meta property="og:title" content="<?php echo __('open_graph_title');?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo $siteUrl.'/'; ?>" />
	<meta property="og:image" content="<?php echo $siteUrl.'/betkup.png'?>" />
	<meta property="og:site_name" content="www.betkup.fr" />
	<meta property="fb:admins" content="734535759,100002329493032,619372683" />
	<meta property="og:description" content="<?php echo __('open_graph_description');?>" />
	<meta property="og:locale" content="fr_FR"/>
	<meta property="og:locale:alternate" content="en_US"/>
<?php endif;?>
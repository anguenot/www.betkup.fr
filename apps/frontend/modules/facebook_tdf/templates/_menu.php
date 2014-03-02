<div class="row-fluid menu-bar" id="sticky_navigation">
	<div class="span1"></div>
	<div class="span10">
		<ul class="menu">
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'home')) ?>" class="upper <?php echo $sf_params->get('action') == 'home' ? 'selected': '' ?>">Accueil</a>
			</li>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'predictions')) ?>" class="upper <?php echo $sf_params->get('action') == 'predictions' ? 'selected': '' ?>">Pronostics</a>
			</li>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'results')) ?>" class="upper <?php echo $sf_params->get('action') == 'results' ? 'selected': '' ?>">Résultats</a>
			</li>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'ranking')) ?>" class="upper <?php echo $sf_params->get('action') == 'ranking' ? 'selected': '' ?>">Classement</a>
			</li>
			<li>
				<a href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'rules')) ?>" class="upper <?php echo $sf_params->get('action') == 'rules' ? 'selected': '' ?>">Lots/Règles</a>
			</li>
		</ul>
	</div>
	<div class="span1"></div>
</div>
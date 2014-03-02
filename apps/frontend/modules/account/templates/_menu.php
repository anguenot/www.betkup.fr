<div class="tabs-bar">
    <div>
        <ul id="tabs">
            <li class="tab  <?php if ($ongletActif == 1): ?>tab-selected<?php endif ?>">
                <a href="<?php echo url_for(array(
                                                 'module' => 'account', 'action'  => 'edit'
                                            )) ?>" title="<?php echo $labelsOnglets["labelOnglet1"] ?>" <?php if ($ongletActif == 1): ?>class="actif"<?php endif ?>>
                    <?php echo $labelsOnglets["labelOnglet1"] ?>
                </a>
            </li>
            <li class="tab <?php if ($ongletActif == 2): ?>tab-selected<?php endif ?>">
                <a href="<?php echo url_for(array(
                                                 'module' => 'account', 'action'  => 'privacy'
                                            )) ?>" title="<?php echo $labelsOnglets["labelOnglet2"] ?>" <?php if ($ongletActif == 2): ?>class="actif"<?php endif ?>>
                    <?php echo $labelsOnglets["labelOnglet2"] ?>
                </a>
            </li>
            <li class="tab <?php if ($ongletActif == 3): ?>tab-selected<?php endif ?>">
                <a href="<?php echo url_for(array(
                                                 'module' => 'account', 'action'  => 'status'
                                            )) ?>" title="<?php echo $labelsOnglets["labelOnglet3"] ?>" <?php if ($ongletActif == 3): ?>class="actif"<?php endif ?>>
                    <?php echo $labelsOnglets["labelOnglet3"] ?>
                </a>
            </li>
            <li class="tab <?php if ($ongletActif == 4): ?>tab-selected<?php endif ?>">
                <a href="<?php echo url_for(array(
                                                 'module' => 'account', 'action'  => 'transaction'
                                            )) ?>" title="<?php echo $labelsOnglets["labelOnglet4"] ?>" <?php if ($ongletActif == 4): ?>class="actif"<?php endif ?>>
                    <?php echo $labelsOnglets["labelOnglet4"] ?>
                </a>
            </li>
            <li class="tab <?php if ($ongletActif == 5): ?>tab-selected<?php endif ?>">
                <a href="<?php echo url_for(array(
                                                 'module' => 'account', 'action'  => 'prediction'
                                            )) ?>" title="<?php echo $labelsOnglets["labelOnglet5"] ?>" <?php if ($ongletActif == 5): ?>class="actif"<?php endif ?>>
                    <?php echo $labelsOnglets["labelOnglet5"] ?>
                </a>
            </li>
        </ul>
    </div>
</div>
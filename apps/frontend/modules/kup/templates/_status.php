<div class="boxRight">
<?php echo image_tag('kup/view/boxright-title.png', array('alt' => '', 'border' => '0', 'size' => '226x48')); ?>
    <div class="boxRightCorps" style="text-align: left;">
        <div style="padding: 10px; padding-left: 15px;">
        <?php if ( $participationValide == 'yes' ): ?>
            <img src="/images/kup/view/statut/participationValidee.png" border="0" />
        <?php endif ?>
        <?php if ( $participationValide == 'no' ): ?>
            <img src="/images/kup/view/statut/participationNonValidee.png" border="0" />
        <?php endif ?>
        <?php if ( $pronostic == 'yes' ): ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/pronostic.png');">
                <div align="left" class="texte">
                    <span class="texte"><?php echo $pronosticMessage ?></span>
                </div>
            </div>
        <?php else: ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/noPronostic.png');">
                <div align="left" class="texte">
                    <span class="texte"><?php echo $pronosticMessage ?></span>
                </div>
            </div>
         <?php endif ?>
         <?php if ( $mise == 'yes' ): ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/mise.png');">
                <div align="left" class="texte">
                    <span class="texte"><?php echo $miseMessage ?></span>
                </div>
            </div>
         <?php else: ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/noMise.png');">
                <div align="left" class="texte">
                    <span class="texte"><?php echo $miseMessage ?></span>
                </div>
            </div>
        <?php endif ?>
            <img src="/images/kup/view/statut/end.png" border="0" />
            <div align="center">
            <?php if ( $link == 'mise' ): ?>
                <a href="<?php echo url_for(array('module'=>'kup', 'action'=>'miser', 'uuid' => $uuid)) ?>" title="<?php echo __('Miser') ?>">
                    <img src="/images/kup/view/statut/buttonMiser.png" border="0" />
                </a>
            <?php endif ?>
            </div>
        </div>
    </div>
    <?php echo image_tag('kup/view/boxright-bottom.png', array('alt' => '', 'border' => '0', 'size' => '226x9')); ?>
</div>
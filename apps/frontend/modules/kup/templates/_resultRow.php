<tr>
    <td>
        <?php if ($type == "choc"): ?>
            <img src="/images/kup/view/regle/chocMini.png" border="0" style="position: absolute;" />
        <?php endif ?>
        <div class="result-row <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>">
            <?php if ($titleType == "string"): ?>
                <?php if ($orange != ""): ?>
                    <p style="margin: 0px; height: 6px;"></p>
                    <span class="tableauLegendeOrange"><?php echo $orange ?></span><br/>
                    <span class="tableauLegendeSuiteSmall"><?php echo $title ?></span>
                <?php else: ?>
                    <span class="tableauLegendeSmall"><?php echo $title ?></span>
                <?php endif ?>
            <?php endif ?>
            <?php if ($titleType == "array"): ?>
                <table class="result-row-table">
                    <tr>
                        <td style="vertical-align: middle;">
                        	<div title="<?php echo $title["equipe1"] ?>" class="tableDivResultRowLabel" style="text-align: right; paddind-right: 5px;">
                        		<?php echo util::coupe(html_entity_decode($title["equipe1"]), 14, '..') ?>
                        	</div>
                        </td>
                        <td style="width:46px; vertical-align: middle;">
                        	<?php echo image_tag($title["avatar1"], array('size' => '38x38', 'style' => 'margin-left: 4px; margin-right: 4px;'))?>
                        </td>
                        <td style="width:46px; vertical-align: middle;">
                        	<?php echo image_tag($title["avatar2"], array('size' => '38x38', 'style' => 'margin-left: 4px; margin-right: 4px;'))?>
                        </td>
                        <td style="vertical-align: middle;">
                        	<div title="<?php echo $title["equipe2"] ?>" class="tableDivResultRowLabel" style="text-align: left; paddind-left: 5px;">
                        		<?php echo util::coupe(html_entity_decode($title["equipe2"]), 14, '..') ?>
                        	</div>
                        </td>
                    </tr>
                </table>
            <?php endif ?>
        </div>
    </td>
    <td>
        <div class="result-row-cell-1 <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>" >
            <span class="tableauLegende3 nomarge" title="<?php echo $pronostic ?>"><?php echo util::coupe(html_entity_decode($pronostic), 11, '..') ?></span>
        </div>
    </td>
    <td>
        <div class="result-row-cell-2 <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>">
            <span class="tableauLegende3 nomarge" title="<?php echo $resultatOfficiel ?>"><?php echo util::coupe(html_entity_decode($resultatOfficiel), 11, '..') ?></span>
        </div>
    </td>
    <td>
        <div class="result-row-cell-3 <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>">
            <div style="height: 10px;"></div>
            <img src="<?php echo $resultatPronostic ?>" border="0" />
        </div>
    </td>
    <td>
        <div class="result-row-cell-4 <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>">
            <span class="tableauLegende4"><?php echo $points ?></span>
        </div>
    </td>
    <td>
        <div class="result-row-cell-5 <?php echo ($index%2 == 1) ? 'result-row-odd' : 'result-row-even'?>">
            <span class="tableauLegende4"><?php echo $bonnesReponses ?></span>
        </div>
    </td>
</tr>
<script type="text/javascript">
    function loadFacebookGrid() {
        /**
         var test = '<div class="fb-like" data-href="<?php echo $urlFacebook; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>';
         $('#grid-facebook').append(test);
         FB.XFBML.parse(document.getElementById('grid-facebook'));
         */
    }
</script>
<div class="title-results">
    <table>
        <tr>
            <td style="text-align: center;" width="80">
                <?php echo image_tag('/image/default/f1/interface/start_f1.png', array('size' => '64x33'))?>
            </td>
            <td id="grid-facebook">
                <?php echo __('text_start_grid')?>&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
</div>
<table class="table-results-content">
    <thead>
    <tr>
        <th class="resultsTheader" width="50"></th>
        <th class="resultsTheader" width="245"><?php echo __('text_your_prediction')?></th>
        <th class="resultsTheader" width="245"><?php echo __('text_official_results')?></th>
        <th class="resultsTheader" width="90"><?php echo __('text_results')?></th>
        <th class="resultsTheader" width="90"><?php echo __('text_results_points')?></th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 1; $i <= $maxResults; $i++) : ?>
    <tr>
        <td class="left">
				<span>
					<?php echo ($i == 1) ? $i . '<sup>er</sup>' : $i . '<sup>ème</sup>';?>
				</span>
        </td>
        <td class="left predictions">
            <table>
                <tr>
                    <td width="45">
                        <?php echo (isset($predictions[$i - 1])) ? image_tag($predictions[$i - 1]['helmet'], array('height' => '27')) : image_tag('/image/default/f1/interface/default_helmet.png', array('height' => '27'))?>
                    </td>
                    <td>
                        <div title="<?php echo (isset($predictions[$i - 1])) ? $predictions[$i - 1]['driver'] : '' ?>">
                            <b>
                                <?php echo (isset($predictions[$i - 1])) ? Util::coupe($predictions[$i - 1]['driver'], 18, '..') : __('label_kup_no_predictions_saved') ?>
                            </b>
                        </div>
                        <div title="<?php echo (isset($predictions[$i - 1])) ? $predictions[$i - 1]['team'] : '' ?>">
                            <?php echo (isset($predictions[$i - 1])) ? Util::coupe($predictions[$i - 1]['team'], 28, '..') : '' ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td class="left results">
            <table>
                <tr>
                    <td width="45">
                        <?php echo (isset($resultsGrid[$i - 1])) ? image_tag($resultsGrid[$i - 1]['helmet'], array('height' => '27')) : image_tag('/image/default/f1/interface/default_helmet.png', array('height' => '27'))?>
                    </td>
                    <td>
                        <div title="<?php echo (isset($resultsGrid[$i - 1])) ? $resultsGrid[$i - 1]['driver'] : '' ?>">
                            <b>
                                <?php echo (isset($resultsGrid[$i - 1])) ? Util::coupe($resultsGrid[$i - 1]['driver'], 18, '..') : __('label_kup_no_results') ?>
                            </b>
                        </div>
                        <div title="<?php echo (isset($resultsGrid[$i - 1])) ? $resultsGrid[$i - 1]['team'] : '' ?>">
                            <?php echo (isset($resultsGrid[$i - 1])) ? Util::coupe($resultsGrid[$i - 1]['team'], 28, '..') : '' ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td class="left">
            <?php echo(isset($resultsGrid[$i - 1]) && isset($predictions[$i - 1]) && $resultsGrid[$i - 1]['uuid'] == $predictions[$i - 1]['uuid']) ? image_tag('/image/default/f1/results/right.png', array('size' => '26x24')) : image_tag('/image/default/f1/results/wrong.png', array('size' => '26x24')) ?>
        </td>
        <td>
				<span>
					<?php echo (isset($resultsGrid[$i - 1]) && isset($predictions[$i - 1]) && isset($predictions[$i - 1]['results']['points'])) ? $predictions[$i - 1]['results']['points'] . ' pts' : '-' ?>
				</span>
        </td>
    </tr>
        <?php endfor;?>
    </tbody>
</table>
<div style="height: 20px; width:100%;"></div>
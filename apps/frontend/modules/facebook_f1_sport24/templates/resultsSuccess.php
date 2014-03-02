<div style="margin: 0px; height: 40px; width: 730px; padding-top: 10px;">
    <form id="form-filter" method="post" style="float: right;">
        <select id="results-kups" name="results_kups" class="select-filter">
            <?php foreach ($kupsData as $kup) : ?>
            <option value="<?php echo $kup['uuid'] ?>" <?php echo $kup['uuid'] == $kupData['uuid'] ? 'selected="selected"' : '' ?>>
                <?php echo $kup['name']?>
            </option>
            <?php endforeach;?>
        </select>
        <!-- <select id="results-friends" name="results-friends" class="select-filter">
              <option value="0">Mes résultats</option>
              <option value="1">Résultats de mes amis</option>
          </select>
           -->
    </form>
</div>
<div id="contents">
    <div id="results-module"></div>
</div>
<script type="text/javascript">
    $(function () {
        loadResultsLoad();

        $('#results-kups').selectmenu({
            style:'dropdown',
            width:160,
            menuWidth:160
        });

        $('.select-filter').change(function () {
            loadResultsLoad();
        });
    });

    function loadResultsLoad() {
        var filters = $('#form-filter').serializeObject();
        filters['kupsData'] = <?php echo json_encode($sf_data->getRaw('kupsData'))?>;
        filters['room_uuid'] = '<?php echo $room_uuid ?>';

        var resultsXhr = $.ajax({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_f1_sport24',
                                           'action'  => 'resultsLoad'
                                      ))?>',
            'type':'POST',
            'dataType':'html',
            'data':filters,
            'beforeSend':function () {
                $('#results-module').loadingModal();
            }
        });
        resultsXhr.done(function (data) {
            $('#results-module').loadingModal({'show':false});
            $('#results-module').html(data);
        });
    }
</script>
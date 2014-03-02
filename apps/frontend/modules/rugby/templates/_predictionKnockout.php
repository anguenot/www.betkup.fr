<div class="links">
    <?php if (!isset($room_uuid)) : ?>
    <a href="<?php echo url_for(array('module'=>'kup', 'action'=>'predictionFixtures', 'uuid'=> $kupData['uuid'])) ?>">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/final_phases_title.png', array('size' => '413x38', 'alt' => __('label_rugby_fixtures'))) ?>
    </a>
    <?php else: ?>
    <a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupPredictionFixtures', 'kup_uuid'=> $kupData['uuid'], 'room_uuid' => $room_uuid)) ?>">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/final_phases_title.png', array('size' => '413x38', 'alt' => __('label_rugby_fixtures'))) ?>
    </a>
    <?php endif ?>
</div>


<?php $i = 4; ?>
<form id="final-phases-form" action="" method="post">


<?php foreach($sf_data->getRaw('tournamentData') as $phase => $matches) : ?>
    <div class="phase phase-<?php echo $i; ?>">
        <div class="title">

        <?php echo $phase; ?></div>
        <div class="border"></div>
        <div class="matches">


        <?php foreach($matches as $key => $match) : ?>
            <div class="match">
                <div class="country country-1">
                    <input type="hidden" id="name-<?php echo $i; ?>-<?php echo $key; ?>-1"
                        name="<?php echo $phase; ?>[<?php echo $key; ?>][]"
                        value="<?php if ((isset($match['first_country'])) && (!is_array($match['first_country']))){ echo $match['first_country'];}else{ echo "0";}?>"
                    />




                        <?php if (isset($match['first_country'])) : ?>
                            <?php if (is_array($match['first_country'])) : ?>
                                 <?php foreach ($match['first_country'] as $name) : ?>
                                    <div style="display: none;" class="country-name country-name-<?php echo $name; ?>"><?php echo __($name); ?></div>
                                <?php endforeach; ?>
                                <?php
                                 $data = array();
                                 foreach ($match['first_country'] as $e) {
                                     $data[$e] = __($e);
                                 }
                                include_component('interface', 'select', array(
                                        'noMargin' => true,
                                        'bloc' => 'home_kup_select',
                                        'width1' => '0',
                                        'width2' => '128',
                                        'width3' => '0',
                                        'widthGadget' => '100',
                                        'marginLeftError' => '386',
                                        'messageError' => '',
                                        'blocType' => 'text',
                                        'blocIcone' => '',
                                        'blocName' => 'rugbyPronosticSelect-'.$i.'-'.$key.'-1',
                                        'blocLegende' => '',
                                        'blocValue' => '',
                                        'blocFirstRow' => __('rugby_predictionKnockout_selectBox_'.$i.'_'.$key.'_1_firstRow'),
                                        'blocChoices' => $data,
                                        'blocHelp' => ''))
                                ?>
                                <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('style' => 'margin-left: 18px;', 'class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-1', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>
                            <?php else: ?>
                            <?php if($phase == "QF"){ ?>
                                    <div style="display: none;" class="country-name country-name-<?php echo $match['first_country']; ?>"><?php echo __($match['first_country']); ?></div>
                                <?php foreach ($match['team_complete'] as $name) : ?>
                                    <div style="display: none;" class="country-name country-name-<?php echo $name; ?>"><?php echo __($name); ?></div>
                                <?php endforeach; ?>
                                <?php
                                 $data = array();
                                 foreach ($match['team_complete'] as $e) {
                                     $data[$e] = __($e);
                                 }
                                include_component('interface', 'select', array(
                                        'noMargin' => true,
                                        'bloc' => 'home_kup_select',
                                        'width1' => '0',
                                        'width2' => '128',
                                        'width3' => '0',
                                        'widthGadget' => '100',
                                        'marginLeftError' => '386',
                                        'messageError' => '',
                                        'blocType' => 'text',
                                        'blocIcone' => '',
                                        'blocName' => 'rugbyPronosticSelect-'.$i.'-'.$key.'-1',
                                        'blocLegende' => '',
                                        'blocValue' => $match['first_country'],
                                        'blocFirstRow' => __($match['first_country']),
                                		'blocFirstValue' => $match['first_country'],
                                        'blocChoices' => $data,
                                        'blocHelp' => ''))
                                ?>
                                <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('style' => 'margin-left: 18px;', 'class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-1', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>
                             <?php  }else{?>

                                    <div class="country-name country-name-<?php echo $match['first_country']; ?>"><?php echo __($match['first_country']); ?></div>
                                    <?php echo image_tag('/image/default/rugby/teams/' . $match['first_country'] . '.png', array('class' => $match['first_country'], 'size' => '33x28', 'alt' => __($match['first_country']))) ?>
                                    <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-2', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>

                                <?php } ?>


                                <?php endif; ?>
                        <?php endif; ?>
                    </div>




                    <?php if ($i > 1) : ?>
                    <div class="country">
                        <input type="hidden" id="name-<?php echo $i; ?>-<?php echo $key; ?>-2" name="<?php echo $phase; ?>[<?php echo $key; ?>][]" value="<?php if ((isset($match['second_country']))  && (!is_array($match['second_country']))){ echo $match['second_country'];}else{ echo "0";}?>" />
                            <?php if (isset($match['second_country'])) : ?>
                                <?php if (is_array($match['second_country'])) : ?>
                                     <?php foreach ($match['second_country'] as $name) : ?>
                                        <div style="display: none;" class="country-name country-name-<?php echo $name; ?>"><?php echo __($name); ?></div>
                                    <?php endforeach; ?>
                                    <?php
                                     $data = array();
                                     foreach ($match['second_country'] as $e) {
                                         $data[$e] = __($e);
                                     }
                                    include_component('interface', 'select', array(
                                            'noMargin' => true,
                                            'bloc' => 'home_kup_select',
                                            'width1' => '0',
                                            'width2' => '128',
                                            'width3' => '0',
                                            'widthGadget' => '100',
                                            'marginLeftError' => '386',
                                            'messageError' => '',
                                            'blocType' => 'text',
                                            'blocIcone' => '',
                                            'blocName' => 'rugbyPronosticSelect-'.$i.'-'.$key.'-2',
                                            'blocLegende' => '',
                                            'blocValue' => '',
                                            'blocFirstRow' => __('rugby_predictionKnockout_selectBox_'.$i.'_'.$key.'_2_firstRow'),
                                            'blocChoices' => $data,
                                            'blocHelp' => ''))
                                    ?>
                                    <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('style' => 'margin-left: 18px;', 'class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-2', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>
                                 <?php else : ?>
                                 <?php if($phase == "QF"){ ?>
                                    <div style="display: none;" class="country-name country-name-<?php echo $match['second_country']; ?>"><?php echo __($match['second_country']); ?></div>
                                 <?php foreach ($match['team_complete'] as $name) : ?>
                                    <div style="display: none;" class="country-name country-name-<?php echo $name; ?>"><?php echo __($name); ?></div>
                                <?php endforeach; ?>
                                 <?php
                                 $data = array();
                                 foreach ($match['team_complete'] as $e) {
                                     $data[$e] = __($e);
                                 }
                                include_component('interface', 'select', array(
                                        'noMargin' => true,
                                        'bloc' => 'home_kup_select',
                                        'width1' => '0',
                                        'width2' => '128',
                                        'width3' => '0',
                                        'widthGadget' => '100',
                                        'marginLeftError' => '386',
                                        'messageError' => '',
                                        'blocType' => 'text',
                                        'blocIcone' => '',
                                        'blocName' => 'rugbyPronosticSelect-'.$i.'-'.$key.'-2',
                                        'blocLegende' => '',
                                        'blocValue' => '',
                                        'blocFirstRow' => __($match['second_country']),
                                		'blocFirstValue' => $match['second_country'],
                                        'blocChoices' => $data,
                                        'blocHelp' => ''))
                                ?>
                                <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('style' => 'margin-left: 18px;', 'class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-2', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>

                                                             <?php  }else{?>

                                    <div class="country-name country-name-<?php echo $match['second_country']; ?>"><?php echo __($match['second_country']); ?></div>
                                    <?php echo image_tag('/image/default/rugby/teams/' . $match['second_country'] . '.png', array('class' => $match['second_country'], 'size' => '33x28', 'alt' => __($match['second_country']))) ?>
                                    <?php echo image_tag('/image/default/rugby/checkbox_unchecked.png', array('class' => 'pronostic-checkbox', 'id' => $i . '-' . $key . '-2', 'onclick' => 'chooseWinner(this);', 'size' => '12x12', 'alt' => __('label_rugby_choose_winner'))) ?>

                                <?php } ?>


                                <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($i > 1) : ?>
                        <div class="date">
                            <?php echo $match['date']; ?>
                        </div>
                        <div class="buttons">
                            <?php echo image_tag('/image/default/rugby/button_help.png', array('size' => '14x13', 'alt' => __('label_rugby_help'))) ?>
                            <?php echo image_tag('/image/default/rugby/button_graphic.png', array('size' => '14x13', 'alt' => __('label_rugby_graphic'))) ?>
                        </div>
                    <?php endif; ?>
                </div>


            <?php endforeach; ?>
        </div>




        <?php if ($kupData['status'] < 3 && $kupData['status'] != -1) : ?>
            <a href="javascript:emptyColumn(<?php echo $i; ?>);">
                <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_erase_pronostics.png', array('class' => 'erase', 'size' => '173x34', 'alt' => __('label_rugby_erase_pronostics'))) ?>
            </a>
        <?php endif; ?>
    </div>




<?php $i--; ?>
<?php endforeach; ?>
</form>
<script type="text/javascript">
    function emptyColumn(column) {
        for (var i = column; i > 0; i--) {
            $(".country", $(".phase-" + i)).each(function() {
                if (column != "4") {
                	$("input[type=hidden]", $(this)).get(0).value = "";
                	$("img", $(this)).remove();
                	$(".country-name", $(this)).remove();
                	$("input[type=checkbox]", $(this)).remove();
				}else if(column == "4"){
					$(this).click(emptyColumn(1));
					$(this).click(emptyColumn(2));
					$(this).click(emptyColumn(3));
					$(this).click(hideLabelSelect());
					$("img[src='/image/default/rugby/checkbox_checked.png']", $(this)).attr('src','/image/default/rugby/checkbox_unchecked.png');
				};
            });
            $(".pronostic-checkbox", $(".phase-" + (i+1))).each(function() {
                $(this).get(0).checked = false;
            });
        }
        var arrayLabelByDefault = new Array;
		for ( var int = 0; int <= $('ul[id^=rugbyPronosticSelect]').length; int++) {
			arrayLabelByDefault.push($('ul[id^=rugbyPronosticSelect]').eq(int).find("li a").html());
		}

    	for ( var int2 = 0; int2 <= arrayLabelByDefault.length; int2++) {
    		$('td[id^=rugbyPronosticSelect] a span[class=ui-selectmenu-status]').eq(int2).html(arrayLabelByDefault[int2]);
		}
    }

    function chooseWinner(box) {
        if (box.src.indexOf('checkbox_unchecked.png') > 0) {
            box.src = '/image/default/rugby/checkbox_checked.png';

            var data = $(box).get(0).id.split('-');
            $("#" + data[0] + "-" + data[1] + "-" + (data[2]%2+1)).get(0).src = '/image/default/rugby/checkbox_unchecked.png';
            var phase = $(".phase").eq(5 - data[0]);
            var match = $(".match", phase).eq(Math.floor(data[1] / 2));
            country = $(".country", match).eq(data[1] % 2);

            var countrySymbol = $("input[type=hidden]", $(box).parent()).get(0).value;
            if (countrySymbol != "0") {

            $("input[type=hidden]", country).get(0).value = countrySymbol;
            $(".country-name", country).remove();
            $("img", country).remove();

            var countryName = $(".country-name-" + countrySymbol, $(box).parent()).clone();
            countryName.eq(0).show();
            var img = document.createElement('img');
            img.src = "/image/default/rugby/teams/" + countrySymbol + ".png";
            img.setAttribute('class', countrySymbol);
            img.setAttribute('width', '33');
            img.setAttribute('height', '28');
            var checkbox = $(box).clone().css('margin-left','5px');
            checkbox.get(0).id = (data[0]-1) + "-" +Math.floor(data[1] / 2) + "-" + (data[1] % 2 + 1);
            checkbox.get(0).src = '/image/default/rugby/checkbox_unchecked.png';
            }
			var idSelect = $(box).get(0).id;

            var optionValue = $('select[id=rugbyPronosticSelect-'+idSelect+'] option:selected').val();
            if(optionValue != "0") {

                var rowSelected = $('ul[id=rugbyPronosticSelect-'+idSelect+'-menu] li[class=ui-selectmenu-item-selected] a').html();
                $('ul li:contains('+rowSelected+')').hide();
                $('select').selectmenu('refresh',true);

                country.append(countryName);
                country.append(img);
                if (data[0] > 2) {
                    country.append(checkbox);
                    }
            }
        } else {
            box.src = '/image/default/rugby/checkbox_unchecked.png';
        }
    }

    $(document).ready(function() {
       $('.formInputSelect').change(function() {
            data = this.id.split('-');
            $('#name-'+data[1] + '-' + data[2] + '-' + data[3]).get(0).value = this.value;
       });
    });

    $('select[id^=rugbyPronosticSelect]').live('change', function() {
    	$('ul li').show();
    	var idSelect = $(this).attr('id');
    	var ariaAttr = $('ul[id='+idSelect+'-menu]').attr("aria-activedescendant");
    	var rowSelected = $('ul[id='+idSelect+'-menu] li a[id='+ariaAttr+']').html();
    	$('ul li:contains('+rowSelected+')').hide();

    	$(this).click(hideLabelSelect());
    });

	function hideLabelSelect(){

		// THIS BREAKS IE BIG TIME
		// http://stackoverflow.com/questions/4610652/jquery-select-option-disabled-if-selected-in-other-select
		// http://stackoverflow.com/questions/2031740/hide-select-option-in-ie-using-jquery
		// http://stackoverflow.com/questions/1275383/jquery-remove-select-options-based-on-another-select-selected-need-support-for-a
		// http://work.arounds.org/issue/96/option-elements-do-not-hide-in-IE/

		/*
		var arrayLabelSelect = new Array;
    	for ( var int = 0; int <= $('li[class^=ui-selectmenu-item-selected] a').length; int++) {
    		arrayLabelSelect.push($('li[class^=ui-selectmenu-item-selected] a').eq(int).html());
		}

		for ( var int2 = 0; int2 < arrayLabelSelect.length; int2++) {
			$('ul li a:contains('+arrayLabelSelect[int2]+')').parent().hide();
		}
		*/
	}
	$(document).ready(function() {
		$(this).click(hideLabelSelect());
	});
</script>
<div style="clear: both; width: 60%; height: 34px;" align="center">
	<?php if ($kupData['status'] < 3 && $kupData['status'] != -1): ?>
	<a href="javascript:$('#final-phases-form').get(0).submit()"> <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_save.png', array('style' => 'float: right; margin-right: 33px;', 'size' => '119x34', 'alt' => __('label_rugby_save'))) ?>
	</a>
	<?php endif ?>
</div>


<tr class="<?php echo ($index%2 == 1) ? 'even' : 'odd'?>">
    <td>
        	<table style="width: 100%; margin:0px; <?php echo (isset($resultSets[$index]['properties']) && isset($resultSets[$index]['properties']['sets'])) ? 'height: 75px;': 'height: 40px;'?>">
            	<?php if(isset($kupGameData['type']) && $kupGameData['type'] == 'ic' ) :?>
            	<tr>
            		<td class="flag flag-left">
            			<?php echo image_tag($kupGameData['team1avatar'], array('size' => '40x26'))?>
            		</td>
                	<td class="player1">
                       	<div title="<?php echo $kupGameData['team1title'] ?>">
                       		<?php echo util::coupe(html_entity_decode($kupGameData['team1title']), 12, '..') ?>
                       		<span class="seed-position">
                       			<?php echo $kupGameData['properties']['first_entry_seed_position'] != '' ? ' ('.$kupGameData['properties']['first_entry_seed_position'].')' : '' ?>
                       		</span>
                       	</div>
                   	</td>
                    <td style="width:27px; vertical-align: middle;">
                    	<div class="tennis-pellet <?php echo $kupGameData['team1title'] == $kupGameData['winner']['name'] ? 'pellet-winner' : '' ?>"></div>
                    </td>
                    <td class="separator">-</td>
                    <td style="width:27px; vertical-align: middle;">
                    	<div class="tennis-pellet <?php echo $kupGameData['team2title'] == $kupGameData['winner']['name'] ? 'pellet-winner' : '' ?>"></div>	
                    </td>
                    <td class="player2">
                     	<div title="<?php echo $kupGameData['team2title'] ?>">
                       		<?php echo util::coupe(html_entity_decode($kupGameData['team2title']), 12, '..')?>
                       		<span class="seed-position">
                       			<?php echo $kupGameData['properties']['second_entry_seed_position'] != '' ? ' ('.$kupGameData['properties']['second_entry_seed_position'].')' : '' ?>
                       		</span>
                       	</div>
                	</td>
                	<td class="flag flag-right">
            			<?php echo image_tag($kupGameData['team2avatar'], array('size' => '40x26'))?>
            		</td>
            	</tr>
            	<?php elseif (isset($kupGameData['type']) && $kupGameData['type'] == 'se') :?>
            	<tr>
            		<td class="flag flag-left">
            			<?php echo image_tag($kupGameData['team1avatar'], array('size' => '40x26'))?>
            		</td>
                	<td class="player1">
                       	<div title="<?php echo $kupGameData['team1title'] ?>">
                       		<?php echo util::coupe(html_entity_decode($kupGameData['team1title']), 12, '..') ?>
                       		<span class="seed-position">
                       			<?php echo $kupGameData['properties']['first_entry_seed_position'] != '' ? ' ('.$kupGameData['properties']['first_entry_seed_position'].')' : '' ?>
                       		</span>
                       	</div>
                   	</td>
                    <td style="width:27px; vertical-align: middle;">
                    	<p class="player-score">
                    		<?php echo isset($kupGameData['scoreTeam1']) ? $kupGameData['scoreTeam1'] : '' ?>
                    	</p>
                    </td>
                    <td class="separator">-</td>
                    <td style="width:27px; vertical-align: middle;">
                    	<p class="player-score">
                    		<?php echo isset($kupGameData['scoreTeam2']) ? $kupGameData['scoreTeam2'] : '' ?>
                    	</p>	
                    </td>
                    <td class="player2">
                     	<div title="<?php echo $kupGameData['team2title'] ?>">
                       		<?php echo util::coupe(html_entity_decode($kupGameData['team2title']), 12, '..') ?>
                       		<span class="seed-position">
                       			<?php echo $kupGameData['properties']['second_entry_seed_position'] != '' ? ' ('.$kupGameData['properties']['second_entry_seed_position'].')' : '' ?>
                       		</span>
                       	</div>
                	</td>
                	<td class="flag flag-right">
            			<?php echo image_tag($kupGameData['team2avatar'], array('size' => '40x26'))?>
            		</td>
            	</tr>
            	<?php elseif(isset($kupGameData['type']) && $kupGameData['type'] == 'q') : ?>
            	<tr>
            		<td colspan="7" class="tennis-result-question" >
            			<?php echo $kupGameData['question'] ?>
            			<span>(<?php echo $kupGameData['questionAnswer'] ?>)</span>
            		</td>
            	</tr>
            	<?php endif;?>
            	<?php if(isset($resultSets[$index]['properties']) && isset($resultSets[$index]['properties']['sets'])) :?>
            	<tr>
            		<td class="td-sets" colspan="7">
	            	<?php foreach($resultSets[$index]['properties']['sets'] as $players) :?>
            		<div class="player-line">
            		<?php foreach($players as $sets => $values) :?>
            			<div class="sets <?php echo isset($values['winner']) ? 'orange' : ''?>">
            				<p>
            				<?php echo isset($values['set']) ? $values['set'] : '' ?>
            				<sup><?php echo isset($values['tieBreak']) ? $values['tieBreak'] : '' ?></sup>
            				</p> 
            			</div>
            		<?php endforeach;?>
            		</div>
            	<?php endforeach;?>
            		</td>
            	</tr>
            	<?php endif; ?>
        	</table>
    </td>
    <td>
    	<span class="result-predictions nomarge" title="<?php echo isset($kupGameData['prediction']) ? $kupGameData['prediction'] : '-' ?>">
    		<?php echo util::coupe(html_entity_decode(isset($kupGameData['prediction']) ? $kupGameData['prediction'] : '-'), 18, '..') ?>
    	</span>
    </td>
    <td>
        <img src="<?php echo isset($kupGameData['predictionResult']) ? $kupGameData['predictionResult'] : '' ?>" border="0" />
    </td>
    <td>
        <span class="result-points">
        	<?php echo isset($kupGameData['points']) ? $kupGameData['points'] : '-' ?> pts
        </span>
    </td>
</tr>
<?php if(isset($kupGameData['type']) && $kupGameData['type'] == 'q') : ?>
	<?php if(isset($kupGameData['questionLine']) && count($kupGameData['questionLine']) > 0) :?>
		<?php foreach ($kupGameData['questionLine'] as $questionline) :?>
	    	<tr class="<?php echo ($index%2 == 1) ? 'even' : 'odd'?>">
		    	<td style="height: 40px;" class="tennis-result-question">
		        	<?php echo $questionline['name'] ?>
		        </td>
		        <td class="result-predictions">
		        	<?php echo isset($questionline['prediction']) ? $questionline['prediction'] : '-' ?>
		        </td>
		        <td>
		        	 <img src="<?php echo isset($questionline['predictionResult']) ? $questionline['predictionResult'] : '' ?>" border="0" />
		        </td>
		        <td class="result-points">
		        	<?php echo isset($questionline['points']) ? $questionline['points'].' pts' : '-' ?>
		        </td>
		    </tr>
	    <?php endforeach;?>
	<?php endif;?>
	<?php if(isset($kupGameData['combo'])) :?>
	    	<tr class="<?php echo ($index%2 == 1) ? 'even' : 'odd'?>">
		    	<td style="height: 40px;" class="tennis-result-question">
		        	<?php echo $kupGameData['combo']['name'] ?>
		        </td>
		        <td class="result-predictions">
		        </td>
		        <td>
		        	 <img src="<?php echo isset($kupGameData['combo']['predictionResult']) ? $kupGameData['combo']['predictionResult'] : '-' ?>" border="0" />
		        </td>
		        <td class="result-points">
		        	<?php echo isset($kupGameData['combo']['points']) ? $kupGameData['combo']['points'].' pts' : '-' ?>
		        </td>
		    </tr>
	<?php endif;?>
	<tr class="sub-total">
		<td></td>
		<td class="<?php echo ($index%2 == 1) ? 'even' : 'odd'?>" colspan="2">
			<h2>SOUS TOTAL SCORE DÉTAILLÉ</h2>
		</td>
		<td class="<?php echo ($index%2 == 1) ? 'even' : 'odd'?>">
			<p>
			<?php echo $kupGameData['subTotal'] ?> pts
			</p>
		</td>
	</tr>
	<tr class="sub-total">
		<td></td>
		<td class="<?php echo ($index%2 == 1) ? 'odd' : 'even'?>" colspan="2">
			<h2>TOTAL MATCH</h2>
		</td>
		<td class="<?php echo ($index%2 == 1) ? 'odd' : 'even'?>">
			<p>
			<?php echo $kupGameData['totalMatch'] ?> pts
			</p>
		</td>
	</tr>
<?php endif;?>
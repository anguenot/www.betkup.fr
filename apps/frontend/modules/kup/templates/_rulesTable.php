<?php if (isset($questions['custom_rules'])) : ?>
<h2>
    <?php echo isset($title) ? $title : ''?>
</h2>
<table style="border-spacing: 0px; border-collapse:collapse;">
    <?php foreach ($questions as $question) : ?>
    <tr>
        <td class="rules-block-1">
            <div class="rules-block-1">
                <span class="tableauLegende">
                    <?php echo __($question['label'], array('%pts%' => '')) ?>
                </span>
            </div>
        </td>
        <td class="rules-block-2">
            <div class="rules-block-2">
                <?php echo image_tag('/images/kup/view/regle/tabFlecheVerte.png')?>
            </div>
        </td>
        <td class="rules-block-3">
            <div class="rules-block-3">
                <span class="tableauLegende2">
                    <?php echo $question['points'] . ' pts' ?>
                </span>
            </div>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php else : ?>
<h2>
    <?php echo $rules["title"] ?>
</h2>
<table style="border-spacing: 0px; border-collapse:collapse;">
    <?php for ($i = 0; $i < ($rules["nbSubSection"]); $i++) { ?>
	<tr>
		<td class="rules-block-1">
            <?php if ($rules["type"] == "choc"): ?>
            <img src="/images/kup/view/regle/chocMini.png" border="0" style="position: absolute;"/>
            <?php endif ?>
            <div class="rules-block-1">
                <?php if ($rules[$i]["orange"] != ""): ?>
                <p style="margin: 0px; height: 6px;"></p>
                <span class="tableauLegendeOrange">
                    <?php echo $rules[$i]["orange"] ?>
                </span>
                <br/>
                <span class="tableauLegendeSuite">
                    <?php echo $rules[$i]["legende"] ?>
                </span>
                <?php else: ?>
                <span class="tableauLegende"><?php echo $rules[$i]["legende"] ?> </span>
                <?php endif ?>
            </div>
        </td>
    <td class="rules-block-2">
        <div class="rules-block-2">
            <img src="<?php echo $rules[$i]["image"] ?>" border="0"/>
        </div>
    </td>
    <td class="rules-block-3">
        <div class="rules-block-3">
            <span class="tableauLegende2">
                <?php echo $rules[$i]["score"] . ' pts' ?>
            </span>
        </div>
    </td>
    <?php }?>
</table>
<?php endif; ?>
<p style="margin: 0px; height: 30px;"></p>
<script type="text/javascript">
    $(function () {
        $("div.regle tr:odd td div").addClass('kup_Rules_Table_TrEven_Td_Div');
        $("div.regle tr:even td div").addClass('kup_Rules_Table_TrOdd_Td_Div');
    });
</script>
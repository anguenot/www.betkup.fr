<div id="blocFormulaireConnecionPopup" style="overflow: hidden;">
    <form id="formConnectionPopup" name="formConnectionPopup" onsubmit="return false;" action="" method="POST">
        <br/>
        <?php echo $form['email']->renderLabel() ?><br/>
        <?php echo $form['email']->render() ?><br/>
        <br/>
        <?php echo $form['password']->renderLabel() ?><br/>
        <?php echo $form['password']->render() ?><br/>
        <br/>
        <?php echo $form->renderHiddenFields(); ?>
        <input type="button" name="Continuer" id="buttonContinue" value="Continuer">
    </form>
</div>
<script type="text/javascript">
$(function() {
    $('#buttonContinue').click(function(key) {
        $('#blocFormulaireConnecionPopup').fadeIn("500");
        $('#blocFormulaireConnecionPopup').load(
        $(this).parents('form').attr('action'), { query: this.value + '*' }
    );
    });
});
</script>
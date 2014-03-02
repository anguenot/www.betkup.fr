<div class="titleFashion">
    <?php echo image_tag('moncompte/title_wall_fr.png', array('alt'=>'Wall', 'size'=>'544x54') ) ?>
</div>
<div class="blocWall">
    <a id="ancre-blocMessage"></a>
    <div class="blocMessage">
        <div class="avatar">
            <img alt="avatar" src="/images/kup/view/wall/avatar2.png" height="50" width="50" />
            <p class="name">Tommy D-klik</p>
        </div>
        <div class="formMessage">
            <form action="" method="post" name="frmWallMessage" class="frmWallMessage">
                <textarea name="frmWallMessage_message" id="frmWallMessage_message"></textarea>
                <div class="frmWallMessageLeft">
                    <input type="checkbox" name="frmWallMessage_publierFB" id="frmWallMessage_publierFB" value="1" /><label for="frmWallMessage_publierFB"> Publier mon commentaire sur Facebook</label>
                </div>
                <div class="frmWallMessageRight">
                    <span id="charlimitinfo">300 caractères restants</span>
                    <input type="image" src="/images/kup/view/wall/btPost.png" />
                </div>
            </form>
        </div>
    </div>
    <div style="clear:both"></div>

    <?php include_component('kup', 'wallComment', array(
        'avatar' => '/images/kup/view/wall/avatar.png' ,
        'nom' => 'Jean-Paul Uchon',
        'datecomment' => 'Le 19/06/2011',
        'heurecomment' => 'à 11h36',
        'responseAt' => 'Elo et JeanMi',
        'comment' => 'Praesens ipse quoque adrogantis ingenii, considerans incitationem eius ad multorum augeri discrimina, non maturitate vel consiliis mitigabat.'
        )) ?>

    <?php include_component('kup', 'wallComment', array(
        'avatar' => '/images/kup/view/wall/avatar3.png' ,
        'nom' => 'Elo et JeanMi',
        'datecomment' => 'Le 19/06/2011',
        'heurecomment' => 'à 11h36',
        'responseAt' => '',
        'comment' => 'Quoque adrogantis ingenii, considerans incitationem eius ad multorum augeri discrimina, non maturitate vel consiliis mitigabat ??'
        )) ?>

</div>
<script type="text/javascript">
    function limitChars(textid, limit, infodiv) {
        var text = $('#'+textid).val();
        var textlength = text.length;
        if(textlength > limit) {
            $('#' + infodiv).html('Vous ne pouvez pas écrire plus de '+limit+' caractères !');
            $('#'+textid).val(text.substr(0,limit));
            return false;
        } else {
            $('#' + infodiv).html(''+ (limit - textlength) +' caractères restants');
            return true;
        }
    }

    $(function(){
        $('#frmWallMessage_message').keyup(function(){
            limitChars('frmWallMessage_message', 300, 'charlimitinfo');
        });
    });
</script>
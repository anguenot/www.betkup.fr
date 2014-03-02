<style type="text/css">
    .like-page-container {
        width: 600px;
        margin: 0 auto;
    }

    a img {
        border: none;
        text-decoration: none;
    }
</style>
<div class="like-page-container">
    <a href="<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url') ?>home?inviteFriends=1">
        <?php echo image_tag('/image/default/facebook_ligue1_2012/like_page/image_like_page.jpeg', array('size' => '600x700')) ?>
    </a>
</div>
<script type="text/javascript">
    $(function () {
        $('a').click(function () {
            top.location.href = $(this).attr('href');
        });
    });
</script>
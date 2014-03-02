<?php if (isset($tweets) && count($tweets) > 0) : ?>
<div id="tweets-container">
    <?php foreach ($tweets as $tweet) : ?>
    <?php if (isset($tweet['user'])) : ?>
        <?php include_component('footer', 'thumbnailTweet', array('tweet' => $tweet)) ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>
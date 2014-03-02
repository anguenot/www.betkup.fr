<table class="predictions-table-news">
    <tbody>
    <?php if (!isset($rssFeed['error'])) : ?>
        <?php foreach ($rssFeed['feed'] as $feed) : ?>
        <tr>
            <td>
                <h4>
                    <a target="_blank" href="<?php echo $feed['link']; ?>">
                        <?php echo date('\L\e d/m/Y à h:i:s', strtotime($feed['pubDate']))?>
                    </a>
                </h4>

                <p>
                    <a target="_blank" href="<?php echo $feed['link']; ?>">
                        <?php echo $feed['title']?>
                    </a>
                </p>
            </td>
        </tr>
            <?php endforeach; ?>
        <?php else : ?>
    <tr>
        <td>
            <p>
                <?php echo __($rssFeed['error']['message']);?>
            </p>
        </td>
    </tr>
        <?php endif;?>
    </tbody>
</table>
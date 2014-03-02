<div class="tweet">
    <table>
        <tbody>
        <tr>
            <td class="tweet-image">
                <?php echo image_tag($tweet['user']['profile_image_url_https']); ?>
            </td>
            <td class="tweet-text">
                <div>
                    <h3>
                        <?php echo html_entity_decode($tweet['user']['name']) ?>
                        <?php echo html_entity_decode($tweet['user']['screen_name']) ?>
                    </h3>
                <span class="tweet-date">
                    <?php echo html_entity_decode($tweet['created_at']) ?>
                </span>

                    <p>
                        <?php echo html_entity_decode($tweet['text']) ?>
                    </p>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
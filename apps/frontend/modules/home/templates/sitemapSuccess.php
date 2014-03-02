<style type="text/css">

    #sitemap-container {
        width: 970px;
        margin: 120px 0 0 9px;
        padding-top: 20px;
        background: white;
        border: 1px solid #cccccc;
        -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.4);
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.4);
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-topright: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    h1 {
        text-align: center;
        font: bold 30px "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #444444;
        margin-bottom: 20px;
    }

    h2 {
        text-align: left;
        font: bold 20px "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #e8651e;
    }

    h3 {
        text-align: left;
        font: bold 16px "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #444444;
    }

    table {
        width: 70%;
        margin: 0 auto;
    }

    table td {
        text-align: left;
        vertical-align: top;
    }

    table td ul {
        list-style: none;
    }

    table td ul li {
        height: 20px;
        line-height: 20px;
        text-indent: 20px;
    }

    table td ul li a {
        text-decoration: none;
        color: #444444;
        font: normal 12px Arial, sans-serif;
    }

    table td ul li a:hover {
        text-decoration: underline;
    }
</style>

<div id="sitemap-container">
    <h1>Plan du site</h1>
    <table>
        <tr>
            <?php foreach ($sitemapData as $type => $sitemap) : ?>
            <?php if ($type == 'static') : ?>
                <td>
                <h2>Informations pratiques</h2>
                <br/>
                <ul>
                    <?php foreach ($sitemap[0] as $static) : ?>
                    <li>
                        <a href="<?php echo $static['link'] ?>">
                            <?php echo $static['title'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php elseif ($type == 'sports') : ?>
                <br/>
                <h2 class="colored">Les dernières Kups</h2>
                <?php foreach ($sitemap as $sportName => $sports) : ?>
                    <br/>
                    <h3>
                        <?php echo __('text_sitemap_title_' . $sportName) ?>
                    </h3>
                    <br/>
                    <ul>
                        <?php foreach ($sports as $sport) : ?>
                        <li>
                            <a href="<?php echo $sport['link'] ?>">
                                <?php echo $sport['title'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endforeach; ?>
                <?php
            elseif ($type == 'other') : ?>
                </td>
                <td>
                    <h2>Promos et challenges</h2>
                    <?php foreach ($sitemap as $otherName => $others) : ?>
                    <br/>
                    <h3>
                        <?php echo $otherName ?>
                    </h3>
                    <ul>
                        <?php foreach ($others as $other) : ?>
                        <li>
                            <a href="<?php echo $other['link'] ?>">
                                <?php echo $other['title'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endforeach; ?>
                </td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </table>
    <div style="height: 40px;"></div>
</div>
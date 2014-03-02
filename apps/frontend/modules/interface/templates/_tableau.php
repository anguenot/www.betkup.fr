<div class="tableau">
    <?php foreach ($datas->getRaw('links') as $lien): ?>
    <a class="<?php echo $lien["class"] ?>" href="<?php echo url_for($lien["link"]) ?>"><?php echo $lien["name"] ?></a>
    <span class="barreVerticale"> | </span>
    <?php endforeach ?>

    <table cellpadding="0" cellspacing="0" border="0" width="678" style="margin-top: 6px;">

        <tr>
            <?php foreach ($datas["legende"] as $legende): ?>
            <td style="background: url('/images/interface/tableau/backgroundLegende.png');" width="<?php echo $legende["width"] ?>" height="42" align="<?php echo $legende["align"] ?>" valign="middle">
                <span class="legende"><?php echo $legende["title"] ?></span>
            </td>
            <?php endforeach ?>
        </tr>

        <?php foreach ($datas["rows"] as $row): ?>
        <tr>
            <?php foreach ($row as $cellule): ?>
            <td style="border-bottom: 1px solid #E0E0E0;" height="28" align="<?php echo $cellule["align"] ?>" valign="middle">
                <?php if (isset($cellule['link'])) : ?>
                    <?php if (isset($cellule["picture"])) : ?>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td align="left" width="20">
                                <a href="<?php echo $cellule['link'] ?>">
                                    <img src="<?php echo $cellule["picture"] ?>" border="0" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo $cellule['link'] ?>">
                                    <span class="data <?php echo $cellule["class"] ?>"><?php echo $cellule["value"] ?></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <?php else: ?>
                    <a href="<?php echo $cellule['link'] ?>">
                        <span class="data <?php echo $cellule["class"] ?>" style="margin-left: 12px;"><?php echo $cellule["value"] ?></span>
                    </a>
                    <?php endif ?>
                <?php else : ?>
                <?php if (isset($cellule["picture"])) : ?>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td align="left" width="20">
                                <img src="<?php echo $cellule["picture"] ?>" border="0" alt="">
                            </td>
                            <td>
                                <span class="data <?php echo $cellule["class"] ?>"><?php echo $cellule["value"] ?></span>
                            </td>
                        </tr>
                    </table>

                    <?php else: ?>
                    <span class="data <?php echo $cellule["class"] ?>" style="margin-left: 12px;"><?php echo $cellule["value"] ?></span>
                    <?php endif ?>
                <?php endif; ?>
            </td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>

    </table>

</div>
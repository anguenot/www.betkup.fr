<div style="text-align: left;">
    <?php echo image_tag('/image/default/challenge/promos/promo_bonus_edf_2012.png', array('size' => '710x385'))?>
</div>

<div id="promo-description">
    <h2>Joueurs Betkup ce bonus vous concerne !</h2>

    <p>A l'occasion des matchs de qualification pour la Coupe du Monde, de l'Equipe de France,
        Betkup vous rembourse votre mise si les français devaient perdre leurs matchs.</p>

    <p>&nbsp;</p>

    <p>Venez Pariez sur les Kups Equipe de France et tentez de décrocher une place payée pour vous
        partager au moins <span class="important">500 €</span> (sur les 2 Kups). Et pour montrer
        notre soutient à l'EDF, si ils perdent leurs matchs, Betkup vous rembourse votre mise, pour
        chacune des kups perdues !</p>

    <p>&nbsp;</p>

    <p>
        Alors à vos pronos !
    </p>

    <div style="height: 15px;"></div>
    <a class="more-infos-link" href="#more-infos">
        <?php echo __('text_promo_euro_2012_more_infos_link')?>
    </a>
</div>

<div id="promo-bonnus">
    <h2></h2>
    <table>
        <tbody>
        <tr>
            <td class="pellet-td">
                <span class="pellet">1</span>
            </td>
            <td>
                <p>
                    Créez un compte complet ou surclassez un compte simple
                </p>
            </td>
        </tr>
        <tr>
            <td class="pellet-td">
                <span class="pellet">2</span>
            </td>
            <td>
                <p>
                    Pronostiquez sur au moins une des 2 Kups EDF
                </p>
            </td>
        </tr>
        <tr>
            <td class="pellet-td">
                <span class="pellet">3</span>
            </td>
            <td>
                <p>
                    Si l'EDF perd votre mise remboursé en Bonus Betkup !
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%; border-collapse: collapse; border-spacing: 0;">
                    <tr>
                        <td style="text-align: center; border: none;">
                            <?php echo image_tag('/image/default/challenge/challenges/avatar/promos_edf_2012_match_finland_france.jpeg', array('size' => '100x72'))?>
                            <h2>Finlande vs France</h2>
                            <a href="<?php echo url_for(array(
                                                             'module'  => 'kup',
                                                             'action'  => 'view',
                                                             'uuid'    => '20129002'
                                                        ))?>">
                                <?php echo image_tag('/images/interface/prediction_button.png', array('size' => '156x63'))?>
                            </a>
                        </td>
                        <td style="text-align: center; border: none;">
                            <?php echo image_tag('/image/default/challenge/challenges/avatar/promos_edf_2012_match_france_bielorussie.jpeg', array('size' => '100x72'))?>
                            <h2>France vs Biélorussie</h2>
                            <a href="<?php echo url_for(array(
                                                             'module'  => 'kup',
                                                             'action'  => 'view',
                                                             'uuid'    => '20129003'
                                                        ))?>">
                                <?php echo image_tag('/images/interface/prediction_button.png', array('size' => '156x63'))?>
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="td-how-to">
                <div class="box-how-to-link">
                    <span class="table-promos-link-or">ou</span><br/>
                    <table class="table-promos-link-how-to">
                        <tr>
                            <td>
                                <div class="picto"></div>
                            </td>
                            <td>
                                <a href="<?php echo url_for('home/howto')?>">
                                    En savoir plus sur le fonctionnement
                                </a>
                            </td>
                        </tr>
                    </table>


                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div id="promo-warning">
    <table>
        <tr>
            <td id="promo-plus" class="img-more-info"></td>
            <td id="more-infos">
                <?php echo __('text_promo_euro_2012_more_infos')?>
            </td>
        </tr>
    </table>
    <div id="more-infos-contener">
        <p>
            1 - Cette offre s'adresse aux joueurs qui réalisent les actions suivante entre le 29
            Aout et le 11 Septembre :
            <br/>
            <br/>
            - Ouverture (si pas encore effectuée) d'un compte complet (ou surclassement d'un compte
            simple)
            <br/>
            - Réaliser et enregistrer un pronostic sur une des 2 kups "Equipe de France".
            <br/>
            <br/>
            2 - A l'occasion des Kups "Equipe de France". Betkup a mis en place un bonus
            événementiel. Les joueurs peuvent ainsi se voir créditer d'un Bonus Betkup de 4€ ou 8€
            si il ont pris part aux Kups concérnées et si un les Français perdent un ou deux matchs.
            <br/><br/>
            3- Les bonus offerts dans le cadre de cette opération sont soumis à une condition de
            recyclage. Ainsi leur montant ne peut être retiré directement et chaque joueur se voyant
            offrir un bonus devra en miser le montant équivalent avant de pouvoir le retirer sur son
            compte.
            <br/><br/>
            4- Cette offre est limitée dans le temps. Ainsi elle ne concerne que les joueurs qui
            réalisent les actions nécessaires entre le 29 Aout et le 11 Septembre.
            <br/><br/>
            5- Betkup se réserve le droit d'exclure un client inscrit et/ou un nouveau joueur de
            toute participation à la promotion en cas de soupçons portant sur une manipulation, une
            fraude ou un manquement aux conditions de participation. Dans un tel cas, le client perd
            tout droit éventuel à un bonus.
            <br/><br/>
            6 - La saisie de données invalides et/ou l'altération des faits sont interdites et sont
            passibles de poursuites auprès du tribunal ou des autorités compétentes.
            <br/><br/>
            7 - La société se réserve le droit de suspendre le programme "bonus Betkup soutient
            l'Equipe de France" à tout moment et sans la moindre explication.
        </p>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#promo-plus').click(function () {

            if ($(this).parent().hasClass('open')) {
                $(this).parent().removeClass('open');
                $('#more-infos-contener').hide();
            } else {
                $(this).parent().addClass('open');
                $('#more-infos-contener').show();
            }
        });
        $('.more-infos-link').click(function () {
            $('#promo-plus').parent().addClass('open');
            $('#more-infos-contener').show();
        });
    });
</script>
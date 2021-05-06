<div class="panelFilter">
    <form action="<?= $router->generate('filterSearch') ?>" method="get">
        <div class="formFilter">
            <div class="nageurContainer">
                <?php
                $resultFilter = $conn->singleQuery('SELECT * FROM nageur', 'rc');
                $rowNumber = $resultFilter['rowCount'];
                $nageurArray = [];
                for ($i = 0; $i < $rowNumber; $i++) {
                    $nageurArray += array($resultFilter['resultQuery'][$i]->ngr_id => $resultFilter['resultQuery'][$i]->ngr_nom . ' ' . $resultFilter['resultQuery'][$i]->ngr_prenom);
                }
                if (isset($_GET['nageur'])) {
                    $getNgrID = (int)$_GET['nageur']; // pour empecher le passage en parametre non int dans l'url
                } else {
                    $getNgrID = 0;
                }
                ?>
                <p>selectionner un nageur</p>
                <select name="nageur">
                    <option value="">sans préference</option>
                    <?php if (isset($getNgrID) && !empty($getNgrID)) : ?>
                        <option selected="selected" value="<?= $getNgrID ?> "><?= $nageurArray[$getNgrID] ?></option>
                    <?php endif ?>
                    <?php foreach ($resultFilter['resultQuery'] as $nageur) : ?>
                        <?php if ($nageur->ngr_nom !== $nageurArray[$getNgrID]) : ?>
                            <option value="<?= $nageur->ngr_id ?>"><?= $nageur->ngr_prenom . ' ' . $nageur->ngr_nom ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="clubContainer">
                <?php
                $resultFilter = $conn->singleQuery('SELECT * FROM club', 'rc');
                $rowNumber = $resultFilter['rowCount'];
                $clubArray = [];
                for ($i = 0; $i < $rowNumber; $i++) {
                    $clubArray += array($resultFilter['resultQuery'][$i]->cb_id => $resultFilter['resultQuery'][$i]->cb_nom);
                }

                if (isset($_GET['club'])) {
                    $getClubID = (int)$_GET['club']; // pour empecher le passage en parametre non int dans l'url
                } else {
                    $getClubID = 0;
                }
                ?>
                <p>selectionner un club</p>
                <select name="club">
                    <option value="">sans préference</option>
                    <?php if (isset($getClubID) && !empty($getClubID)) : ?>
                        <option selected="selected" value="<?= $getClubID ?>"><?= $clubArray[$getClubID] ?></option>
                    <?php endif ?>
                    <?php foreach ($resultFilter['resultQuery'] as $club) : ?>
                        <?php if ($club->cb_nom !== $clubArray[$getClubID]) : ?>
                            <option value="<?= $club->cb_id ?>"><?= $club->cb_nom ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="niveauContainer">
                <?php
                $resultFilter = $conn->singleQuery('SELECT * FROM niveau', 'rc');
                $rowNumber = $resultFilter['rowCount'];
                // TABLEAU REPRIS DANS CHAQUE CONTAINER AFIN DE GARDE EN MÉMOIRE LE FILTRE SELECTIONNÉ
                //Je recreer un nouveau tableau avec comme clés les id des resultats de ma requete associés à leurs valeurs
                $niveauArray = [];
                for ($i = 0; $i < $rowNumber; $i++) {
                    $niveauArray += array($resultFilter['resultQuery'][$i]->nv_id => $resultFilter['resultQuery'][$i]->nv_nom);
                }
                if (isset($_GET['niveau'])) {
                    $getNvID = (int) $_GET['niveau']; // pour empecher le passage en parametre non int dans l'url
                } else {
                    $getNvID = 0;
                }
                ?>
                <p>selectionner un niveau</p>
                <select name="niveau">
                    <option value="">sans préference</option>
                    <?php if (isset($getNvID) && !empty($getNvID)) : ?>
                        <option selected="selected" value="<?= $getNvID ?? 0 ?>"><?= $niveauArray[$getNvID] ?></option>
                    <?php endif ?>
                    <?php foreach ($resultFilter['resultQuery'] as $niveau) : ?>
                        <?php if ($niveau->nv_nom !== $niveauArray[$getNvID]) : ?>
                            <option value="<?= $niveau->nv_id ?? 0 ?>"><?= $niveau->nv_nom ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: none" class="copyKeyWordSearch">
                <input value="<?= $_GET['valuesearch'] ?? $_GET['keyWordSearch'] ?? '' ?>" name="keyWordSearch" type="text">
            </div>
        </div>
        <div class="buttonValidFilter">
            <button name="validFilter" type="submit"> appliquer</button>
        </div>
    </form>
</div>
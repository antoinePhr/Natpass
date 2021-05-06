<?php

use \Antoine\Database;

require_once '../src/Database.php';
require 'home.php';
$pageTitle = "Selectionner vos filtres";
$styleSheetFilter = "css/filterSearch.css";
$result = null; // reset de la variable result pour éviter conflit avec ancien resultat
//"SELECT * FROM video WHERE video.vd_fk_ngr_id = ?"
if (isset($_GET['validFilter'])) {
    $conn = new Database('natpass');
    $params = [];
    $club = isset($_GET['club']) ? htmlentities($_GET['club']) : '';
    $niveau = isset($_GET['niveau']) ? htmlentities($_GET['niveau']) : '';
    $nageur = isset($_GET['nageur']) ? htmlentities($_GET['nageur']) : '';
    $keyWordSearch = isset($_GET['keyWordSearch']) ?  htmlentities($_GET['keyWordSearch']) : '';

    // si filtre par club
    if ($club != null && $niveau == null && $nageur == null) {
        // CASE : Club non null + maybe keyword search
        $query = "SELECT * FROM video INNER JOIN nageur ON video.vd_fk_ngr_id = nageur.ngr_id WHERE nageur.ngr_fk_cb_id = ?";
        // avec mot clé
        if (isset($keyWordSearch) && !empty($keyWordSearch)) {
            $keyWordSearch = '%' . $keyWordSearch . '%';
            $query .= " AND video.vd_titre LIKE ?";
            array_push($params, $club, $keyWordSearch);
        }
        // sans mot clé
        else {
            array_push($params, $club);
        }
    }
    // si filtre par niveau
    else  if ($niveau != null && $club == null && $nageur == null) {
        $query = "SELECT * FROM video INNER JOIN nageur ON video.vd_fk_ngr_id = nageur.ngr_id WHERE nageur.ngr_fk_nv_id = ?";
        //avc mot clé
        if (isset($keyWordSearch) && !empty($keyWordSearch)) {
            $keyWordSearch = '%' . $keyWordSearch . '%';
            $query .= " AND video.vd_titre LIKE ?";
            array_push($params, $niveau, $keyWordSearch);
        }
        // sasn mot clé
        else {
            array_push($params, $niveau);
        }

        $result = $conn->queryMultipleValue($query, $params);
    }
    // si filtre par nageur
    else  if ($nageur != null && $club == null && $niveau == null) {
        // recherche video par nageur
        $query = "SELECT * FROM video WHERE video.vd_fk_ngr_id = ?";

        if (isset($keyWordSearch) && !empty($keyWordSearch)) {
            $keyWordSearch = '%' . $keyWordSearch . '%';
            $query .= " AND video.vd_titre LIKE ?";
            array_push($params, $nageur, $keyWordSearch);
        } else {
            array_push($params, $nageur);
        }
    }
    // si filtre par niveau et club
    else if ($niveau != null && $club != null && $nageur == null) {

        $query = "SELECT * FROM video INNER JOIN nageur ON video.vd_fk_ngr_id = nageur.ngr_id WHERE nageur.ngr_fk_cb_id = ? AND nageur.ngr_fk_nv_id = ?";
        if (isset($keyWordSearch) && !empty($keyWordSearch)) {
            $keyWordSearch = '%' . $keyWordSearch . '%';
            $query .= " AND video.vd_titre LIKE ?";
            array_push($params, $club, $niveau, $keyWordSearch);
        } else {
            array_push($params, $club, $niveau);
        }
    }
    //si filtre par nageur et club
    else if ($nageur != null && $club != null && $niveau == null) {

        $query = "SELECT * FROM video INNER JOIN nageur ON nageur.ngr_id = video.vd_fk_ngr_id WHERE nageur.ngr_fk_cb_id = ? AND video.vd_fk_ngr_id = ?";

        if (isset($keyWordSearch) && !empty($keyWordSearch)) {
            $keyWordSearch = '%' . $keyWordSearch . '%';
            $query .= " AND video.vd_titre LIKE ?";
            array_push($params, $club, $nageur, $keyWordSearch);
        } else {
            array_push($params, $club, $nageur);
        }
    }
    require '../views/pagination.php';
}
?>
<?php if (isset($result) && !empty($result != null)) : ?>
    <section class="videos">
        <div class="jsMarginContainer">
            <h1 class="sectionVideoTitle"><?= $resultFor ?? 'Résultat de la recherche :' ?></h1>
            <div class="videosContainer">
                <?php foreach ($result as $elem) : ?>
                    <div class="flexContainer">
                        <div class="video">
                            <div class="miniature" style="<?= "background-image: url('../videos/thumbnails/" . $elem->vd_thumbnail ?>') ">
                                <div class="blackFilter"></div>
                                <i class="fas fa-play fa-3x Mplay"></i>
                            </div>
                            <h1 class="videoTitle"> <?= $elem->vd_titre ?></h1>
                            <p class="videoResume"> <?= substr($elem->vd_description, 0, 250) ?> <?= strlen($elem->vd_description) < 250 ? $elem->vd_description : '...' ?></p>
                            <button class="lessonBtn"><a href="<?= $router->generate('lessons') ?>?lessonid=<?= $elem->vd_id ?>">voir leçon</a></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($nbPage > 0) : ?>
                <div class="pages">
                    <?php for ($i = 0; $i < $nbPage; $i++) : ?>
                        <a href="<?= $currentURL . $linkAttribute[$i] ?>"><?= $i + 1 ?></a>
                    <?php endfor ?>
                </div>
            <?php endif ?>
        </div>
    </section>
<?php endif; ?>
<?php if (empty($result)) require '../views/notfound.php' ?>
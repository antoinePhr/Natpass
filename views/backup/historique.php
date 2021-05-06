<?php
session_start();

use Antoine\Database;

require_once '../src/Database.php';
require '../components/previous.php';
$styleSheetBis = "css/filterSearch.css";
$styleSheetBis2 = "css/home_connected.css";
$scriptJs = "js/homeDisconnected.js";
$pageTitle = "historique";
$conn = new Database('natpass');
$query = "SELECT * FROM video INNER JOIN historique ON historique.hist_vd_id = video.vd_id
INNER JOIN user ON user.usr_id = ? GROUP BY vd_id ORDER BY  historique.date DESC";
$params = [0 => htmlentities($_SESSION['usr_id'])];

require '../views/pagination.php';

$resultHist = $result;
require '../components/sidebar.php';
?>
<header>
    <?php require '../components/hamburger.php'; ?>
    <?php require '../components/searchBar.php' ?>
</header>
<?php require '../components/filter.php' ?>
<?php if (isset($resultHist) && !empty($resultHist)) : ?>
    <?php if (isset($resultHist) != null) : ?>
        <section class="videos">
            <div class="jsMarginContainer">
                <h1 class="sectionVideoTitle">Historique : </h1>
                <div class="videosContainer">
                    <?php foreach ($resultHist as $elem) : ?>
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
<?php endif; ?>
<?php if (empty($result)) echo "<h1> votre historique est vide </h1>" ?>
<?php
session_start();

use \Antoine\Database;

require_once '../src/Database.php';
require '../components/previous.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pageTitle = "mes favoris";
$styleSheetBis = "css/filterSearch.css";
if (isset($_GET['vd_id']) && $_GET['addFav'] == 1) {
    $query = "INSERT INTO favorite (fav_vd_id, fav_mbr_id) VALUES (?, ?)";
    $favInfo = [];
    array_push($favInfo, htmlspecialchars($_GET['vd_id']), $_SESSION['usr_id']);
    $conn = new Database("natpass");
    $conn->insertQuery($query, $favInfo);
} else if (isset($_GET['delete']) && $_GET['delete'] == 1 && isset($_GET['vd_id'])) {
    $query = "DELETE FROM favorite WHERE favorite.fav_vd_id = ? AND favorite.fav_mbr_id = ?;";
    $favInfo = [];
    array_push($favInfo, htmlspecialchars($_GET['vd_id']), $_SESSION['usr_id']);
    $conn = new Database("natpass");
    $conn->insertQuery($query, $favInfo);
}

$query = "SELECT * FROM video INNER JOIN favorite ON favorite.fav_vd_id = video.vd_id 
    INNER JOIN membre ON membre.mbr_id = ? ORDER BY favorite.fav_date DESC";
$conn = new Database("natpass");
$params = [];
array_push($params, $_SESSION['usr_id']);
require '../views/pagination.php';
if (isset($result)) {
    $resultFav = $result;
}

require '../components/sidebar.php';
?>
<header>
    <?php
    require '../components/hamburger.php';
    require '../components/searchBar.php';
    ?>
</header>
<?php require '../components/filter.php' ?>
<?php if (isset($resultFav) && !empty($resultFav)) : ?>
    <?php if (isset($resultFav) != 0) : ?>
        <section class="videos">
            <div class="jsMarginContainer">
                <h1 class="sectionVideoTitle">mes favoris : </h1>
                <div class="videosContainer">
                    <?php foreach ($resultFav as $elem) : ?>
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
<?php else : ?>
    <div class="jsMarginContainer">
        <div class="videosContainer">
            <div class="errNoResult">
                <h3>Vous n'avez aucun favoris</h3>
            </div>
        </div>
    </div>
<?php endif; ?>
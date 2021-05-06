<?php
session_start();

use \Antoine\Database;

require_once '../src/ImportVideo.php';
require_once '../src/Database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pageTitle = "Importation";
$scriptJs = "js/import.js";
$styleSheetBis = "css/import.css";
$styleSheetBis2 = "css/lesson.css";
// mettre usr id = a lid de l'admin ou coach
if (isset($_SESSION['login']) && $_SESSION['usr_id'] == '2') {

    $query = "SELECT cat_name FROM category";
    $conn = new Database("natpass");
    $categ = $conn->singleQuery($query);

    $query = "SELECT ngr_id, ngr_nom, ngr_prenom FROM nageur";
    $nag = $conn->singleQuery($query);
    $conn->closeConnection();

    if (isset($_POST['importation'])) {
        $video = new ImportVideo();
        $status = $video->moveVideo();
        $video->generateThumbnail();
        $video->addVideoInfoDB();
    }
} else header("Location: /");

?>
<script src="https://cdn.jsdelivr.net/npm/autosize@4.0.2/dist/autosize.min.js"></script>


<?php require '../components/hamburger.php'; ?>


<?php require '../components/sidebar.php'; ?>
<div class="importContainer">
    <div class="preview">
        <div class="lessonContainer">
            <div class="lesson">
                <div class="lessonVideo">
                    <div class="tags">
                        <ul>
                        </ul>
                    </div>
                    <div class="titleContainer">
                        <h1>titre</h1>
                    </div>

                </div>

                <div class="lessonInfo">
                    <h3>description :</h3>
                    <p>description</p>
                </div>
            </div>
            <hr>
            <div class="lessonAnalyse">
                <h3>analyse : </h3>
                <p>analyse</p>
            </div>
        </div>
    </div>


    <form action="<?= $router->generate('import') ?>" method="POST" enctype="multipart/form-data">
        <div class="videoChoice">
            <i class="fas fa-cloud-upload-alt fa-4x"></i>
            <p>Importer une vidéo</p>
        </div>
        <input name="file" type="file" accept=".mp4" />
        <div class="infoPreview">
            <div class="videoInfo">
                <p class="prevTitle">Saisir les données relatives à la vidéo : </p>
                <div class="divTitleContainer">
                    <label for="titre vidéo">titre de la vidéo :</label>
                    <textarea required id="videoName" rows="1" placeholder="nom de la video" name="videoName"></textarea>
                </div>
                <div class="descriptionContainer">
                    <label for="description"> description :</label>
                    <textarea required placeholder="description vidéo" rows="1" name="videoDescription"></textarea>
                </div>
                <div class="AnalyseContainer">
                    <label for="analyse"> analyse :</label>
                    <textarea placeholder="analyse vidéo" rows="1" name="videoAnalyse"></textarea>
                </div>
                <div class="tagsContainer">
                    <label for="video tag">tags :</label>
                    <textarea name="videoTags" type="text" rows="1" placeholder="tags vidéo"></textarea>
                </div>
                <div class="categoryContainer">
                    <label>type de nage : </label>
                    <select name="category">
                        <?php foreach ($categ as $c) : ?>
                            <option value="<?= $c->cat_name ?>"><?= $c->cat_name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="nageurContainer">
                    <label>nageur : </label>
                    <select name="nageur">
                        <?php foreach ($nag as $n) : ?>
                            <option value="<?= $n->ngr_id ?>"><?= $n->ngr_prenom . " " . $n->ngr_nom ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="messageImport">
            <?php
            if (isset($status)) echo $status;
            ?>

        </div>
        <div class="buttonImport">
            <button name="importation" type="submit">Uploader la vidéo</button>
        </div>

</div>
</form>
</div>
</div>

<?php
    session_start();
    $pageTitle = "Cours natation";
    $styleSheetBis = "css/lesson.css";
    $styleSheetBis2 = "css/filterSearch.css";
    $scriptJs = "js/fav.js";
    use \Antoine\Database;
    require_once '../src/Database.php';
    $histoArray = [];
    $conn = new Database('natpass');
    if(isset($_GET['lessonid']) && !empty($_GET['lessonid'])){
        //récupération de la lesson
        $lessonID = htmlentities($_GET['lessonid']);
        $result = $conn->queryMultipleValue("SELECT * FROM video WHERE vd_id = ?", array(
                                0 => $lessonID
        ));
        $lesson = $result[0];
    }
    else{
        $lesson = null;
    }

    if(isset($_SESSION['login']) && $_SESSION['login'] === true){
        array_push($histoArray, $_GET['lessonid'], $_SESSION['usr_id']);
        $conn->insertQuery("INSERT INTO historique (hist_vd_id, hist_usr_id) 
                                    VALUES (?, ?)", $histoArray);
        $favInfo = [];
        array_push($favInfo, htmlspecialchars($_GET['lessonid']), htmlspecialchars($_SESSION['usr_id']));
        $query = "SELECT IF( EXISTS( SELECT fav_vd_id FROM favorite WHERE favorite.fav_vd_id = ? AND favorite.fav_usr_id = ?), 1,0) AS favResult";
        $favResult = $conn->queryMultipleValue($query, $favInfo);
        $isFav = $favResult[0]->favResult;
    }



?>

<header>
    <?php
    require '../components/hamburger.php';
     require '../components/searchBar.php' ?>
</header>

<?php require '../components/sidebar.php';?>

<?php if($lesson != null):?>
    <div class="jsMarginContainer">
        <div class="lessonContainer">
            <div class="lesson">
                <div class="lessonVideo">
                    <video width="100%" src="<?=$lesson->vd_chemin?>" autoplay controls poster="../videos/thumbnails/<?=$lesson->vd_thumbnail?>"></video>
                    <div class="tags">
                        <ul>
                            <li>test</li>
                            <li>test</li>
                            <li>test</li>
                        </ul>
                    </div>
                    <div class="titleContainer">
                         <h1><?= $lesson->vd_titre?></h1>
                         <?php if(isset($_SESSION['login']) && !empty($_SESSION['usr_id'])): ?>
                            <div class="favIcon">
                                <img src="./img/icons/fav.png" width="45px" alt="" srcset="">
                                <img src="./img/icons/favActive.png" isFav= <?= $isFav ?> value="fav" width="45px" alt="" srcset="">
                            </div>
                        <?php endif; ?>
                    </div>
                   
                </div>

                <div class="lessonInfo">
                    <h3>description :</h3>
                    <p><?= $lesson->vd_description?></p>
                </div>
            </div>
                <hr>
            <div class="lessonAnalyse">
                <?php if($lesson->vd_analyse != ""):?>
                    <h3>analyse : </h3>
                    <p><?=$lesson->vd_analyse?></p>
                <?php else: ?>
                    <h3>Aucun analyse enregistrée pour le moment</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


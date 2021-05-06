<?php 
session_start();
use \Antoine\Database;
require_once '../src/Database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pageTitle = "Accueil";
$styleSheetBis = "css/filterSearch.css";
require '../components/previous.php';

/* DECONNECTE L'UTILISATEUR recuperer en get*/
 function logOut(){
     session_destroy();
     header("Location: /");
 }

 if(isset($_GET['logout']) && !empty($_GET['logout'])){
     logOut();
 }
 $conn = new Database('natpass');
?>
<?= $_SESSION['AC'] ?? "" ?>
<header>
    <?php 
        $_SESSION['AC'] = "";
        require '../components/hamburger.php'; 
        require '../components/searchBar.php';
    ?>

</header>
<?php if(!isset($_SESSION['login'])): ?>
    <div class="homeSection">
        <div class="blackFilter"></div>
        <div class="homeInfo">
            <h1 class="homeTitle">natpass</h1>
            <p class="homePara">accéder à vos leçons de natation facilement</p>
        </div>
    </div>
<?php endif; ?>

<!--SIDE BAR -->
<?php require '../components/sidebar.php' ?>

<!-- PAGINATION -->
<?php
    if($pageURL = strpos($_SERVER['REQUEST_URI'], '?')){
        //contient '?'
        $pageURL = explode('?', $_SERVER['REQUEST_URI']);
        $pageURL = $pageURL[0];
    }
    else{
        $pageURL = $_SERVER['REQUEST_URI'];
    }
    // si on est sur la page d'accueil donc url = '/'
    if($pageURL == '/'){
        $query = "SELECT * FROM video";
        require '../templates/pagination.php';
    } 
?>

<?php if(!isset($_GET['valuesearch']) && !isset($_GET['validFilter'])):?>
    <?php if(isset($result) && $result != null):?>
        <section class="videos">
            <div class="jsMarginContainer">
                <h1 class="sectionVideoTitle">Les plus récentes : </h1>
                <div class="videosContainer">       
                    <?php foreach($result as $elem): ?>
                        <div class="flexContainer">
                            <div class="video">
                            <div class="miniature" style="<?="background-image: url('../videos/thumbnails/".$elem->vd_thumbnail?>') ">
                                <div class="blackFilter"></div>
                                <i class="fas fa-play fa-3x Mplay"></i>
                            </div>
                            <h1 class="videoTitle"> <?= $elem->vd_titre ?></h1>
                            <p class="videoResume"> <?= substr($elem->vd_description,0,250) ?> <?= strlen($elem->vd_description) < 250 ? $elem->vd_description : '...'?></p>
                            <button class="lessonBtn"><a href="<?=$router->generate('lessons')?>?lessonid=<?= $elem->vd_id ?>">voir leçon</a></button>
                            </div>
                        </div> 
                    <?php endforeach;?>
                </div>
                <?php if($nbPage > 0): ?>
                <div class="pages">
                    <?php for($i = 0; $i < $nbPage; $i++):?>
                        <a href="<?= $router->generate('home').$linkAttribute[$i]?>"><?= $i+1 ?></a>
                    <?php endfor ?>
                </div>
                <?php endif ?>
            </div>
        </section> 
    <?php endif;?>
<?php endif; ?>

<?php
session_start();
$pageTitle = "Accueil";

use \Antoine\Database;

require_once "../src/Database.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




/* DECONNECTE L'UTILISATEUR recuperer en get*/
function logOut()
{
    session_destroy();
    header("Location: /");
}
if (isset($_GET['logout']) && !empty($_GET['logout'])) {
    logOut(); // deconnexion de l'utiliseur via var GET
}
?>

<?php if (isset($_SESSION['login'])) : ?>
    <?php
    $styleSheetBis = "css/filterSearch.css";
    $styleSheetBis2 = "css/home_connected.css";
    require_once '../src/Database.php';
    $conn = new Database('natpass');

    $query = "SELECT * FROM video";
    $resultHome = $conn->singleQuery($query);
    ?>
    <header>
        <?php require '../components/hamburger.php' ?>
        <?php require '../components/searchBar.php' ?>

    </header>
    <?php require '../components/filter.php' ?>
    <!--SIDE BAR -->
    <?php require '../components/sidebar.php' ?>

    <!-- PAGINATION -->
    <?php
    if ($pageURL = strpos($_SERVER['REQUEST_URI'], '?')) {
        //contient '?'
        $pageURL = explode('?', $_SERVER['REQUEST_URI']);
        $pageURL = $pageURL[0];
    } else {
        $pageURL = $_SERVER['REQUEST_URI'];
    }
    // si on est sur la page d'accueil donc url = '/'
    if ($pageURL == '/') {
        $query = "SELECT * FROM video";
        require '../views/pagination.php';
    }
    ?>
    <?php if (!isset($_GET['valuesearch']) && !isset($_GET['validFilter'])) : ?>
        <section class="videos">
            <div class="jsMarginContainer">
                <h1 class="sectionVideoTitle">Les plus récentes : </h1>
                <div class="videosContainer">
                    <?php foreach ($resultHome as $elem) : ?>
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
                            <a href="<?= $router->generate('home') . $linkAttribute[$i] ?>"><?= $i + 1 ?></a>
                        <?php endfor ?>
                    </div>
                <?php endif ?>
            </div>
        </section>
    <?php endif; ?>

<?php else : ?>
    <?php
    $styleSheetBis = "css/homeDisconnect.css";
    $scriptJs = "js/homeDisconnect.js";
    ?>
    <script>
        // CHARGEMENT DE LA CARTE GOOGLE MAPS
        let map;

        function initMap() {
            var positionN = new google.maps.LatLng(44.9734047, 2.4192191);
            map = new google.maps.Map(document.getElementById("map"), {
                center: positionN,
                zoom: 14,
            });

            var marker = new google.maps.Marker({
                position: positionN,
                title: "Natation Passion"
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);
        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7dYTz5q9JHQAoKLc_ntCqT8lc9rwGOTY&callback=initMap"></script>
    <header>
        <div class="filterBlur"></div>
        <nav class="nav">
            <div class="logo">
                <img src="./img/favicon.png" alt="logo Natpass">
            </div>
            <?php require '../components/hamburger.php' ?>
            <ul>
                <li name="accueil" class="active"> <a href="#">accueil</a></li>
                <li name="about"> <a href="#pres">à propos</a></li>
                <li name="cours"><a href="#courses">cours</a></li>
                <li name="contact"> <a href="#contact">contact</a></li>
                <li name="login"> <a href="<?= $router->generate('login') ?>">se connecter</a></li>
            </ul>
        </nav>
    </header>
    <div class="mobileNav">
        <ul>
            <li> <a href="#">accueil</a></li>
            <li> <a href="#pres">à propos</a></li>
            <li><a href="#courses">cours</a></li>
            <li> <a href="#contact">contact</a></li>
            <li> <a href="<?= $router->generate('login') ?>">se connecter</a></li>
        </ul>
    </div>

    <div class="homeSection" id="accueil">
        <div class="blackFilter"></div>
        <div class="homeInfo">
            <h1 class="homeTitle">natpass</h1>
            <p class="homePara">accéder à vos leçons de natation facilement</p>
        </div>
    </div>
    <div class="homePageContent">
        <div class="presentation" id="pres">
            <img src="./img/natpass.jpg" alt="image du club natation passion">
            <div class="paraPresentation">
                <h1>Natation Passion</h1>
                <p>Le club Natation Passion développe une nouvelle approche de la natation qui se veut plus variée.</p>
                <p> Il propose des activités de découverte aquatique, l'apprentissage des 4 nages, la nage avec palmes et tuba
                    et une initiation au sauvetage aquatique.</p>
                <p>Le club compte une cinquantaine d'adhérents. Il est ouvert aux enfants et adultes.</p>
                <p>Le nombre de places est limité en fonction des créneaux horaires
                    disponibles et aussi afin d'offrir une formation de qualité à ses différents membres.</p>
            </div>
        </div>
        <div class="homeCrawl" id="courses">
            <div class="crawlVid">
                <video poster="/videos/home/thumbnail/crawl.png" src="/videos/home/crawl.mp4" controls></video>
            </div>
            <div class="crawlInfo">
                <h1>Apprenez le crawl</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores unde tenetur cupiditate accusamus obcaecati voluptatem exercitationem odio accusantium eum excepturi quod est corrupti corporis, quis nostrum dolor consectetur! Alias, maxime.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem doloremque cupiditate alias illo enim illum consequuntur minima aut ut vo.</p>
            </div>
        </div>
        <div class="homeBrasse">
            <div class="brasseVid">
                <video poster="/videos/home/thumbnail/crawl.png" src="/videos/home/crawl.mp4" controls></video>
            </div>
            <div class="brasseInfo">
                <h1>Apprenez la brasse</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores unde tenetur cupiditate accusamus obcaecati voluptatem exercitationem odio accusantium eum excepturi quod est corrupti corporis, quis nostrum dolor consectetur! Alias, maxime.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem doloremque cupiditate alias illo enim illum consequuntur minima aut ut vo.</p>
            </div>
        </div>
        <div class="discoverAllCourse">
            <h1>Accédez à l'ensemble de nos cours en vous connectant</h1>
            <div class="expCourseContainer">
                <div class="exempleCourse">
                    <div class="ex1">
                        <div class="blackFilter"></div>
                        <h2>la brasse</h2>
                    </div>
                    <div class="ex2">
                        <div class="blackFilter"></div>
                        <h2>le crawl</h2>
                    </div>
                    <div class="ex3">
                        <div class="blackFilter"></div>
                        <h2>le papillon</h2>
                    </div>
                    <div class="ex4">
                        <div class="blackFilter"></div>
                        <h2>le dos crawlé</h2>
                    </div>
                </div>
            </div>

        </div>
        <div class="findUs" id="contact">
            <div class="filterFind">
                <div class="whiteFilter"></div>
            </div>
            <div class="maps" id="map"></div>
            <div class="findUsText">
                <h1>Nous trouver</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, aperiam necessitatibus quia molestiae velit ratione ducimus voluptates, quibusdam a ut esse, excepturi non odit itaque cupiditate alias voluptas quidem temporibus.</p>
                <div class="findUsInfo">
                    <div class="tel">
                        <i class="fas fa-phone-alt"></i>
                        <p>04.71.47.21.43</p>
                    </div>
                    <div class="mail">
                        <i class="fas fa-at"></i>
                        <a href="mailto:natation.passion15@gmail.com">natation.passion15@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>copyright @ 2021 Natpass.fr</p>
    </footer>
<?php endif; ?>
 <?php

    use \Antoine\Database;

    require 'home.php';
    require_once('../src/Database.php');
    if (isset($_GET['searchSubmit']) && !empty(htmlentities($_GET['valuesearch']))) {
        $conn = new Database('natpass');
        $params = [];
        $result = null;
        $currentSearch = htmlspecialchars($_GET['valuesearch']);
        $currentSearch = '%' . $currentSearch . '%';
        array_push($params, $currentSearch);
        $query = "SELECT * FROM video WHERE vd_titre LIKE ?";
        require '../views/pagination.php';

        $currentSearch = str_replace("%", '', $currentSearch);
        $resultFor = "Résultat pour \"{$currentSearch}\" :";
    }
    ?>

 <?php if (isset($result[0]) && !empty($result[0]) != null && !empty($_GET['valuesearch'])) : ?>
     <section class="videos">
         <div class="jsMarginContainer">
             <h1 class="sectionVideoTitle"> <?= $resultFor ?? 'Résultat de la recherche :' ?></h1>
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
 <?php else : ?>
     <?php require '../views/notfound.php'; ?>
 <?php endif; ?>
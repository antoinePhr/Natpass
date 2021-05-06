<?php if(!isset($_SESSION)){session_start();}?>
<?php if(isset($_SESSION['login']) && $_SESSION['login'] == true): ?>
<div class="sideBar">
    <a href="<?= $router->generate('home') ?>"><h1>natpass</h1></a>
    <nav>
        <ul>
            <li><a href="<?= $router->generate('home') ?>">accueil</a></li>
            <li> <a href="<?= $router->generate('favorite') ?>">mes favoris</a></li>
            <li> <a href="<?= $router->generate('historique')?>">mon historique</a></li>
            <li> <a href="<?= $router->generate('import')?>">importer une vidéo</a></li>
            <li> <a href="/?logout=true">déconnexion</a></li>
        </ul>
    </nav>
</div>
<?php endif; ?>
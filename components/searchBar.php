<nav class="nav">
    <div class="logo">
        <img src="./img/favicon.png">
    </div>
    <div class="containerSearch">
        <div class="searchBar">
            <i class="fas fa-search"></i>
            <form action="<?= $router->generate('search'); ?>" method="GET">
                <input class="originalKeyWordSearch" required type="text" name="valuesearch" value="<?= $_GET['valuesearch'] ?? $_GET['keyWordSearch'] ?? '' ?>" placeholder="Rechercher une leçon">
                <button style="display: none;" name="searchSubmit" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>
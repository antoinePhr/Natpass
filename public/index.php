<?php

require '../vendor/autoload.php';
$router = new AltoRouter();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// @param1 : method
// @param2 : url
// @param3 : page looking for
// @param4 : route name
$router->map('GET', '/', 'home', 'home');
$router->map($_SERVER['REQUEST_METHOD'], '/login', 'login', 'login');
$router->map('GET', '/search', 'searchResult', 'search');
$router->map('GET', '/filtersearch', 'filterSearch', 'filterSearch');
$router->map('GET', '/historique', 'historique', 'historique');
$router->map('GET', '/favoris', 'favorite', 'favorite');
$router->map($_SERVER['REQUEST_METHOD'], '/importation', 'import', 'import');
$router->map('GET', '/lessons', 'video', 'lessons');
$router->map('GET', '/edit', 'editContent', 'edit');
$router->map('GET', '/notfound', '404', '404');

$router->map('GET', '/api/getVideos', 'getVideos', 'apiGetVideos');
$router->map('GET', '/api/getVideoID', 'getVideoID', 'apiGetVideoWidthID');
$router->map('GET', '/api/getUploadInfo', 'getUploadInfo', 'uploadInfoVideo');
$match = $router->match();
if ($match) {

    // si commence par GET (nom universelle api) CHANGEMENT DE DOSSIER 
    if (substr($match['target'], 0, 3) == "get") {
        require "../api/{$match['target']}.php";
    } else {
        $params = $match['params'];
        ob_start();
        require "../views/{$match['target']}.php";
        $pageContent = ob_get_clean();
        require '../default/layout.php';
    }
} else {
    echo "404";
}

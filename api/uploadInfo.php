<?php

if (isset($_GET['titre']) && $_GET['description'] && $_GET['duree'] && $_GET['tag']) {
    $poiz = "test";
    header('Content-Type: application/json');
    echo json_encode($poiz, JSON_PRETTY_PRINT);
}

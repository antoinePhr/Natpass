<?php

use \Antoine\Database;

require_once '../src/Database.php';
if (isset($_GET['titre']) && $_GET['description']) {

    $poiz = ["status" => "name"];
    header('Content-Type: application/json');
    echo json_encode($poiz, JSON_PRETTY_PRINT);
}

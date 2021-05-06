<?php 
    use \Antoine\Database;
    require_once '../src/Database.php';

    $conn = new Database('natpass');
    $query = "SELECT * FROM video LIMIT 6";
    $response = array();
    $result = $conn->singleQuery($query);
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
  
?>
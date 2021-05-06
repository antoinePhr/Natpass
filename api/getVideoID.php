<?php 
    use \Antoine\Database;
    require_once '../src/Database.php';

    $conn = new Database('natpass');
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    $query = "SELECT * FROM video WHERE vd_id = $id";
    $response = array();
    $result = $conn->singleQuery($query);
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
  
?>
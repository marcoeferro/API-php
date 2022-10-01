<?php    
    require_once "Controllers/GetController.php";

    $table = explode("?",$routesArray[2]) [0];
    echo '<pre>'; print_r($table); echo '</pre>';
    return;
    $select = $_GET["select"] ?? "*";
    $response = new GetController();
    $response ->getTable($table,$select);
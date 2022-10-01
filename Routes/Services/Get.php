<?php    
    require_once "Controllers/GetController.php";

    $table = explode("?",$routesArray[2]) [0];
    $select = $_GET["select"] ?? "*";
    $response = new GetController();
    
    /*===========================
    Filtered Get Request
    =============================*/
    
    if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
        $response -> getTableFiltered($table,$select,$_GET["linkTo"],$_GET["equalTo"]);
    }
    /*===========================
    Unfiltered Get Request
    =============================*/
    $response ->getTable($table,$select);
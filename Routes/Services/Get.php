<?php    
    require_once "Controllers/GetController.php";

    $table = explode("?",$routesArray[2]) [0];
    $select = $_GET["select"] ?? "*";
    $orderBy = $_GET["ordeBy"] ?? null;
    $orderMode = $_GET["orderMode"] ?? null;
    $response = new GetController();
    
    /*===========================
    Filtered Get Request
    =============================*/
    
    if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
        $response -> getTableFiltered($table,$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode);
    }
    /*===========================
    Unfiltered Get Request
    =============================*/
    $response ->getTable($table,$select,$orderBy,$orderMode);
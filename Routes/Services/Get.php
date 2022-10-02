<?php    
    require_once "Controllers/GetController.php";

    $table = explode("?",$routesArray[2]) [0];
    
    $select = $_GET["select"] ?? "*";
    $orderBy = $_GET["ordeBy"] ?? null;
    $orderMode = $_GET["orderMode"] ?? null;
    $startAt = $_GET["startAt"] ?? null;
    $endAt = $_GET["endAt"] ?? null;
    
    $response = new GetController();
    
    /*===========================
    Filtered Get Request
    =============================*/
    
    if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
        $response -> getTableFiltered($table,$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode,$startAt,$endAt);
    }
    /*===========================
    Unfiltered Get Request
    =============================*/
    $response ->getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt);
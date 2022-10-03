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

    /*==========================================
    Unfitered Get Request between related tables 
    ===========================================*/
    }elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])) {
        
        $response -> getRelTable($_GET["rel"],$_GET["type"],$orderBy,$orderMode,$startAt,$endAt);
         
    }else {
    /*===========================
    Unfiltered Get Request
    =============================*/
    $response ->getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt);
    }
    
<?php    
    require_once "Controllers/GetController.php";

    $table = explode("?",$routesArray[2]) [0];
    
    $select = $_GET["select"] ?? "*";
    $orderBy = $_GET["ordeBy"] ?? null;
    $orderMode = $_GET["orderMode"] ?? null;
    $startAt = $_GET["startAt"] ?? null;
    $endAt = $_GET["endAt"] ?? null;
    $filterTo = $_GET["filterTo"] ?? null;
    $inTo = $_GET["inTo"] ?? null;
    
    $response = new GetController();
    
    /*===========================
    Filtered Get Requests
    =============================*/
    
    if (!isset($_GET["rel"]) && !isset($_GET["type"]) && isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
        
        $response -> getTableFiltered($table,$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode,$startAt,$endAt);

    /*==========================================
    Unfitered Get Requests between related tables 
    ===========================================*/
    }elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])) {
        
        $response -> getRelTable($_GET["rel"],$_GET["type"],$select,$orderBy,$orderMode,$startAt,$endAt);
    /*==========================================
    fitered Get Requests between related tables 
    ===========================================*/
    }elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
            
        $response -> getRelTableFiltered($_GET["rel"],$_GET["type"],$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode,$startAt,$endAt);
    /*===========================
    Unrelated search Get Requests
    =============================*/
    }elseif (!isset($_GET["rel"]) && !isset($_GET["type"]) && isset($_GET["linkTo"]) && isset($_GET["search"])) {
        
        $response -> getTableSearch($table,$select,$_GET["linkTo"],$_GET["search"],$orderBy,$orderMode,$startAt,$endAt);
    /*==========================================
    Search Get Request between related tables 
    ===========================================*/
    }elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && isset($_GET["linkTo"]) && isset($_GET["search"])) {
        $response -> getRelTableSearch($_GET["rel"],$_GET["type"],$select,$_GET["linkTo"],$_GET["search"],$orderBy,$orderMode,$startAt,$endAt);
    /*==============================
    Get Request for range selecction 
    ================================*/
    }elseif (isset($_GET["linkTo"]) && isset($_GET["between1"]) && isset($_GET["between2"])) {
        $response -> getTableRange($table,$select,$_GET["linkTo"],$_GET["between1"],$_GET["between2"],$orderBy,$orderMode,$startAt,$endAt,$filterTo,$inTo);
    }else {
    /*===========================
    Unfiltered Get Requests
    =============================*/
    $response ->getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt);
    }
    
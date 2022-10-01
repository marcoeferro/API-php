<?php
    $table = $routesArray[2];    
    require_once "Controllers/GetController.php";

    $table = $routesArray[2];
    $response = new GetController();
    $response ->getTable($table);
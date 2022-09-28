<?php
    $table = $routesArray[1];
    echo"<pre>"; print_r  $table; echo"</pre>";
    return;
    
    require_once "Controllers/GetController.php";

    $table = $routesArray[1];
    $response = new GetController();
    $response ->getTable($table);

    echo"<pre>"; print_r $response; echo"</pre>";
<?php
    /*===================================
    Error Handeling
    =====================================*/
    ini_set('display_errors',1);
    ini_set('log_errors',1);
    ini_set('error_log',"C:/xampp/htdocs/phpREST/php_error_log");

    /*===================================
    Requirements
    =====================================*/
    require_once "Models/connection.php";
    require_once "Controllers/routes.controller.php";
    $index = new RoutesController();
    $index-> index();
    
<?php
    $routesArray = explode("/",$_SERVER['REQUEST_URI']);
    #echo '<pre>'; print_r($routesArray); echo '</pre>';
    $routesArray = array_filter($routesArray);
    

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    
    if(empty($routesArray))
    {
        $json = array(
            'status' => 404,
            'result' => 'Not found'
        );
        echo json_encode($json,http_response_code($json["status"]));
        return;
    }elseif (isset($httpMethod)) {
        /*================================
        HTTP methods Recognition
        ==================================*/
        
        switch ($httpMethod)
        {
            case "GET":
                include "Services/Get.php";
                break;
            case "POST":
                include "Services/Post.php";
                break;
            case "PUT":
                $json = array(
                    'status' => 200,
                    'result' => 'solicitud PUT'
                );
                break;
            case "DELETE":
                $json = array(
                    'status' => 200,
                    'result' => 'solicitud DELETE'
                );
                break;
        }
    }
    




    
<?php
    require_once "Models/GetModel.php";
    class GetController 
    {
        static public function getTable($table)
        {
            $response = GetModel::getTable($table);

            $return = new GetController();
            $return -> fncResponse($response);

            return $response;
        }
        /*================================
        Controller responses
        ==================================*/
        public function fncResponse($response)
        {
            if (!empty($response))
            {
                $json = array(
                    'status' => 200,
                    'total'=> count($response),
                    'result' => $response
                );
                
            }else{
                $json = array(
                    'status' => 404,
                    'result' => 'Not Found'
                );
            }
            echo json_encode($json,http_response_code($json["status"]));
        }
        
        
    }
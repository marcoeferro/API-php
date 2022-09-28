<?php
    require_once "Models/DeleteModel.php";
    class GetController 
    {
        static public function getTable($table)
        {
            $response = DeleteModel::getTable($table);

            $return = new DeleteController();
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
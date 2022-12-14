<?php
    require_once "Models/GetModel.php";
    class GetController 
    {
        /*===========================
        Unfiltered Get Request
        =============================*/
        static public function getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt);

            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*===========================
        Filtered Get Request
        =============================*/ 
        static public function getTableFiltered($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getTableFiltered($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt);

            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*==========================================
        Unfitered Get Request between related tables 
        ===========================================*/
        static public function getRelTable($rel,$type,$select,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getRelTable($rel,$type,$select,$orderBy,$orderMode,$startAt,$endAt);
            
            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*==========================================
        Fitered Get Request between related tables 
        ===========================================*/
        static public function getRelTableFiltered($rel,$type,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getRelTableFiltered($rel,$type,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt);
            
            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*===========================
        Unrelated search Get Requests
        =============================*/
        static public function getTableSearch($table,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getTableSearch($table,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt);

            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*==========================================
        Search Get Request between related tables 
        ===========================================*/
        static public function getRelTableSearch($rel,$type,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt)
        {
            $response = GetModel::getRelTableSearch($rel,$type,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt);
            
            $return = new GetController();
            $return -> fncResponse($response);

        }
        /*==============================
        Get Request for range selecction 
        ================================*/
        static public function getTableRange($table,$select,$linkTo,$between1,$between2,$orderBy,$orderMode,$startAt,$endAt,$filterTo,$inTo)
        {
            $response = GetModel::getTableRange($table,$select,$linkTo,$between1,$between2,$orderBy,$orderMode,$startAt,$endAt,$filterTo,$inTo);
            
            $return = new GetController();
            $return -> fncResponse($response);

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
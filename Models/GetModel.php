<?php
    require_once "Connection.php";
    class GetModel
    {
        /*===========================
        Unfiltered Get Request
        =============================*/ 
        static public function getTable($table,$select)
        {
            $sql = "SELECT $select FROM $table";
            $stmt = Connection::connect()->prepare($sql);
            try {
                $stmt -> execute();
            } catch (\Throwable $th) {
                return null;
            }
            
            
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        }
        /*===========================
        Filtered Get Request
        =============================*/ 
        static public function getTableFiltered($table,$select,$linkTo,$equalTo)
        {
            $linkToArray = explode(",",$linkTo);
            $equalToArray = explode("_",$equalTo);
            $linktoText = "";
            if (count($linkToArray)>1)
            {
                foreach ($linkToArray as $key => $value) 
                {
                    if($key > 0)
                    {
                        $linktoText.= "AND ".$value." = :".$value." ";
                    }
                }
            }
            
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linktoText";
            
            $stmt = Connection::connect()->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                $stmt -> bindParam(":".$value,$equalToArray[$key], PDO::PARAM_STR);
            }
            
            
            try {
                $stmt -> execute();
            } catch (\Throwable $th) {
                return null;
            }
            
            
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        }


    }

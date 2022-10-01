<?php
    require_once "Connection.php";
    class GetModel
    {
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



    }

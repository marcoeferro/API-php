<?php
    require_once "Connection.php";
    class GetModel
    {
        static public function getTable($table)
        {
            $sql = "SELECT * FROM $table";
            $stmt = Connection::connect()->prepare($sql);
            $stmt -> execute();
            
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        }



    }

<?php
    class Connection 
    {
        static public function databaseInfo()
        {
            $DBinfo = array(
                "dbname" => "soead",
                "user" => "root",
                "password" => ""
            );
            return $DBinfo;
        }

        static public function connect()
        {
            try{
                $link = new PDO(
                    "mysql:host=localhost;dbname=".Connection::databaseInfo()["dbname"],
                    Connection::databaseInfo()["user"],
                    Connection::databaseInfo()["password"]
                );
                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link->exec("SET CHARACTER SET UTF8");

            }catch(Exception $e){
                
                die("Error: ".$e->getMessage());

            }
            return $link;
        }



    }
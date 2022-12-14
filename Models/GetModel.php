<?php
    require_once "Connection.php";
    class GetModel
    {
        /*===========================
        Unfiltered Get Request
        =============================*/ 
        static public function getTable($table,$select,$orderBy,$orderMode,$startAt,$endAt)
        {   
            /*===========================
            Not Sorted and unrestricted
            =============================*/ 
            $sql = "SELECT $select FROM $table";
             
            /*===========================
            Sorted and unrestricted
            =============================*/ 
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
            {
                $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";

            }
            /*===========================
            Sorted and restricted
            =============================*/
            if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
            {
                 
                $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

            }
            /*===========================
            Not Sorted and restricted
            =============================*/
            if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                 
                $sql = "SELECT $select FROM $table LIMIT $startAt $endAt";
            }

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
        static public function getTableFiltered($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
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
            /*===========================
            Unordered and unrestricted
            =============================*/
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linktoText";
            
            /*===========================
            Ordenated and unrestricted
            =============================*/ 
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
            {
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode";
            }
            /*===========================
            Ordenated and restricted
            =============================*/
            if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
            {
                 
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

            }
            /*===========================
            Unordered and restricted
            =============================*/
            if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                 
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linktoText LIMIT $startAt $endAt";
            }

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

        /*============================================
        Unfiltered Get Request Between Related  Tables 
        ==============================================*/

        static public function getRelTable($rel,$type,$select,$orderBy,$orderMode,$startAt,$endAt)
        {   
            $relArray = explode(",",$rel);
            $typeArray = explode(",",$type);
            $innerJoinText = "";

            if (count($relArray)>1)
            {
                foreach ($relArray as $key => $value) 
                {
                    if($key > 0)
                    {
                        $innerJoinText.= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
                    }
                }            
                
                /*===========================
                Not Sorted and unrestricted
                =============================*/ 
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText";
                
                /*===========================
                Sorted and unrestricted
                =============================*/ 
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
                {
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode";

                }
                /*===========================
                Sorted and restricted
                =============================*/
                if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
                {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

                }
                /*===========================
                Not Sorted and restricted
                =============================*/
                if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText LIMIT $startAt $endAt";
                }

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
            }else {
                return null;
            }
        }

        /*============================================
        Filtered Get Request Between Related  Tables 
        ==============================================*/

        static public function getRelTableFiltered($rel,$type,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
        {   
            /*=================
            Filter organization 
            ===================*/
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
            /*===================
            Relation organization 
            =====================*/    
            $relArray = explode(",",$rel);
            $typeArray = explode(",",$type);
            $innerJoinText = "";

            if (count($relArray)>1)
            {
                foreach ($relArray as $key => $value) 
                {
                    if($key > 0)
                    {
                        $innerJoinText.= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
                    }
                }            
                
                /*===========================
                Not Sorted and unrestricted
                =============================*/ 
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText";
                
                /*===========================
                Sorted and unrestricted
                =============================*/ 
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
                {
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode";

                }
                /*===========================
                Sorted and restricted
                =============================*/
                if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
                {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

                }
                /*===========================
                Not Sorted and restricted
                =============================*/
                if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linktoText LIMIT $startAt $endAt";
                }

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
            }else {
                return null;
            }
        }

        /*===========================
        Unrelated search Get Requests
        =============================*/
        static public function getTableSearch($table,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt)
        {   
            $linkToArray = explode(",",$linkTo);
            $searchToArray = explode("_",$equalTo);
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
            /*===========================
            Not Sorted and unrestricted
            =============================*/ 
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText";
             
            /*===========================
            Sorted and unrestricted
            =============================*/ 
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
            {
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText ORDER BY $orderBy $orderMode";

            }
            /*===========================
            Sorted and restricted
            =============================*/
            if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
            {
                 
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

            }
            /*===========================
            Not Sorted and restricted
            =============================*/
            if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                 
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText LIMIT $startAt $endAt";
            }
            
            $stmt = Connection::connect()->prepare($sql);
            
            foreach ($linkToArray as $key => $value) {
                if($key > 0)
                {
                    $stmt -> bindParam(":".$value,$searchToArray[$key], PDO::PARAM_STR);
                
                }
            }
            
            try {
                $stmt -> execute();
            } catch (\Throwable $th) {
                return null;
            }            
            
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        }

        /*==========================================
        Search Get Request between related tables 
        ===========================================*/

        static public function getRelTableSearch($rel,$type,$select,$linkTo,$search,$orderBy,$orderMode,$startAt,$endAt)
        {   
            /*=================
            Filter organization 
            ===================*/
            $linkToArray = explode(",",$linkTo);
            $searchToArray = explode("_",$equalTo);
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
            /*===================
            Relation organization 
            =====================*/    
            $relArray = explode(",",$rel);
            $typeArray = explode(",",$type);
            $innerJoinText = "";

            if (count($relArray)>1)
            {
                foreach ($relArray as $key => $value) 
                {
                    if($key > 0)
                    {
                        $innerJoinText.= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
                    }
                }            
                
                /*===========================
                Not Sorted and unrestricted
                =============================*/ 
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText";
                
                /*===========================
                Sorted and unrestricted
                =============================*/ 
                if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
                {
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText ORDER BY $orderBy $orderMode";

                }
                /*===========================
                Sorted and restricted
                =============================*/
                if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
                {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

                }
                /*===========================
                Not Sorted and restricted
                =============================*/
                if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                        
                    $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linktoText LIMIT $startAt $endAt";
                }

                $stmt = Connection::connect()->prepare($sql);
                
                try {
                    $stmt -> execute();
                } catch (\Throwable $th) {
                    return null;
                }

                foreach ($linkToArray as $key => $value) {
                    if($key > 0)
                    {
                        $stmt -> bindParam(":".$value,$searchToArray[$key], PDO::PARAM_STR);
                    
                    }
                }
                
                
                return $stmt -> fetchAll(PDO::FETCH_CLASS);
            }else {
                return null;
            }
        }

        /*==============================
        Get Request for range selecction 
        ================================*/
        static public function getTableRange($table,$select,$linkTo,$between1,$between2,$orderBy,$orderMode,$startAt,$endAt,$filterTo,$inTo)
        {   
            $filter = "";
            if($filterTo != null && $inTo != null)
            {
                $filter = 'AND '.$filterTo.' IN ('.$inTo.')';
            }
            /*===========================
            Not Sorted and unrestricted
            =============================*/ 
            $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2' $filter";
             
            /*===========================
            Sorted and unrestricted
            =============================*/ 
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) 
            {
                $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2' $filter ORDER BY $orderBy $orderMode";

            }
            /*===========================
            Sorted and restricted
            =============================*/
            if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) 
            {
                 
                $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2' $filter ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";

            }
            /*===========================
            Not Sorted and restricted
            =============================*/
            if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
                 
                $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2' $filter LIMIT $startAt $endAt";
            }

            $stmt = Connection::connect()->prepare($sql);
            
            try {
                $stmt -> execute();
            } catch (\Throwable $th) {
                return null;
            }
            
            
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        }
       

    }

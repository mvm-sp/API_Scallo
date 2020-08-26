<?php
    
    $dbConn = "";

    function connect()
    {
        if($GLOBALS['dbConn']==""){
            
            $dbhost="des_nris.postgresql.dbaas.com.br";
            $dbuser="des_nris";
            $dbpass="TjYz3m";
            $dbname="des_nris";
            $port ="5432";
            /*
            $dbhost="susga.zapto.org";
            $dbuser="user_nris";
            $dbpass="user_nris";
            $dbname="sgal_sbx_nris";
            $port ="6449";
            */
            $GLOBALS['dbConn'] = pg_connect("host=$dbhost port=$port dbname=$dbname user=$dbuser password=$dbpass");

        }

        return $GLOBALS['dbConn'];
    }

    function executeSql($pSQL)
    {

        $dbConnection =connect();
        //$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data =pg_query($dbConnection, $pSQL);
    
        return pg_fetch_all($data);    

    }

    function executeTransaction($pSQL)
    {

        $dbConnection =connect();
        //$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data =pg_query($dbConnection, $pSQL);
    
        return  pg_affected_rows($data);    

    }
?>
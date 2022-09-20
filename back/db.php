<?php
function getDB(){
        global $db;
        if(!isset($db)) {
                try{
                        require_once("config.php");
                        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                        $db = new PDO($connection_string, $dbuser, $dbpass);
                }
                catch(Exception $e){
                        var_export($e);
                        $db = null;
                }
                return $db;
        }
}
?>

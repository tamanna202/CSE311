<?php

    class connectionSingleton {

        private static $con = null;
        
        private function __construct(){

            self::$con = new mysqli("localhost", "root", "", "makeup");
            if(self::$con->connect_error){
                die("Connection Error".self::$con->connect_error);
            }

        }
     
        public static function getConnection(){

            if (self::$con == null){
                new connectionSingleton();
            }     
            return self::$con;
            
        }
    }
        
?>
<?php
    namespace Config;

    class SessionValidatorHelper
    {
        public static function ValidateSession(){
            if(!isset($_SESSION["loggedUser"]))
            header ("location:".FRONT_ROOT."Home/Index");
        }   
    }
?>
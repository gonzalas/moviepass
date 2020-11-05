<?php
    namespace Helpers;

    class SessionValidatorHelper
    {
        public static function ValidateSession(){
            if(!isset($_SESSION["loggedUser"]))
            header ("location:".FRONT_ROOT."Home/Index");
        }   

        public static function ValidateSessionAdmin(){
            if(!isset($_SESSION["loggedAdmin"]))
            header ("location:".FRONT_ROOT."Home/Index");
        } 
    }
?>
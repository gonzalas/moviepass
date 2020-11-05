<?php
    namespace Helpers;

    class SessionValidatorHelper
    {
        public static function ValidateRestrictedUserView(){
            if(!isset($_SESSION["loggedUser"]))
                header ("location:".FRONT_ROOT."Home/Index");
        }

        public static function ValidateBuyTicketView($showID){
            if(!isset($_SESSION["loggedUser"]))
                header ("location:".FRONT_ROOT."User/buyTicketLogin/?showID=$showID");
        }

        public static function ValidateUserNav(){
            if(!isset($_SESSION["loggedUser"])){
                require_once(VIEWS_PATH . "nav-public.php");
            } else {
                require_once(VIEWS_PATH . "nav-client.php");
            }
        }

        public static function ValidateSessionAdmin(){
            if(!isset($_SESSION["loggedAdmin"]))
                header ("location:".FRONT_ROOT."Home/Index");
        }
    }
?>
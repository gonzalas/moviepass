<?php
    namespace Helpers;

    use DAO\UserDAO as UserDAO;

    class UserValidator{

        public static function ValidateUsername($username){
            $userAvailable = false;
            $userDAO = new UserDAO();
            $userByUsername = $userDAO->ReadByUserName($username);
            if(!$userByUsername) $userAvailable = true; 
            return $userAvailable;
        }

        public static function ValidateEmail($email){
            $userAvailable = false;
            $userDAO = new UserDAO();
            $userByEmail = $userDAO->ReadByUserEmail($email);
            if(!$userByEmail) $userAvailable = true; 
            return $userAvailable;
        }
    }


?>
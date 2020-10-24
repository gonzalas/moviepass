<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;

    class UserController {
        private $userDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
        }

        function registerUser(){

            if($_POST){

                if($this->validatePassword($_POST['password'], $_POST['password2'])){

                    $user = new User();
                    $user->setFirstName($_POST['firstName']);
                    $user->setLastName($_POST['lastName']);
                    $user->setEmail($_POST['email']);
                    $user->setUserName($_POST['username']);
                    $user->setPassword($_POST['password']);
                    $user->setRole(1); // Role = 0 for Admin, Role = 1 for Regular User

                    //Add user into DB
                    $this->userDAO->Create($user);

                    //Create session with user data
                    $_SESSION['loggedUser'] = $user;

                    //Show first view for user logged
                    $this->showCinemaListMenu();

                } else {
                    require_once(VIEWS_PATH."login.php");
                }
                
            }
        }

        function processLogin(){

            if($_POST){

                $this->showCinemaListMenu();
            }
        }

        private function showCinemaListMenu(){
            require_once(VIEWS_PATH."user-cinema-list.php");
        }

        private function validatePassword($password, $password2){
            return ($password === $password2) ? true : false;
        }
    }

?>
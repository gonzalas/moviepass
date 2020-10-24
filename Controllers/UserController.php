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
                    $user->setIsAdmin(false);

                    //Add user into DB
                    $this->userDAO->Create($user);

                    //Create session with user data
                    $_SESSION['loggedUser'] = $user;

                    //Give a welcome to a new user
                    $this->welcomeNewUser($user);

                    //Show first view for user logged
                    $this->showCinemaListMenu();

                } else {
                    require_once(VIEWS_PATH."login.php");
                }
                
            }
        }

        function processLogin(){

            if($_POST){

                $user = new User();
                $user->setUserName($_POST['userName']);
                $user->setPassword($_POST['userPassword']);

                //Verify user in DB
                $userValidated = $this->userDAO->Read($user->getUserName(), $user->getPassword());

                if($userValidated){
                    //Initiate session
                    $_SESSION['loggedUser'] = $userValidated;

                    //Redirect user
                    $this->showCinemaListMenu();

                } else {
                    require_once(VIEWS_PATH."login.php");
                }
            }
        }

        private function showCinemaListMenu(){
            require_once(VIEWS_PATH."user-cinema-list.php");            
        }

        private function welcomeNewUser($user){
            require_once(VIEWS_PATH."welcome-user.php");
        }

        private function validatePassword($password, $password2){
            return ($password === $password2) ? true : false;
        }
    }

?>
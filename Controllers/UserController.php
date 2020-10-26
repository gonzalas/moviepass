<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use Models\User as User;

    class UserController {
        private $userDAO;
        private $cinemaDAO;
        private $roomDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
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

        public function showRoomsToUser(){
            if($_POST){
                $cinemaSelected = $_POST['cinemaSelected'];

                //Retrive all rooms from one cinema
                $roomList = $this->roomDAO->ReadByCinemaID($cinemaSelected);

                //Restore all cinemas to choose again before load views
                $cinemasList = $this->cinemaDAO->ReadAll();

                require_once(VIEWS_PATH."user-cinema-list.php");
                require_once(VIEWS_PATH."user-room-list.php");
            }
        }

        public function showRoomMovieListing(){
            if($_GET){

               $cinemaID = $_GET['cinema'];
               $roomID = $_GET['room'];

               //Search on database the room selected
               $cinema = $this->cinemaDAO->ReadByID($cinemaID);

               //Getting this room movie listing to show on view
               $movieListing = $cinema['0']->getMovieListing();

               require_once(VIEWS_PATH."room-movielisting.php");
            }
        }

        public function showUserProfile(){
            $user = $_SESSION['loggedUser'];
            require_once(VIEWS_PATH."user-info-profile.php");
        }

        public function userLogOut(){
            session_destroy();
            require_once(VIEWS_PATH."login.php");
        }

        public function showCinemaListMenu(){
            $cinemasList = $this->cinemaDAO->ReadAll();
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
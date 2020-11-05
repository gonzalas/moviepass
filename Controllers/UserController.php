<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreMovieDAO as GenreMovieDAO;
    use Models\User as User;
    use Models\Movie as Movie;
    use Models\Show as Show;
    use Models\MovieListing as MovieListing;
    use Helpers\SessionValidatorHelper as SessionValidatorHelper;
    use Helpers\EncodePassword as EncodePassword;
    use Helpers\FilterRepeteadArray as FilterRepeteadArray;
    use Helpers\Carousel as Carousel;

    class UserController {
        private $userDAO;
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;
        private $genreMovieDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
            $this->movieDAO = new MovieDAO();
            $this->genreMovieDAO = new GenreMovieDAO();
        }

        function registerUser($firstName, $lastName, $email, $username, $password, $password2){

            if($this->validatePassword($password, $password2)){
                $user = new User();
                $user->setFirstName($firstName);
                $user->setLastName($lastname);
                $user->setEmail($email);
                $user->setUserName($username);
                $user->setPassword($password);
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

        function showLoginView ($message = ""){
            require_once(VIEWS_PATH . "login.php");
        }
        
        function processLogin($userName, $userPassword){

            $user = new User();
            $user->setUserName($userName);
            $user->setPassword($userPassword);

            //Verify if user is Admin and redirect
            if($user->getUserName() == ADMIN_USERNAME && $user->getPassword() == ADMIN_PASSWORD){

                $userValidated = $user->getUserName();
                $userValidated = $user->getPassword();
                $_SESSION['loggedAdmin'] = $userValidated;

                //Redirect to admin menu
                header("location:".FRONT_ROOT."Show/showUpcomingShows");

            } else {

                //Verify user in DB
                $userValidated = $this->userDAO->Read($user->getUserName(), $user->getPassword());
                if($userValidated){
                    //Initiate session
                    $_SESSION['loggedUser'] = $userValidated;
                    //Redirect to user menu
                    $this->showCinemaListMenu();
                } else {
                    $this-> showLoginView("El usuario o contraseña ingresados son incorrectos.");
                }
            }
        }

        function buyTicketLogin($movieID){
            
        }
       
        public function showMovieListing($cinemaSelected){

                //If cinemaSelected == -1, was selected the default 'Elija' option on select
            if($cinemaSelected != -1){

                //Retrive cinema selected on database
                $cinema = $this->cinemaDAO->ReadByID($cinemaSelected);

                //Restore all cinemas to choose again before load views
                $cinemasList = $this->cinemaDAO->ReadActiveCinemasWithRooms();
                $showsList = $this->showDAO->ReadMovieListingByCinemaID($cinema->getID());
               
                $movieListing = array();
               
                if($showsList){
                    foreach($showsList as $show){
                        $movieID = $this-> showDAO-> ReadMovieID($show-> getID());
                        $movie = $this-> movieDAO-> ReadByID($movieID);
                        array_push($movieListing, $movie);
                    }
                }
                
                //Filtering array by repetead movies
                $movieListing = FilterRepeteadArray::filterArray($movieListing);
        
                //Carrousel
                $moviesOnCarousel = 3;
                $carousel = Carousel::generateCarouselMovies($movieListing, $moviesOnCarousel);

                require_once(VIEWS_PATH."user-cinema-list.php");
                require_once(VIEWS_PATH."user-movie-listing.php");
            } else {
                $this->showCinemaListMenu();
            }

        }

        public function showMovieDetails($movieID, $cinemaID){

            $movieSelected = new Movie();
            $movieSelected = $this-> movieDAO-> ReadByID($movieID);
            $genresList = $this-> genreMovieDAO-> ReadByMovieID($movieID);
            $movieSelected-> setGenres($genresList);
            $showsList = $this-> showDAO-> ReadUpcomingByCinemaAndMovie($cinemaID, $movieID);

            if ($showsList instanceof Show){
                $aux = $showsList;
                $showsList = array();
                array_push($showsList, $aux);
            }
            if(!empty($showsList)){
                foreach ($showsList as $show){
                    $movieID = $this-> showDAO-> ReadMovieID($show-> getID());
                    $show-> setMovie($this-> movieDAO-> ReadByID($movieID));
                    $roomID = $this-> showDAO-> ReadRoomID($show-> getID());
                    $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
                    $room = $this-> roomDAO-> ReadByID ($roomID);
                    $room-> setCinema($this-> cinemaDAO-> ReadByID($cinemaID));
                    $show-> setRoom($room);
                }    
            }
            require_once(VIEWS_PATH."movie-details.php");
        }
        
        public function showRoomsToUser($cinemaSelected){

            //Retrive all rooms from one cinema
            $roomList = $this->roomDAO->ReadByCinemaID($cinemaSelected);

            //Restore all cinemas to choose again before load views
            $cinemasList = $this->cinemaDAO->ReadAll();

            require_once(VIEWS_PATH."user-cinema-list.php");
            require_once(VIEWS_PATH."user-room-list.php");
           
        }


        public function verifyUserInDB($userName, $password){

        }

        public function showUserProfile($message = ""){

            SessionValidatorHelper::ValidateRestrictedUserView();

            //Get user from session
            $user = $_SESSION['loggedUser'];

            //Encode his password before showing
            $user->setPassword(EncodePassword::Encode($user->getPassword()));

            require_once(VIEWS_PATH."user-info-profile.php");
        }

        public function changeInfoUser($userName, $password){
            SessionValidatorHelper::ValidateRestrictedUserView();

            //Get user from actual session
            $user = $_SESSION['loggedUser'];

            //Check if new username is on DB. If not, it's ok to update
            $userInDB = $this->userDAO->ReadByUserName($userName);

            if(!$userInDB){
                $this->userDAO->UpdateUserNamePassword($user, $userName, $password);
                $this->userLogOut("Usuario actualizado.");
            } else {
                $message = "Error al actualizar información. Usuario ya existente.";
            }
            $this->showUserProfile($message);
        }


        public function userLogOut($message = ""){
            session_destroy();
            require_once(VIEWS_PATH."login.php");
        }


        public function showCinemaListMenu(){
            $cinemasList = $this->cinemaDAO->ReadActiveCinemasWithRooms();
            require_once(VIEWS_PATH."user-cinema-list.php");            
        }


        private function welcomeNewUser($user){
            SessionValidatorHelper::ValidateRestrictedUserView();
            require_once(VIEWS_PATH."welcome-user.php");
        }

        private function validatePassword($password, $password2){
            return ($password === $password2) ? true : false;
        }

    }

?>
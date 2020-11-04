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
    use Config\SessionValidatorHelper as SessionValidatorHelper;

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

                //Verify if user is Admin and redirect
                if($user->getUserName() == ADMIN_USERNAME && $user->getPassword() == ADMIN_PASSWORD){

                    header("location:".FRONT_ROOT."Cinema/ShowAddView");

                } else {

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
        }

        public function showMovieListing(){

            SessionValidatorHelper::ValidateSession();

            if($_POST){
                $cinemaSelected = $_POST['cinemaSelected'];

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
                    $movieListing = $this->filterArrayRepetead($movieListing);

                    //Carrousel
                    $moviesOnCarrousel = 3;
                    $carrousel = $this->generateCarrouselMovies($movieListing, $moviesOnCarrousel);

                    require_once(VIEWS_PATH."user-cinema-list.php");
                    require_once(VIEWS_PATH."user-movie-listing.php");

                } else {
                    $this->showCinemaListMenu();
                }
            }
        }

        public function showMovieDetails(){

            SessionValidatorHelper::ValidateSession();

            if($_POST){
                $movieID = $_POST['movieID'];
                $cinemaID = $_POST['cinemaID'];
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
        }
        
        public function showRoomsToUser(){

            SessionValidatorHelper::ValidateSession();

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

            SessionValidatorHelper::ValidateSession();

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

            SessionValidatorHelper::ValidateSession();

            $user = $_SESSION['loggedUser'];
            require_once(VIEWS_PATH."user-info-profile.php");
        }

        public function userLogOut(){
            session_destroy();
            require_once(VIEWS_PATH."login.php");
        }

        public function showCinemaListMenu(){

            SessionValidatorHelper::ValidateSession();            
            $cinemasList = $this->cinemaDAO->ReadActiveCinemasWithRooms();
            require_once(VIEWS_PATH."user-cinema-list.php");            
        }

        private function welcomeNewUser($user){
            require_once(VIEWS_PATH."welcome-user.php");
        }

        private function validatePassword($password, $password2){
            return ($password === $password2) ? true : false;
        }

        private function filterArrayRepetead($array, $keep_key_assoc = false){
            $duplicate_keys = array();
            $tmp = array();       
        
            foreach ($array as $key => $val){
                // convert objects to arrays, in_array() does not support objects
                if (is_object($val))
                    $val = (array)$val;
        
                if (!in_array($val, $tmp))
                    $tmp[] = $val;
                else
                    $duplicate_keys[] = $key;
            }
        
            foreach ($duplicate_keys as $key)
                unset($array[$key]);
        
            return $keep_key_assoc ? $array : array_values($array);
        }

        private function generateCarrouselMovies($movies, $moviesOnCarrousel){
            $carrouselListing = array();
            if(count($movies) >= $moviesOnCarrousel){

                for($i = 0; $i < $moviesOnCarrousel; $i++){  
                    array_push($carrouselListing, $movies[$i]);
                }
            } else {
                $carrouselListing = [];
            }                        
            return $carrouselListing;
        }   

        private function getArrayRandom($movies, $number){
            $i = 0;
            $random = array();
            while($i < $number){
                $random[$i] = rand(0, count($movies) - 1);
                while(in_array($random[$i], $random)){
                    $random[$i] = rand(0, count($movies) - 1);
                }
                var_dump($random[$i]);
                array_push($random, $random[$i]);
                $i++;
            }
            array_pop($random);
            var_dump($random);
            return $random;
        }
    }

?>
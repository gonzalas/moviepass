<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreMovieDAO as GenreMovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\PurchaseDAO as PurchaseDAO;
    use DAO\TicketDAO as TicketDAO;
    use Models\User as User;
    use Models\Movie as Movie;
    use Models\Show as Show;
    use Models\Ticket as Ticket;
    use Models\Purchase as Purchase;
    use Helpers\SessionValidatorHelper as SessionValidatorHelper;
    use Helpers\EncodePassword as EncodePassword;
    use Helpers\UserValidator as UserValidator;
    use Helpers\FilterRepeteadArray as FilterRepeteadArray;
    use Helpers\Carousel as Carousel;
    use Helpers\FilterMovieByTitle as FilterMovieByTitle;

    class UserController {
        private $userDAO;
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;
        private $genreMovieDAO;
        private $genreDAO;
        private $purchaseDAO;
        private $ticketDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
            $this->movieDAO = new MovieDAO();
            $this->genreMovieDAO = new GenreMovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->purchaseDAO = new PurchaseDAO();
            $this->ticketDAO = new TicketDAO();
        }

        function registerUser($firstName, $lastName, $email, $username, $password, $password2){

            if($this->validatePassword($password, $password2)){

                //Verify that username and email are available before create
                if(UserValidator::ValidateUsername($username)){
                    if(UserValidator::ValidateEmail($email)){

                        $user = new User();
                        $user->setFirstName($firstName);
                        $user->setLastName($lastName);
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

                        /**Redirect user to the corresponding view */
                        if (isset($_SESSION['showID'])){
                            header("location:".FRONT_ROOT."Ticket/showBuyTicketView/?showID=".$_SESSION['showID']);
                        } else {
                            //Show first view for user logged
                            $this->showCinemaListMenu();
                        }

                    } else {
                        $message = "El email ya está registrado.";
                        require_once(VIEWS_PATH."login.php");
                    }
                } else {
                    $message = "Nombre de usuario no disponible.";
                    require_once(VIEWS_PATH."login.php");
                }

            } else {
                $message = "Las contraseñas no coinciden.";
                require_once(VIEWS_PATH."login.php");
            }
        }

        function showLoginView ($message = ""){
            require_once(VIEWS_PATH . "login.php");
        }
        
        public function buyTicketLogin(){
            if(!isset($_SESSION["loggedUser"])){
                $this-> showLoginView();
            } else {
                header("location:javascript://history.go(-1)");
            }
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
                    /**Redirect user to the corresponding view */
                    if (isset($_SESSION['showID'])){
                        header("location:".FRONT_ROOT."Ticket/showBuyTicketView/?showID=".$_SESSION['showID']);
                    } else {
                        //Redirect to user menu
                        $this->showCinemaListMenu();
                    }
                } else {
                    $this-> showLoginView("El usuario o contraseña ingresados son incorrectos.");
                }
            }
        }

       
        public function showMovieListing($cinemaSelected){

            //If cinemaSelected == -1, was selected the default 'Elija' option on select
            if($cinemaSelected != -1){

                //Retrive cinema selected on database
                $cinema = $this->cinemaDAO->ReadByID($cinemaSelected);

                //Restore all cinemas to choose again before load views
                $cinemasList = $this->cinemaDAO->ReadActiveCinemasWithRooms();
                $showsList = $this->showDAO->ReadMovieListingByCinemaID($cinema->getID());
                if ($showsList instanceof Show){
                    $aux = $showsList;
                    $showsList = array();
                    array_push($showsList, $aux);
                }
               
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

                $genresList = $this->genreMovieDAO->ReadGenresByActiveShows();
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
                    $showSoldTickets = $this-> showDAO-> CountShowSoldTickets($show-> getID());
                    $show-> setSoldTickets($showSoldTickets);
                }
                $showsList = $this-> filterByAvailableTickets($showsList);
            }
            require_once(VIEWS_PATH."movie-details.php");
        }
        

        public function showUserProfile($message = ""){

            SessionValidatorHelper::ValidateRestrictedUserView();

            //Get user from session
            $user = $_SESSION['loggedUser'];

            //Encode his password before showing
            $user->setPassword(EncodePassword::Encode($user->getPassword()));

            require_once(VIEWS_PATH."user-info-profile.php");
        }

        public function showUserPurchases(){

            SessionValidatorHelper::ValidateRestrictedUserView();

            //Get user from session
            $user = $_SESSION['loggedUser'];

            $purchasesList = $this-> purchaseDAO-> ReadByUserID($user-> getID());
            if ($purchasesList instanceof Purchase){
                $aux = $purchasesList;
                $purchasesList = array();
                array_push($purchasesList, $aux);
            }
            if (!empty($purchasesList)){
                foreach ($purchasesList as $purchase){
                    $ticketsList = $this-> ticketDAO-> ReadByPurchaseID($purchase-> getPurchaseID());
                    if ($ticketsList instanceof Ticket){
                        $aux = $ticketsList;
                        $ticketsList = array();
                        array_push($ticketsList, $aux);
                    }
                    $purchase-> setTicketsList($ticketsList);
                    $showID = $this-> purchaseDAO-> ReadShowID($purchase-> getPurchaseID());
                    $show = $this-> showDAO-> ReadById($showID);
                    $roomID = $this-> showDAO-> ReadRoomID($showID);
                    $room = $this-> roomDAO-> ReadByID($roomID);
                    $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
                    $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
                    $room-> setCinema($cinema);
                    $show-> setRoom($room);
                    $movieID = $this-> showDAO-> ReadMovieID($showID);
                    $movie = $this-> movieDAO-> ReadByID($movieID);
                    $show-> setMovie($movie);
                    $purchase-> setShow($show);
                }
            }
            
            require_once(VIEWS_PATH."user-purchases-history.php");
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
            $genresList = $this->genreMovieDAO->ReadGenresByActiveShows();
            require_once(VIEWS_PATH."user-cinema-list.php");            
        }

        public function showMovieGenre($genreID){
            $moviesXGenres = $this->movieDAO->ReadByGenreAndActiveShows($genreID);
            $moviesSelected = array();
            foreach($moviesXGenres as $movie){
                array_push($moviesSelected, $this->movieDAO->ReadById($movie['movieID']));
            }
            $this->showCinemaListMenu();
            $this->showMoviesByGenre($moviesSelected);
        }

        public function showMovieTitle($movieTitle){
            //Get movies and filter by title
            $moviesAll= $this->movieDAO->ReadByActiveShows();
            if ($moviesAll instanceof Movie){
                $aux = $moviesAll;
                $moviesAll = array();
                array_push($moviesAll, $aux);
            }
            $movieSearched = FilterMovieByTitle::ApplyFilter($moviesAll, $movieTitle);
            $this->showCinemaListMenu();
            $this->showMovieSearched($movieSearched);
        }

        public function showMovieSearchedDetails($movieID){
            $showsList = $this->showDAO->ReadUpcomingByMovie($movieID);
            $this->showViewMovieSearchedDetails($showsList);
        }


        private function showViewMovieSearchedDetails($showsList){
            $roomList = array();
            $cinemaList = array();
            if(is_array($showsList)){
                $movieID = $this->showDAO->ReadMovieID($showsList[0]->getID());
                foreach($showsList as $shows){
                    $roomID = $this->showDAO->ReadRoomID($shows->getID());
                    $room = $this->roomDAO->ReadByID($roomID);
                    array_push($roomList, $room);
                    $cinemaID = $this->roomDAO->ReadCinemaID($roomID);
                    $cinema = $this->cinemaDAO->ReadByID($cinemaID);
                    array_push($cinemaList, $cinema);
                }
            } else {
                $roomID = $this->showDAO->ReadRoomID($showsList->getID());
                $room = $this->roomDAO->ReadByID($roomID);
                $cinemaID = $this->roomDAO->ReadCinemaID($roomID);
                $cinema = $this->cinemaDAO->ReadByID($cinemaID); 
                $movieID = $this->showDAO->ReadMovieID($showsList->getID());   
            }

            $movieSelected = $this->movieDAO->ReadById($movieID);
            $genresList = $this-> genreMovieDAO-> ReadByMovieID($movieID);
            $movieSelected-> setGenres($genresList);

            require_once(VIEWS_PATH."movie-searched-shows.php");
        }

        private function showMovieSearched($movieSearched){
            require_once(VIEWS_PATH."user-movie-searched.php");
        }

        private function showMoviesByGenre($moviesSelected){
            require_once(VIEWS_PATH."user-movies-genres.php");
        }

        private function welcomeNewUser($user){
            SessionValidatorHelper::ValidateRestrictedUserView();
            require_once(VIEWS_PATH."welcome-user.php");
        }

        private function validatePassword($password, $password2){
            return ($password === $password2) ? true : false;
        }

        private function filterByAvailableTickets($showsList){
            $auxArray = array();
            foreach($showsList as $show){
                if ($show-> getSoldTickets() < $show-> getRoom()-> getCapacity()){
                    array_push($auxArray, $show);
                }
            }
            return $auxArray;
        }

    }

?>
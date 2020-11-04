<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;
    use Models\User as User;
    use Models\Movie as Movie;
    use Config\SessionValidatorHelper as SessionValidatorHelper;

    class TicketController {
        private $userDAO;
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
            $this->movieDAO = new MovieDAO();
        }


        function showBuyTicketView($showID){
            SessionValidatorHelper::ValidateSession();

            $show = $this-> showDAO-> ReadByID($showID);
            $roomID = $this-> showDAO-> ReadRoomID($showID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
            $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
            $room-> setCinema($cinema);
            $show-> setRoom($room);
            $movieID = $this-> showDAO-> ReadMovieID($showID);
            $movie = $this-> movieDAO-> ReadByID($movieID);
            $show-> setMovie($movie);
            require(VIEWS_PATH."ticket-submission.php");
        }
    }

?>
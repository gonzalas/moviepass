<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\TicketDAO as TicketDAO;
    use DAO\PurchaseDAO as PurchaseDAO;
    use Models\User as User;
    use Models\Movie as Movie;
    use Models\Ticket as Ticket;
    use Models\Purchase as Purchase;
    use Config\SessionValidatorHelper as SessionValidatorHelper;

    class TicketController {
        private $userDAO;
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;
        private $ticketDAO;
        private $purchaseDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
            $this->movieDAO = new MovieDAO();
            $this->ticketDAO = new TicketDAO();
            $this->purchaseDAO = new PurchaseDAO();
        }


        public function showBuyTicketView($showID){
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

        public function validateTicketPurchase(){
            if($_POST){
                $showID = $_POST['showID'];
                $showDate = $_POST['showDate'];
                $seatsQuantity = $_POST['seatsQuantity'];
                
                $ticket = new Ticket();
                $purchase = new Purchase();

                $userLogged = $_SESSION['loggedUser'];

                $showToBuy = $this->showDAO->ReadById($showID);
                $movieIDToBuy = $this->showDAO->ReadMovieID($showID);
                $movieToBuy = $this->movieDAO->ReadById($movieIDToBuy);
                $roomIDToBuy = $this->showDAO->ReadRoomID($showID);
                $roomToBuy = $this->roomDAO->ReadById($roomIDToBuy);
                $cinemaToBuy = $this->roomDAO->ReadCinemaID($roomIDToBuy);

                $purchase->setPurchaseDate(date('d M Y'));
                $purchase->setSubTotal($seatsQuantity * $roomToBuy->getTicketValue());
                $purchase->setShow($showToBuy);
                $purchase->setHasDiscount(100); //--> None discount for now
                $purchase->setPurchaseTotal($purchase->getSubTotal() * ($purchase->getHasDiscount() / 100));
                $purchase->setUser($userLogged);

                $ticket->setPurchase($purchase);

                //Save in DB
                // $userInDB = $this->userDAO->Read($userLogged->getUserName(), $userLogged->getPassword());
                // $this->purchaseDAO->Create($purchase, $userInDB->getID());
                // $purchaseFromDAO = $this->purchaseDAO->ReadByUserID($userLogged->getID());
                // $this->ticketDAO->Create($ticket, $showID, $purchaseFromDAO->getPurchaseID());

                require_once(VIEWS_PATH."purchase-view.php");
            }
        }
    }

?>
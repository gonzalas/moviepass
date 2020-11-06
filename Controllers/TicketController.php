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
    use Helpers\SessionValidatorHelper as SessionValidatorHelper;

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
            SessionValidatorHelper::ValidateBuyTicketView($showID);
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

        function viewForm(){
            require(VIEWS_PATH."checkout-form.php");
        }

        private function hasDiscount ($seatsQuantity, $showDate){
            if ($seatsQuantity >= 2){
                //Get the day of the week using PHP's date function.
                $dayOfWeek = date("l", strtotime($showDate));
                if (strcmp($dayOfWeek, "Tuesday") == 0 || strcmp($dayOfWeek, "Wednesday") == 0){
                    return true;
                }
            }
            return false;
        }

        public function readCCInformation ($showID, $seatsQuantity){
            SessionValidatorHelper::ValidateRestrictedUserView();
            $show = $this-> showDAO-> ReadByID ($showID);
            $movieID = $this->showDAO->ReadMovieID($showID);
            $movie = $this->movieDAO->ReadById($movieID);
            $show-> setMovie($movie);
            $roomID = $this-> showDAO-> ReadRoomID ($showID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $show-> setRoom($room);
            $showDate = $show-> getDate();
            $subtotal = $room-> getTicketValue() * $seatsQuantity;
            if ($this-> hasDiscount($seatsQuantity, $showDate)){
                $total = $subtotal * 0.75;
            } else {
                $total = $subtotal;
            }
            require_once (VIEWS_PATH."checkout-form.php");
        }

        public function validateTicketPurchase($showID, $seatsQuantity){
            SessionValidatorHelper::ValidateRestrictedUserView();
                
            $ticket = new Ticket();
            $purchase = new Purchase();

            $userLogged = $_SESSION['loggedUser'];

            $showToBuy = $this->showDAO->ReadById($showID);
            $movieIDToBuy = $this->showDAO->ReadMovieID($showID);
            $movieToBuy = $this->movieDAO->ReadById($movieIDToBuy);
            $roomIDToBuy = $this->showDAO->ReadRoomID($showID);
            $roomToBuy = $this->roomDAO->ReadById($roomIDToBuy);
            $cinemaToBuy = $this->roomDAO->ReadCinemaID($roomIDToBuy);

            $purchase->setPurchaseDate(date('Y-m-d', time()));
            $purchase->setSubTotal($seatsQuantity * $roomToBuy->getTicketValue());
            $purchase->setShow($showToBuy);
            $purchase->setHasDiscount(100); //--> None discount for now
            $purchase->setPurchaseTotal($purchase->getSubTotal() * ($purchase->getHasDiscount() / 100));
            $purchase->setUser($userLogged);
            $ticket->setPurchase($purchase);

            //Save in DB
            $userInDB = $this->userDAO->Read($userLogged->getUserName(), $userLogged->getPassword());
            $this->purchaseDAO->Create($purchase, $userInDB->getID());
            $purchaseFromDAO = $this->purchaseDAO->ReadOneByUserID($userLogged->getID());
            $this->ticketDAO->Create($ticket, $purchaseFromDAO->getPurchaseID());
            
            require_once(VIEWS_PATH."purchase-view.php");

        }
    }

?>
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
    use Helpers\MyPHPMailer as MyPHPMailer;
    use Helpers\QR as QR;

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
            $showSoldTickets = $this-> showDAO-> CountShowSoldTickets($show-> getID());
            $show-> setSoldTickets($showSoldTickets);
            require(VIEWS_PATH."ticket-submission.php");
        }

        function viewForm(){
            require(VIEWS_PATH."checkout-form.php");
        }

        public function readCCInformation ($showID, $seatsQuantity, $message = ""){
            SessionValidatorHelper::ValidateRestrictedUserView();
            $show = $this-> showDAO-> ReadByID ($showID);
            $movieID = $this->showDAO->ReadMovieID($showID);
            $movie = $this->movieDAO->ReadById($movieID);
            $show-> setMovie($movie);
            $roomID = $this-> showDAO-> ReadRoomID ($showID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
            $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
            $room-> setCinema($cinema);
            $show-> setRoom($room);
            $showSoldTickets = $this-> showDAO-> CountShowSoldTickets($show-> getID());
            $show-> setSoldTickets($showSoldTickets);
            $showDate = $show-> getDate();
            $subtotal = $room-> getTicketValue() * $seatsQuantity;
            if ($this-> hasDiscount($seatsQuantity, $showDate)){
                $total = $subtotal * 0.75;
            } else {
                $total = $subtotal;
            }
            require_once (VIEWS_PATH."checkout-form.php");
        }

        public function validateCCInformation ($ccName, $ccNumber, $expireMM, $expireYY, $ccCVV, $showID, $seatsQuantity){
            SessionValidatorHelper::ValidateRestrictedUserView();

            $show = $this-> showDAO-> ReadByID ($showID);
            $roomID = $this-> showDAO-> ReadRoomID ($showID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $show-> setRoom($room);
            $showSoldTickets = $this-> showDAO-> CountShowSoldTickets($show-> getID());
            $show-> setSoldTickets($showSoldTickets);

            if($show-> getSoldTickets() < $show-> getRoom()-> getCapacity()){
                /**Validate that the user inserted 16 numbers into the cc numbers field */
                if (strlen($ccNumber) == 16){
                    /**Validate that the inserted cc numbers belong either to a Visa (first digit = 4) or to a MasterCard card (first digit = 6)*/
                    if (substr($ccNumber, 0, 1) === "4" || substr($ccNumber, 0, 1) === "6"){
                        $currentYear = date('Y');
                        $currentMonth = date('m');
                        /**Validate that the inserted cc hasn't expired */
                        if ($currentYear < $expireYY || ($currentYear == $expireYY && $currentMonth < $expireMM)){
                            /** Validate that the inserted ccCVV belongs either to a Visa or to a Mastercard card (CVV is 3 digits long) */
                            if (strlen($ccCVV) == 3){
                                $this-> validateTicketPurchase($showID, $seatsQuantity);
                                //Sent Mail feature
                                $this->sentMailToClient($show, $room);
                            } else {
                                $this-> readCCInformation($showID, $seatsQuantity, "El pago no pudo ser procesado el código de seguridad ingresado es incorrecto.");
                            }
                        } else {
                            $this-> readCCInformation($showID, $seatsQuantity, "El pago no pudo ser procesado porque su tarjeta venció.");
                        }
                    } else {
                        $this-> readCCInformation($showID, $seatsQuantity, "El pago no pudo ser procesado porque nuestro sistema sólo acepta tarjetas Visa o MasterCard.");
                    }
                } else {
                    $this-> readCCInformation($showID, $seatsQuantity, "El pago no pudo ser procesado porque el número de la tarjeta debe contener 16 dígitos.");
                }
            } else {
                $this-> readCCInformation($showID, $seatsQuantity);
            }
        }

        public function validateTicketPurchase($showID, $seatsQuantity){
            SessionValidatorHelper::ValidateRestrictedUserView();
                
            
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
            if ($this-> hasDiscount($seatsQuantity, $showToBuy-> getDate())){
                $purchase->setHasDiscount(true);
                $purchase->setPurchaseTotal($purchase->getSubTotal() * 0.75);
            } else {
                $purchase->setHasDiscount(false);
                $purchase->setPurchaseTotal($purchase->getSubTotal());
            }
            $purchase->setUser($userLogged);
            //Save in DB
            $userInDB = $this->userDAO->Read($userLogged->getUserName(), $userLogged->getPassword());
            $this->purchaseDAO->Create($purchase, $userInDB->getID());
            $purchaseFromDAO = $this->purchaseDAO->ReadOneByUserID($userInDB->getID());

            $showSoldTickets = $this-> showDAO-> CountShowSoldTickets($showID);
            for ($i = 0; $i<$seatsQuantity; $i++){
                $ticket = new Ticket();
                $ticket->setPurchase($purchase);
                $ticket-> setSeatLocation($showSoldTickets + 1);
                $this->ticketDAO->Create($ticket, $purchaseFromDAO->getPurchaseID());
                $showSoldTickets++;
            }            
            
            require_once(VIEWS_PATH."purchase-view.php");

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

        private function sentMailToClient($show, $room){
            //GET USER EMAIL
            $userLogged = $_SESSION['loggedUser'];

            //GET MOVIE
            $movieID = $this-> showDAO-> ReadMovieID($show-> getID());
            $movie = $this->movieDAO->ReadById($movieID);

            //GET SHOW DATA
            $showDate = $show->getDate();
            $showStartTime = $show->getStartTime();
            $showEndTime = $show->getEndTime();

            //GET CINEMA DATA
            $cinema = $this->cinemaDAO->ReadById($room->getCinema());

            //GET PURCHASE DATA
            $purchase = $this->purchaseDAO->ReadOneByUserID($userLogged->getID());

            //GENERATE QR CODE TO ATTACH TO EMAIL
            include("C:\wamp64\www\UTN\Moviepass\Helpers\QR.php");

            //CALL TO SEND MAILER FUNCTION TO NOTIFY THE CLIENT ABOUT THE TICKET BOUGHT
            MyPHPMailer::SendMail($userLogged->getEmail(), $room, $movie, $showDate, $showStartTime, $showEndTime, $cinema, $purchase, $show->getID());
        }
    }

?>
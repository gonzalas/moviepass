<?php
    namespace Models;

    class Ticket {

        private $ticketID;
        private $seatLocation;
        private $qrCode;

        public function setTicketID($ticketID){$this->ticketID = $ticketID;}
        public function getTicketID(){return $this->ticketID;}

        public function setSeatLocation($seatLocation){$this->seatLocation = $seatLocation;}
        public function getSeatLocation(){return $this->seatLocation;}

        public function setQRCode($qrCode){$this->qrCode = $qrCode;}
        public function getQRCode(){return $this->qrCode;}

        
    }

?>
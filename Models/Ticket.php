<?php
    namespace Models;

    class Ticket {

        private $ticketID;
        private $seatLocation;
        private $qrCode;
        private $show;
        private $user;
        private $purchase;

        public function setTicketID($ticketID){$this->ticketID = $ticketID;}
        public function getTicketID(){return $this->ticketID;}

        public function setSeatLocation($seatLocation){$this->seatLocation = $seatLocation;}
        public function getSeatLocation(){return $this->seatLocation;}

        public function setQRCode($qrCode){$this->qrCode = $qrCode;}
        public function getQRCode(){return $this->qrCode;}

        public function setShow($show){$this->show = $show;}
        public function getShow(){return $this->show;}

        public function setUser($user){$this->user = $user;}
        public function getUser(){return $this->user;}

        public function setPurchase($purchase){$this->purchase = $purchase;}
        public function getPurchase(){return $this->purchase;}
    }

?>
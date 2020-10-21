<?php
    namespace Models;

    class Ticket {

        private $ticketID;
        private $showID;
        private $purchaseID;
        private $seatLocation;
        private $qrCode;

        public function setTicketID($ticketID){$this->ticketID = $ticketID;}
        public function getTicketID(){return $this->ticketID;}

        public function setShowID($showID){$this->showID = $showID;}
        public function getShowID(){return $this->showID;}

        public function setPurchaseID($purchaseID){$this->purchaseID = $purchaseID;}
        public function getPurchaseID(){return $this->purchaseID;}

        public function setSeatLocation($seatLocation){$this->seatLocation = $seatLocation;}
        public function getSeatLocation(){return $this->seatLocation;}

        public function setQRCode($qrCode){$this->qrCode = $qrCode;}
        public function getQRCode(){return $this->qrCode;}

        
    }

?>
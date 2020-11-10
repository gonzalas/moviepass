<?php
    namespace Models;

    class Purchase {

        private $purchaseID;
        private $purchaseDate;
        private $subTotal;
        private $show;
        private $hasDiscount;
        private $purchaseTotal;
        private $user;
        private $ticketsList;

        public function setPurchaseID($purchaseID){$this->purchaseID = $purchaseID;}
        public function getPurchaseID(){return $this->purchaseID;}

        public function setPurchaseDate($purchaseDate){$this->purchaseDate = $purchaseDate;}
        public function getPurchaseDate(){return $this->purchaseDate;}

        public function setSubTotal($subTotal){$this->subTotal = $subTotal;}
        public function getSubTotal(){return $this->subTotal;}

        public function setShow($show){$this->show = $show;}
        public function getShow(){return $this->show;}

        public function setHasDiscount($hasDiscount){$this->hasDiscount = $hasDiscount;}
        public function getHasDiscount(){return $this->hasDiscount;}

        public function setPurchaseTotal($purchaseTotal){$this->purchaseTotal = $purchaseTotal;}
        public function getPurchaseTotal(){return $this->purchaseTotal;}  

        public function setUser($user){$this->user = $user;}
        public function getUser(){return $this->user;}  

        public function setTicketsList($ticketsList){$this->ticketsList = $ticketsList;}
        public function getTicketsList(){return $this->ticketsList;}  
    }

?>
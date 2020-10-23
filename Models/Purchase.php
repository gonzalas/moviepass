<?php
    namespace Models;

    class Purchase {

        private $purchaseID;
        private $purchaseDate;
        private $subTotal;
        private $hasDiscount;
        private $purchaseTotal;

        public function setPurchaseID($purchaseID){$this->purchaseID = $purchaseID;}
        public function getPurchaseID(){return $this->purchaseID;}

        public function setPurchaseDate($purchaseDate){$this->purchaseDate = $purchaseDate;}
        public function getPurchaseDate(){return $this->purchaseDate;}

        public function setSubTotal($subTotal){$this->subTotal = $subTotal;}
        public function getSubTotal(){return $this->subTotal;}

        public function setHasDiscount($hasDiscount){$this->hasDiscount = $hasDiscount;}
        public function getHasDiscount(){return $this->hasDiscount;}

        public function setPurchaseTotal($purchaseTotal){$this->purchaseTotal = $purchaseTotal;}
        public function getPurchaseTotal(){return $this->purchaseTotal;}  
    }

?>
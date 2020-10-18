<?php
    namespace Models;

    class Purchase {

        private $id;
        private $datePurchase;
        private $subTotal;
        private $hasDiscount;
        private $totalPurchase;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setDatePurchase($datePurchase){$this->datePurchase = $datePurchase;}
        public function getDatePurchase(){return $this->datePurchase;}

        public function setSubTotal($subTotal){$this->subTotal = $subTotal;}
        public function getSubTotal(){return $this->subTotal;}

        public function setHasDiscount($hasDiscount){$this->hasDiscount = $hasDiscount;}
        public function getHasDiscount(){return $this->hasDiscount;}

        public function setTotalPurchase($totalPurchase){$this->totalPurchase = $totalPurchase;}
        public function getTotalPurchase(){return $this->totalPurchase;}  
    }

?>
<?php
    namespace Models;

    class CreditCard {

        private $id;
        private $code;
        private $company;
        private $expirationDate;
        private $titularName;
        private $number;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setCode($code){$this->code = $code;}
        public function getCode(){return $this->code;}

        public function setCompany($company){$this->company = $company;}
        public function getCompany(){return $this->company;}

        public function setExpirationDate($expirationDate){$this->expirationDate = $expirationDate;}
        public function getExpirationDate(){return $this->expirationDate;}

        public function setTitularName($titularName){$this->titularName = $titularName;}
        public function getTitularName(){return $this->titularName;}

        public function setNumber($number){$this->number = $number;}
        public function getNumber(){return $this->number;}
        
    }
?>
<?php
    namespace Models;

    class Ticket {

        private $id;
        private $codeQR;
        private $numberTicket;
        private $location;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setCodeQR($codeQR){$this->codeQR = $codeQR;}
        public function getCodeQR(){return $this->codeQR;}

        public function setNumber($number){$this->number = $number;}
        public function getNumber(){return $this->number;}

        public function setLocation($location){$this->location = $location;}
        public function getLocation(){return $this->location;}
        
    }

?>
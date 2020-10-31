<?php
    namespace Models;

    class Room {

        private $id;
        private $name;
        private $capacity;
        private $ticketValue;
        private $isActive;
        private $cinema;
        private $shows = array();

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function getName() {
                return $this-> name;
        }

        public function setName($name) {
                $this->name = $name;
        }

        public function getCapacity() {
                return $this-> capacity;
        }
 
        public function setCapacity($capacity) {
            $this->capacity = $capacity;
        }

        public function setTicketValue($ticketValue){$this->ticketValue = $ticketValue;}
        public function getTicketValue(){return $this->ticketValue;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}

        public function setCinema($cinema){$this->cinema = $cinema;}
        public function getCinema(){return $this->cinema;}

        public function setShows($shows){$this->shows = $shows;}
        public function getShows(){return $this->shows;}
    }

?>
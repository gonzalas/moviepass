<?php
    namespace Models;

    class Cinema {

        private $id;
        private $name;
        private $ticketValue;
        private $totalCapacity;
        private $rooms = array();
        private $movieListing;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setName($name){$this->name = $name;}
        public function getName(){return $this->name;}

        public function setTicketValue($ticketValue){$this->ticketValue = $ticketValue;}
        public function getTicketValue(){return $this->ticketValue;}

        public function setRooms($rooms){$this->rooms = $rooms;}
        public function getRooms(){return $this->rooms;}

        public function setTotalCapacity($totalCapacity){$this->totalCapacity = $totalCapacity;}
        public function getTotalCapacity(){return $this->totalCapacity;}

        public function setMovieListing($movieListing){$this->movieListing = $movieListing;}
        public function getMovieListing(){return $this->movieListing;}
        
    }

?>
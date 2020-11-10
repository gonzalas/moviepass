<?php
    namespace Models;

    class Cinema {

        private $id;
        private $name;
        private $address;
        private $totalCapacity;
        private $rooms = array();
        private $movieListing = array();
        private $isActive;
        private $soldTickets;
        private $totalShowsCapacity; /**Registers the total capacity of the shows that featured this movie */
        private $gatheredMoney;
        private $totalPossibleMoney;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setName($name){$this->name = $name;}
        public function getName(){return $this->name;}

        public function setAddress($address){$this->address = $address;}
        public function getAddress(){return $this->address;}

        public function setRooms($rooms){$this->rooms = $rooms;}
        public function getRooms(){return $this->rooms;}

        public function setTotalCapacity($totalCapacity){$this->totalCapacity = $totalCapacity;}
        public function getTotalCapacity(){return $this->totalCapacity;}

        public function setMovieListing($movieListing){$this->movieListing = $movieListing;}
        public function getMovieListing(){return $this->movieListing;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}

        public function setSoldTickets($soldTickets){$this->soldTickets = $soldTickets;}
        public function getSoldTickets(){return $this->soldTickets;}

        public function setTotalShowsCapacity($totalShowsCapacity){$this->totalShowsCapacity = $totalShowsCapacity;}
        public function getTotalShowsCapacity(){return $this->totalShowsCapacity;}

        public function setGatheredMoney($gatheredMoney){$this->gatheredMoney = $gatheredMoney;}
        public function getGatheredMoney(){return $this->gatheredMoney;}

        public function setTotalPossibleMoney($totalPossibleMoney){$this->totalPossibleMoney = $totalPossibleMoney;}
        public function getTotalPossibleMoney(){return $this->totalPossibleMoney;}
        
    }

?>
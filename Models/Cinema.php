<?php
    namespace Models;

    class Cinema {

        private $id;
        private $name;
        private $address;
        private $totalCapacity;
        private $rooms = array();
        private $movieListing;
        private $isActive;

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
        
    }

?>
<?php
    namespace Models;

    class Room {

        private $id;
        private $cinemaID;
        private $name;
        private $capacity;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setCinemaID($id){
            $this->cinemaID = $id;
        }

        public function getCinemaID(){
            return $this->cinemaID;
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
    }

?>
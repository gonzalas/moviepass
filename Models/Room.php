<?php
    namespace Models;

    class Room {

        private $name;
        private $capacity;
        private $is3D;
        private $isAtmos;

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

        public function getIs3D() {
            return $this-> is3D;
        }

        public function setIs3D($is3D) {
            $this->is3D = $is3D;
        }

        public function getIsAtmos() {
            return $this-> isAtmos;
        }

        public function setIsAtmos($isAtmos) {
            $this->isAtmos = $isAtmos;
        }
    }

?>
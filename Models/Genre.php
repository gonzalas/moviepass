<?php
    namespace Models;

    class Genre {

        private $id;
        private $name;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setName($name){$this->name = $name;}
        public function getName(){return $this->name;}
        
    }

?>
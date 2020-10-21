<?php
    namespace Models;

    class MovieListing {

        private $id;
        private $idCine;
        private $startDate;
        private $finalDate;
        private $movies = array();

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setIDCine($idCine){$this->idCine = $idCine;}
        public function getIDCine(){return $this->idCine;}

        public function setStartDate($startDate){$this->startDate = $startDate;}
        public function getStartDate(){return $this->startDate;}

        public function setFinalDate($finalDate){$this->finalDate = $finalDate;}
        public function getFinalDate(){return $this->finalDate;}

        public function setMovies($movies){$this->movies = $movies;}
        public function getMovies(){return $this->movies;}
    }
?>
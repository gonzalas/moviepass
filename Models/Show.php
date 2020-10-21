<?php
    namespace Models;

    class Show {

        private $id;
        private $roomID;
        private $movieID;
        private $date;
        private $time;
        private $isActive;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setRoomID($roomID){$this->roomID = $roomID;}
        public function getRoomID(){return $this->roomID;}

        public function setMovieID($movieID){$this->movieID = $movieID;}
        public function getMovieID(){return $this->movieID;}

        public function setDate($date){$this->date = $date;}
        public function getDate(){return $this->date;}

        public function setTime($time){$this->time = $time;}
        public function getTime(){return $this->time;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}

    }
?>
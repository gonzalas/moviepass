<?php
    namespace Models;

    class Show {

        private $id;
        private $date;
        private $startTime;
        private $endTime;
        private $isActive;
        private $room;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setDate($date){$this->date = $date;}
        public function getDate(){return $this->date;}

        public function setStartTime($startTime){$this->startTime = $startTime;}
        public function getStartTime(){return $this->startTime;}

        public function setEndTime($endTime){$this->endTime = $endTime;}
        public function getEndTime(){return $this->endTime;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}

        public function setRoom($room){$this->room = $room;}
        public function getRoom(){return $this->room;}

    }
?>
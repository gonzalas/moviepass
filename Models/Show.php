<?php
    namespace Models;

    class Show {

        private $id;
        private $date;
        private $time;
        private $isActive;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setDate($date){$this->date = $date;}
        public function getDate(){return $this->date;}

        public function setTime($time){$this->time = $time;}
        public function getTime(){return $this->time;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}

    }
?>
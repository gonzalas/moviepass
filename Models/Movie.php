<?php
    namespace Models;

    class Movie {

        private $id;
        private $title;
        private $length;
        private $image;
        private $language;
        private $genres;
        private $isActive;

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}

        public function setTitle($title){$this->title = $title;}
        public function getTitle(){return $this->title;}

        public function setLength($length){$this->length = $length;}
        public function getLength(){return $this->length;}

        public function setImage($image){$this->image = $image;}
        public function getImage(){return $this->image;}

        public function setLanguage($language){$this->language = $language;}
        public function getLanguage(){return $this->language;}

        public function setGenres($genres){$this->genres = $genres;}
        public function getGenres(){return $this->genres;}

        public function setIsActive($isActive){$this->isActive = $isActive;}
        public function getIsActive(){return $this->isActive;}
        
    }

?>
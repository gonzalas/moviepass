<?php
    namespace Models;

    class Movie {

        private $id;
        private $title;
        private $overview;
        private $releaseDate;
        private $length;
        private $image;
        private $trailer;
        private $language;
        private $genres;
        private $isActive;
        private $voteAverage;
        private $soldTickets;
        private $totalCapacity; /**Registers the total capacity of the shows that featured this movie */
        private $gatheredMoney;
        private $totalPossibleMoney;

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

        public function setTrailer($trailer){$this->trailer = $trailer;}
        public function getTrailer(){return $this->trailer;}

        public function setOverview($overview){$this->overview = $overview;}
        public function getOverview(){return $this->overview;}

        public function setReleaseDate($releaseDate){$this->releaseDate = $releaseDate;}
        public function getReleaseDate(){return $this->releaseDate;}

        public function setVoteAverage($voteAverage){$this->voteAverage = $voteAverage;}
        public function getVoteAverage(){return $this->voteAverage;}

        public function setSoldTickets($soldTickets){$this->soldTickets = $soldTickets;}
        public function getSoldTickets(){return $this->soldTickets;}

        public function setTotalCapacity($totalCapacity){$this->totalCapacity = $totalCapacity;}
        public function getTotalCapacity(){return $this->totalCapacity;}

        public function setGatheredMoney($gatheredMoney){$this->gatheredMoney = $gatheredMoney;}
        public function getGatheredMoney(){return $this->gatheredMoney;}

        public function setTotalPossibleMoney($totalPossibleMoney){$this->totalPossibleMoney = $totalPossibleMoney;}
        public function getTotalPossibleMoney(){return $this->totalPossibleMoney;}
        
    }

?>
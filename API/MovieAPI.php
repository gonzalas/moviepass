<?php
    namespace API;

    class MovieAPI {
        private $apiMoviesJSON;
        private $apiGenresJSON;

        public function __construct(){
            $this->apiMoviesJSON = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=".API_KEY."&language=es&page=1"), true);
            $this->apiGenresJSON = json_decode(file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=".API_KEY."&language=es"), true);
        }

        public function setApiMoviesJson($json){$this->apiMoviesJSON = $json;}
        public function getApiMoviesJson(){return $this->apiMoviesJSON;}

        public function setApiGenresJson($json){$this->apiGenresJSON = $json;}
        public function getApiGenresJson(){return $this->apiGenresJSON;}

        public function getMovieByTitle($movieID){
            return json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."/alternative_titles?api_key=".API_KEY), true);
        }

        public function getMovieResult($movieID){
            return json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."?api_key=".API_KEY."&language=es"), true);
        }

        public function getMovieVideo($movieID){
            return json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."/videos?api_key=".API_KEY."&language=es"), true);
        }

    }

?>
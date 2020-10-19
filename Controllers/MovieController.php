<?php

    namespace Controllers;
    use Models\Movie as Movie;

    class MovieController {

        public function __construct()
        {
        }

        function showListView (){
            $apiMoviesList = 1;/**Pedir movies a la api */
            $key = "1fda2c2ca096a563fb941fcfd34c718a";
            $apiMoviesJSON = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=$key&language=es&page=1");

            $result = json_decode($apiMoviesJSON, true);
            $apiMoviesList = $result ["results"];
            require_once(VIEWS_PATH."movie-list.php");
            
        }
    }

?>
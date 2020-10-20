<?php

    namespace Controllers;
    use Models\Movie as Movie;

    class MovieController {

        public function __construct()
        {
        }

        public function showNowPlaying (){
            $apiMoviesJSON = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=".API_KEY."&language=es&page=1");
            $apiGenresJSON = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=".API_KEY."&language=es");

            $genresResult = json_decode($apiGenresJSON, true);
            $moviesResult = json_decode($apiMoviesJSON, true);

            $apiGenresList = $genresResult ["genres"];
            $apiMoviesList = $moviesResult ["results"];

            if (isset($_GET['genreID'])){
                $genreID = $_GET['genreID'];
                $apiMoviesList = $this-> filterMoviesListByGenre($apiMoviesList, $genreID);
            }

            require_once(VIEWS_PATH."movie-list.php");
        }

        private function filterMoviesListByGenre ($moviesList, $genreID){
            $moviesList = array_filter($moviesList, function($movie) use ($genreID){
                return $movie["genre_ids"][0] == $genreID;
            });
            return $moviesList;
        }       

        function Delete($id) {
            $this-> RetrieveData();
            $this-> cinemaList = 
            array_filter ($this-> cinemaList, function($cinema) use($id){
                return $cinema-> getID() != $id;
            });
            $this-> SaveData();
        }

    }

?>
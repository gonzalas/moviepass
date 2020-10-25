<?php

    namespace Controllers;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use \Exception as Exception;

    class MovieController {

        private $movieDAO;

        public function __construct()
        {
            $this-> movieDAO = new MovieDAO();
        }

        public function showNowPlaying ($message = "", $messageCode = 0){
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

        public function showSavedMovies ($message = "", $messageCode = 0){
            if (isset($_GET['validity'])){
                $validity = $_GET['validity'];
                switch ($validity) {
                    case "active":
                        $moviesList = $this-> movieDAO-> ReadActiveMovies();
                        break;
                    case "deleted":
                        $moviesList = $this-> movieDAO-> ReadDeletedMovies();
                        break;
                    default:
                        $moviesList = $this-> movieDAO-> ReadAll();
                }
            } else {
                $moviesList = $this-> movieDAO-> ReadAll();
            }
            $emptyList = true;
            if (is_array($moviesList) && count($moviesList)){
                $emptyList = false;
            } else {
                if ($emptyList == null){
                    $emptyList = false;
                }
            }
            require_once(VIEWS_PATH."movie-list-saved.php");
        }

        function showAddView ($movieID){
            $movie = $this-> getMovieFromAPI($movieID);
            require_once(VIEWS_PATH."movie-add.php");
        }

        function showEditView ($movieID){
            $apiTitlesJSON = file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."/alternative_titles?api_key=".API_KEY);
            $titlesResult = json_decode($apiTitlesJSON, true);

            $titlesResult = $titlesResult["titles"];
            $movie = $this-> movieDAO-> ReadByID($movieID);
            require_once(VIEWS_PATH."movie-edit.php");
        }

        function addMovie($movieID){
            if ($this-> movieDAO-> ReadById($movieID) == false){
                $movie = $this-> getMovieFromAPI($movieID);
                try{
                    $this-> movieDAO-> Create($movie);
                    $this-> showNowPlaying ("Película agregada al sistema con éxito.", 0);
                }
                catch (Exception $e){
                    $this-> showNowPlaying ("Hubo un error al cargar la película al sistema.<br> Inténtelo de nuevo más tarde.", 1);
                }
            } else {
                $this-> showNowPlaying ("La película seleccionada ya estaba cargada en el sistema.", 2);
            }
        }

        function editMovie ($id, $title, $overview){
            $movie = $this-> movieDAO-> ReadByID($id);
            $movie-> setTitle($title);
            $movie-> setOverview($overview);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película editada con éxito.", 1);    
        }

        public function showGenreManagement(){
            $apiGenresJSON = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=".API_KEY."&language=es");
            $genresResult = json_decode($apiGenresJSON, true);
            $apiGenresList = $genresResult ["genres"];

            require_once(VIEWS_PATH."genre-management.php");
        }  

        function removeMovie($id) {
            $movie = ($this->movieDAO-> ReadByID($id));
            $movie-> setIsActive(false);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película eliminada con éxito.", 1);
        }

        function retrieveMovie($id) {
            $movie = ($this->movieDAO-> ReadByID($id));
            $movie-> setIsActive(true);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película dada de alta con éxito.", 1);
        }

        private function filterMoviesListByGenre ($moviesList, $genreID){
            $moviesList = array_filter($moviesList, function($movie) use ($genreID){
                return $movie["genre_ids"][0] == $genreID;
            });
            return $moviesList;
        }     

        private function getMovieFromAPI($movieID){
            $apiMovieJSON = file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."?api_key=".API_KEY."&language=es");
            $movieResult = json_decode($apiMovieJSON, true);

            $movie = new Movie;
            $movie-> setID($movieResult["id"]);
            $movie-> setTitle($movieResult["original_title"]);
            $movie-> setReleaseDate($movieResult["release_date"]);
            $movie-> setOverview($movieResult["overview"]);
            $movie-> setLength($movieResult["runtime"]);
            $movie-> setImage($movieResult["poster_path"]);
            $movie-> setLanguage($movieResult["original_language"]);
            $movie-> setGenres($movieResult["genres"]);
            $movie-> setVoteAverage($movieResult["vote_average"]);

            $apiVideoJSON = file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."/videos?api_key=".API_KEY."&language=es");
            $videoResult = json_decode($apiVideoJSON, true);
            $videoResult = $videoResult["results"];
            foreach ($videoResult as $video){
                if (strcmp ($video["type"], "Trailer") == 0 && strcmp ($video["site"], "YouTube") == 0){
                    $movie-> setTrailer ("https://www.youtube.com/watch?v=".$video["key"]);
                    break;
                }
            }

            return $movie;
        }
    }

?>
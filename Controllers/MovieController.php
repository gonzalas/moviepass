<?php

    namespace Controllers;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\GenreMovieDAO as GenreMovieDAO;
    use \Exception as Exception;
    use Helpers\SessionValidatorHelper as SessionValidatorHelper;
    use Helpers\LanguageConverter as LanguageConverter;

    class MovieController {

        private $movieDAO;
        private $genreDAO;
        private $genreMovieDAO;

        public function __construct()
        {
            $this-> movieDAO = new MovieDAO();
            $this-> genreDAO = new GenreDAO();
            $this-> genreMovieDAO = new GenreMovieDAO();
        }

        public function showNowPlaying ($message = "", $messageCode = -1, $genreID = -1, $orderByDate = -1){
            SessionValidatorHelper::ValidateSessionAdmin();
            $apiMoviesJSON = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=".API_KEY."&language=es&page=1");
            $apiGenresJSON = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=".API_KEY."&language=es");

            $genresResult = json_decode($apiGenresJSON, true);
            $moviesResult = json_decode($apiMoviesJSON, true);

            $apiGenresList = $genresResult ["genres"];
            $apiMoviesList = $moviesResult ["results"];

            $moviesList = array();
            $genresList = array();

            foreach ($apiGenresList as $genre){
                $newGenre = new Genre;
                $newGenre-> setID($genre["id"]);
                $newGenre-> setName($genre["name"]);

                array_push($genresList, $newGenre);
            }

            $genresList = $this-> orderGenresAlphabetically($genresList);

            foreach ($apiMoviesList as $movie){
                $newMovie = new Movie;
                $newMovie-> setID($movie["id"]);
                $newMovie-> setImage($movie["poster_path"]);
                $newMovie-> setTitle($movie["original_title"]);
                $newMovie-> setOverview($movie["overview"]);
                $newMovie-> setLanguage(LanguageConverter::Convert($movie["original_language"]));
                $newMovie-> setGenres($this-> assignMovieGenres($movie["genre_ids"], $genresList));
                $newMovie-> setReleaseDate($movie["release_date"]);

                array_push($moviesList, $newMovie);
            }

            if ($genreID != -1){
                foreach($genresList as $currentGenre){
                    if ($currentGenre-> getID() == $genreID){
                        $genreFilterName = $currentGenre-> getName();
                        break;
                    }
                }
                $moviesList = $this-> filterMoviesListByGenre($moviesList, $genreID);
            } else {
                if ($orderByDate != -1){
                    if ($orderByDate == 1){
                        $moviesList = $this-> orderMoviesByDate($moviesList);
                    } else if ($orderByDate == 0){
                        $moviesList = $this-> orderMoviesByDate($moviesList);
                        $moviesList = array_reverse($moviesList);
                    }
                }
            }

            require_once(VIEWS_PATH."movie-list.php");
        }

        public function showSavedMovies ($message = 0, $messageCode = 0, $validity = -1){
            SessionValidatorHelper::ValidateSessionAdmin();
            if ($validity != -1){
                switch ($validity) {
                    case "active":
                        $moviesList = $this-> movieDAO-> ReadActiveMovies();
                        if (is_array($moviesList)){
                            foreach ($moviesList as $movie){
                                $movieGenres = $this-> genreMovieDAO-> ReadByMovieID($movie-> getID());
                                $movie-> setGenres($movieGenres);
                            }
                        }
                        break;
                    case "deleted":
                        $moviesList = $this-> movieDAO-> ReadDeletedMovies();
                        if (is_array($moviesList)){
                            foreach ($moviesList as $movie){
                                $movieGenres = $this-> genreMovieDAO-> ReadByMovieID($movie-> getID());
                                $movie-> setGenres($movieGenres);
                            }
                        }
                        break;
                    default:
                        $moviesList = $this-> movieDAO-> ReadAll();
                        if (is_array($moviesList)){
                            foreach ($moviesList as $movie){
                                $movieGenres = $this-> genreMovieDAO-> ReadByMovieID($movie-> getID());
                                $movie-> setGenres($movieGenres);
                            }
                        }
                }
            } else {
                $moviesList = $this-> movieDAO-> ReadAll();
                if (is_array($moviesList)){
                    foreach ($moviesList as $movie){
                        $movieGenres = $this-> genreMovieDAO-> ReadByMovieID($movie-> getID());
                        $movie-> setGenres($movieGenres);
                    }
                }
            }
            $emptyList = true;
            if (is_array($moviesList)){
                $emptyList = false;
            }
            require_once(VIEWS_PATH."movie-list-saved.php");
        }

        function showAddView ($movieID){
            SessionValidatorHelper::ValidateSessionAdmin();
            $movie = $this-> getMovieFromAPI($movieID);
            $movie-> setLanguage(LanguageConverter::Convert($movie-> getLanguage()));
            require_once(VIEWS_PATH."movie-add.php");
        }

        function showEditView ($movieID){
            SessionValidatorHelper::ValidateSessionAdmin();
            $apiTitlesJSON = file_get_contents("https://api.themoviedb.org/3/movie/".$movieID."/alternative_titles?api_key=".API_KEY);
            $titlesResult = json_decode($apiTitlesJSON, true);

            $titlesResult = $titlesResult["titles"];
            $movie = $this-> movieDAO-> ReadByID($movieID);
            require_once(VIEWS_PATH."movie-edit.php");
        }

        function addMovie($movieID){
            SessionValidatorHelper::ValidateSessionAdmin();
            if ($this-> movieDAO-> ReadById($movieID) == false){
                $movie = $this-> getMovieFromAPI($movieID);
                $movie-> setLanguage(LanguageConverter::Convert($movie-> getLanguage()));
                try{
                    $this-> movieDAO-> Create($movie);
                    foreach($movie-> getGenres() as $genre){
                        if ($this-> genreDAO-> ReadById($genre["id"]) == false){
                            $newGenre = new Genre;
                            $newGenre-> setID($genre["id"]);
                            $newGenre-> setName($genre["name"]);
                            $this-> genreDAO-> Create($newGenre);
                        }
                        $this-> genreMovieDAO-> Create($movie-> getID(), $genre["id"]);
                    }
                    $this-> showNowPlaying ("Película agregada al sistema con éxito.", 0);
                }
                catch (Exception $e){
                    $this-> showNowPlaying ("Hubo un error al cargar la película al sistema.<br> Inténtelo de nuevo más tarde.", 1);
                }
            } else {
                $movie = $this-> movieDAO-> ReadById($movieID);
                if ($movie-> getIsActive()){
                    $this-> showNowPlaying ("La película seleccionada ya estaba cargada en el sistema.", 3);
                } else {
                    $this-> showNowPlaying ("La película seleccionada ya estaba cargada en el sistema.", 2);
                }
            }
        }

        function editMovie ($id, $title, $overview){
            SessionValidatorHelper::ValidateSessionAdmin();
            $movie = $this-> movieDAO-> ReadByID($id);
            $movie-> setTitle($title);
            $movie-> setOverview($overview);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película editada con éxito.", 1);    
        }

        public function showGenreManagement(){
            SessionValidatorHelper::ValidateSessionAdmin();
            $apiGenresJSON = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=".API_KEY."&language=es");
            $genresResult = json_decode($apiGenresJSON, true);
            $apiGenresList = $genresResult ["genres"];

            require_once(VIEWS_PATH."genre-management.php");
        }  

        function removeMovie($id) {
            SessionValidatorHelper::ValidateSessionAdmin();
            $movie = ($this->movieDAO-> ReadByID($id));
            $movie-> setIsActive(false);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película eliminada con éxito.", 1);
        }

        function retrieveMovie($id) {
            SessionValidatorHelper::ValidateSessionAdmin();
            $movie = ($this->movieDAO-> ReadByID($id));
            $movie-> setIsActive(true);
            $this-> movieDAO-> Update($movie);
            $this-> showSavedMovies("Película dada de alta con éxito.", 1);
        }

        private function filterMoviesListByGenre ($moviesList, $genreID){
            $filteredList = array();
            foreach ($moviesList as $movie){
                foreach ($movie-> getGenres() as $genre){
                    if ($genre-> getID() == $genreID){
                        array_push($filteredList, $movie);
                        break;
                    }
                }
            }
            return $filteredList;
        }
        
        private function assignMovieGenres($genreIDsArray, $genresList){
            $genresArray = array();
            foreach ($genreIDsArray as $currentID){
                foreach($genresList as $currentGenre){
                    if ($currentGenre-> getID() == $currentID){
                        $genreToSave = new Genre;
                        $genreToSave-> setID($currentGenre-> getID());
                        $genreToSave-> setName($currentGenre-> getName());
                        array_push($genresArray, $genreToSave);
                        break;
                    }
                }
            }
            return $genresArray;
        }

        private function orderGenresAlphabetically($genresList){
            usort($genresList, function ($genre1, $genre2) {
                return strcmp($genre1-> getName(), $genre2-> getName()); });
            return $genresList;
        }

        private function orderMoviesByDate($moviesList){
            usort($moviesList, function ($movie1, $movie2) { 
                $movie1Date = strtotime($movie1-> getReleaseDate()); 
                $movie2Date = strtotime($movie2-> getReleaseDate()); 
                return $movie1Date - $movie2Date; });
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
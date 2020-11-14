<?php
    namespace Helpers;

    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;

    class GetMovies {

        public static function GetAll(){
            //Get DAO's
            $showDAO = new ShowDAO();
            $movieDAO = new MovieDAO();

            //Get shows to know about active movies
            $showsList = $showDAO->ReadAll();

            //Instatiate arrays
            $moviesIDList = array();
            $movieListing = array();

            if($showsList){
                //Regarding with shows, get all movies ID
                foreach($showsList as $show){
                    array_push($moviesIDList, $showDAO->ReadMovieID($show->getID()));
                }

                //With movies ID, get all movies information and save into array 'movieListing'
                foreach($moviesIDList as $movieID){
                    array_push($movieListing, $movieDAO->ReadById($movieID));
                }
            }

            return $movieListing;
        }
    }

?>
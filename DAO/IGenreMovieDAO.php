<?php

    namespace DAO;

    interface IGenreMovieDAO {
        function Create($movieID, $genreID);
        function ReadByMovieID($movieID);
        function ReadByGenreID($genreID);
        function ReadAll();
        function Delete($id);
    }

?>
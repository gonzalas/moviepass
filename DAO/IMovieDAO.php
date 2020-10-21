<?php

    namespace DAO;
    use Models\Movie as Movie;

    interface IMovieDAO {
        function Create(Movie $movie);
        function ReadByID($id);
        function ReadAll();
        function Update($movie);
        function Delete($id);
    }

?>
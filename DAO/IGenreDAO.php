<?php

    namespace DAO;
    use Models\Genre as Genre;

    interface IGenreDAO {
        function Create(Genre $genre);
        function ReadByID($id);
        function ReadAll();
        function Delete($id);
    }

?>
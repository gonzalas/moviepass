<?php

    namespace DAO;
    use Models\Cinema as Cinema;

    interface ICinemaDAO {
        function Create(Cinema $cinema);
        function ReadByID($id);
        function ReadAll();
        function Update($cinema);
        function Delete($id);
    }

?>
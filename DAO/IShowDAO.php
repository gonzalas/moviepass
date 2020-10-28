<?php

    namespace DAO;
    use Models\Show as Show;

    interface IShowDAO {
        function Create(Show $show, $roomID, $movieID);
        function ReadByID($id);
        function ReadAllByRoomID($roomID);
        function Update($show, $roomID, $movieID);
        function Delete($id);
    }

?>
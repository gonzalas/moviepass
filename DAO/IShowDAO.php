<?php

    namespace DAO;
    use Models\Show as Show;

    interface ICinemaDAO {
        function Create(Show $show);
        function ReadByID($id);
        function ReadAllByRoomID($roomID);
        function Update($show);
        function Delete($id);
    }

?>
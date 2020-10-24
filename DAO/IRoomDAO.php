<?php

    namespace DAO;
    use Models\Room as Room;

    interface IRoomDAO {
        function Create(Room $room, $cinemaID);
        function ReadByID($id);
        function ReadAll();
        function Update($room);
        function Delete($id);
    }

?>
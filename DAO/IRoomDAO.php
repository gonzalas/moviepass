<?php

    namespace DAO;
    use Models\Room as Room;

    interface IRoomDAO {
        function Add(Room $room);
        function GetByCinemaID($id);
        function GetByID($id);
        function Delete($id);
    }

?>
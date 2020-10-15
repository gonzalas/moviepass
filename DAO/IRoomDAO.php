<?php

    namespace DAO;
    use Models\Room as Room;

    interface IRoomDAO {
        function Add(Room $room);
        function GetAll();
        function GetByID($id);
        function Delete($id);
    }

?>
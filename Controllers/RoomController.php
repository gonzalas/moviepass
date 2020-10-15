<?php

    namespace Controllers;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;

    class RoomController {

        private $roomDAO;

        public function __construct()
        {
            $this-> roomDAO = new RoomDAO();
        }

        function addRoom($cinemaID, $name, $capacity) {
            if ($this-> validateRoomName($name, $cinemaID)){
                $this-> showAddView($cinemaID, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                $room = new Room();
                $room-> setName($name);
                $room-> setCinemaID($cinemaID);
                if ($capacity >0){
                    $room-> setCapacity($capacity);
                    $this-> roomDAO-> Add($room);
                    $this-> showAddView($cinemaID, "Sala agregada con éxito.", 1);
                } else {
                    $this-> showAddView($cinemaID, "Intente usar una capacidad mayor a 0.", 0);
                }
            }
        }

        function removeRoom($id){
            $this-> roomDAO-> Delete($id);
            $roomsList = $this-> roomDAO-> GetAll();
            $message = "Sala eliminada con éxito.";
            require_once(VIEWS_PATH."index.php");
        }

        function editRoom ($id, $name, $capacity){
            $room = new Room();
            $room = $this-> roomDAO-> GetByID($id);
            $cinemaID = $room-> getCinemaID();
            if ($this-> validateRoomEdit($id, $name, $cinemaID)){
                $this-> showEditView($id, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                if ($capacity>=0) {
                    $room = new Room();
                    $room-> setName($name);
                    $room-> setCapacity($capacity);
                    $room-> setCinemaID($cinemaID);
                    $this-> roomDAO-> Add($room);
                    $this-> roomDAO-> Delete($id);
                    $this-> showEditView($room-> getID(), "Sala editada con éxito.", 1);
                } else {
                    $this-> showEditView($id, "Intente usar una capacidad mayor a 0.", 0);
                }
            }
        }
      
        /*
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> GetAll();
            require_once(VIEWS_PATH."cinema-list.php");
        }*/

        function showAddView ($cinemaId, $message = "", $messageCode = 0, Room $room = null){
            require_once(VIEWS_PATH."room-add.php");
        }

        function showEditView ($id, $message = "", $messageCode = 0){
            $room = $this-> roomDAO-> getByID($id);
            require_once(VIEWS_PATH."room-edit.php");
        }
        
        private function validateRoomName($name, $cinemaID){
            $roomList = $this-> roomDAO-> getAll();
            foreach ($roomList as $room){
                if ($room-> getCinemaID() == $cinemaID && $room-> getName() === $name){
                    return true;
                }
            }
            return false;
        }
        
        private function validateRoomEdit($id, $name, $cinemaID){
            $room = new Room();
            $room = $this-> roomDAO-> GetByID($id);
            if ($room-> getName() != $name){
                return $this-> validateRoomName($name, $cinemaID);
            }
            return false;
        }

    }

?>
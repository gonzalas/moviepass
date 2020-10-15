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

        function addRoom($name, $capacity, $cinemaID) {
            if ($this-> validateRoomName($name, $cinemaID)){
                $this-> showAddView("Nombre de sala ya existente en el cine elegido. Intente con otro.");
            } else {
                $room = new Room();
                $room-> setName($name);
                $room-> setCinemaID($cinemaID);
                $capacity>0 ? $room-> setCapacity($capacity) : $this-> showAddView("Intente usar una capacidad mayor a 0.");
                $this-> roomDAO-> Add($room);
                $this-> showAddView();
            }
        }

        function removeRoom($id){
            $this-> roomDAO-> Delete($id);
            $roomsList = $this-> roomDAO-> GetAll();
            require_once(VIEWS_PATH."cinema-list.php");
        }

        function editRoom ($id, $name, $capacity){
            if ($this-> validateRoomEdit($id, $name)){
                $this-> showEditView($id, "Nombre de sala ya existente en el cine elegido. Intente con otro.");
            } else {
                $room = new Room();
                $room-> setName($name);
                if ($capacity>=0) {
                    $room-> setCapacity($capacity);
                    $this-> roomDAO-> Add($room);
                    $this-> removeRoom($id);
                } else {
                    $this-> showEditView($id, "Intente usar una capacidad mayor a 0.");
                }
            }
        }
      
        /*
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> GetAll();
            require_once(VIEWS_PATH."cinema-list.php");
        }*/

        function showAddView ($message = "", Room $room = null){
            require_once(VIEWS_PATH."room-add.php");
        }

        function showEditView ($id, $message = ""){
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

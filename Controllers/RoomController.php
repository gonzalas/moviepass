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

        function addRoom($cinemaID, $name, $capacity, $ticketValue) {
            if ($this-> validateRoomName($name, $cinemaID)){
                $this-> showAddView($cinemaID, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                $room = new Room();
                $room-> setName($name);
                $room-> setCinemaID($cinemaID);
                if ($capacity >0){
                    $room-> setCapacity($capacity);
                    if ($ticketValue > 0){
                        $room-> setTicketValue($ticketValue);
                        $this-> roomDAO-> Create($room);
                    } else {
                        $this-> showAddView("Intente usar un precio mayor a 0.");
                    }
                    $this-> showAddView($cinemaID, "Sala agregada con éxito.", 1);
                } else {
                    $this-> showAddView($cinemaID, "Intente usar una capacidad mayor a 0.", 0);
                }
            }
        }

        function removeRoom($id){
            $this-> roomDAO-> Delete($id);
            $roomsList = $this-> roomDAO-> ReadAll();
            $message = "Sala eliminada con éxito.";
            require_once(VIEWS_PATH."index.php");
        }

        function editRoom ($id, $name, $capacity, $ticketValue){
            $room = new Room();
            $room = $this-> roomDAO-> ReadByID($id);
            $cinemaID = $room-> getCinemaID();
            if ($this-> validateRoomEdit($id, $name, $cinemaID)){
                $this-> showEditView($id, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                if ($capacity>=0) {
                    $room = new Room();
                    $room-> setName($name);
                    if ($ticketValue>=0) {
                        $room-> setTicketValue($ticketValue);
                        $room-> setCapacity($capacity);
                        $room-> setCinemaID($cinemaID);
                        $this-> roomDAO-> Create($room);
                        $this-> roomDAO-> Delete($id);
                        $this-> showEditView($room-> getID(), "Sala editada con éxito.", 1);
                    } else {
                        $this-> showEditView($id, "Intente usar un valor de entrada positivo.");
                    }
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
            $room = $this-> roomDAO-> ReadByID($id);
            require_once(VIEWS_PATH."room-edit.php");
        }
        
        private function validateRoomName($name, $cinemaID){
            $roomList = $this-> roomDAO-> ReadAll();
            foreach ($roomList as $room){
                if ($room-> getCinemaID() == $cinemaID && $room-> getName() === $name){
                    return true;
                }
            }
            return false;
        }
        
        private function validateRoomEdit($id, $name, $cinemaID){
            $room = new Room();
            $room = $this-> roomDAO-> ReadByID($id);
            if ($room-> getName() != $name){
                return $this-> validateRoomName($name, $cinemaID);
            }
            return false;
        }

    }

?>
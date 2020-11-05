<?php

    namespace Controllers;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Room as Room;
    use Models\Show as Show;

    class RoomController {

        private $roomDAO;

        public function __construct()
        {
            $this-> roomDAO = new RoomDAO();
            $this-> showDAO = new ShowDAO();
            $this-> cinemaDAO = new CinemaDAO();
        }

        function addRoom($cinemaID, $name, $capacity, $ticketValue) {
            if (!empty($this-> roomDAO-> ReadByName($cinemaID, $name))){
                $this-> showAddView($cinemaID, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                if ($capacity > 0){
                    if ($ticketValue > 0){
                        $room = new Room();
                        $room-> setName($name);
                        $room-> setCapacity($capacity);
                        $room-> setTicketValue($ticketValue);
                        $room-> setIsActive(true);
                        $this-> roomDAO-> Create($room, $cinemaID);
                        $this-> showAddView($cinemaID, "Sala agregada con éxito.", 1);
                    } else {
                        $this-> showAddView($cinemaID, "Intente usar un precio mayor a 0.", 0);
                    }
                } else {
                    $this-> showAddView($cinemaID, "Intente usar una capacidad mayor a 0.", 0);
                }
            }
        }

        function removeRoom($id){
            if ($id!=-1){
                $room = $this-> roomDAO-> ReadByID($id);
                $showsList = $this-> showDAO-> ReadUpcomingByRoomID($id);
                if ((is_array($showsList) && !empty($showsList)) || $showsList instanceof Show){
                    header ("location: ".FRONT_ROOT."Cinema/showListView/?messageCode=5");
                } else {
                    $room-> setIsActive(false);
                    $this-> roomDAO-> Update($room);
                    header ("location: ".FRONT_ROOT."Cinema/showListView/?messageCode=6");
                }
            }
        }

        function retrieveRoom($id){
            $cinemaID = $this-> roomDAO-> ReadCinemaID($id);
            $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
            if ($cinema-> getIsActive()){
                $room = ($this-> roomDAO-> ReadByID($id));
                $room-> setIsActive(true);
                $this-> roomDAO-> Update($room);
                header ("location: ".FRONT_ROOT."Cinema/showListView/?messageRoom=7");
            } else {
                header ("location: ".FRONT_ROOT."Cinema/showListView/?messageRoom=8");
            }
        }

        function editRoom ($id, $name, $capacity, $ticketValue){
            $room = $this-> roomDAO-> ReadByID($id);
            $cinemaID = $this-> roomDAO-> ReadCinemaID($id);
            if ($this-> validateRoomEdit($id, $name, $cinemaID)){
                $this-> showEditView($id, "Nombre de sala ya existente en el cine elegido. Intente con otro.", 0);
            } else {
                if ($capacity>=0) {
                    if ($ticketValue>=0) {
                        $room-> setName($name);
                        $room-> setTicketValue($ticketValue);
                        $room-> setCapacity($capacity);
                        $this-> roomDAO-> Update($room);
                        $this-> showEditView($room-> getID(), "Sala editada con éxito.", 1);
                    } else {
                        $this-> showEditView($id, "Intente usar un valor de entrada positivo.", 0);
                    }
                } else {
                    $this-> showEditView($id, "Intente usar una capacidad mayor a 0.", 0);
                }
            }
        }

        function showAddView ($cinemaId, $message = "", $messageCode = 0, Room $room = null){
            require_once(VIEWS_PATH."room-add.php");
        }

        function showEditView ($id, $message = "", $messageCode = 0){
            $room = $this-> roomDAO-> ReadByID($id);
            require_once(VIEWS_PATH."room-edit.php");
        }
        
        private function validateRoomEdit($roomID, $name, $cinemaID){
            $room = array();
            $roomsList = $this-> roomDAO-> ReadByCinemaID($cinemaID);
            foreach ($roomsList as $room){
                if ($room-> getName() == $name && $room-> getID() != $roomID){
                    return true;
                }
            }
            return false;
        }

    }

?>
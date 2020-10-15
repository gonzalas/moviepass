<?php

    namespace Controllers;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use Models\Cinema as Cinema;
    use Models\Room as Room;

    class CinemaController {

        private $cinemaDAO;
        private $roomDAO;

        public function __construct()
        {
            $this-> cinemaDAO = new CinemaDAO();
            $this-> roomDAO = new RoomDAO();
        }

        function addCinema($name, $ticketValue) {
            if ($this-> validateCinemaName($name)){
                $this-> showAddView("Nombre de cine ya existente. Intente con otro.");
            } else {
                $cinema = new Cinema();
                $cinema-> setName($name);
                $ticketValue>0 ? $cinema-> setTicketValue($ticketValue) : $this-> showAddView("Try using a positive ticket value.");
                $this-> cinemaDAO-> Add($cinema);
                $this-> showListView();
            }
        }

        function removeCinema($id){
            if ($id!=-1)
                $cinema = $this-> cinemaDAO-> GetByID($id);
                $roomsList = $this-> roomDAO-> GetAll(); /**Borramos los cinemaID de los rooms que tengan el ID del cine modificado */
                    foreach($roomsList as $room){ /**Como después se simplifica con sql, por el momento dejamos este foreach sin modularizar */
                        if ($room-> getCinemaID() == $id){
                            $this-> roomDAO-> Delete($room-> getID());
                        }
                    }
                $this-> cinemaDAO-> Delete($id);
            $cinemasList = $this-> cinemaDAO-> GetAll();
            $this-> showListView();
        }

        function editCinema ($id, $name, $ticketValue){
            if ($this-> validateCinemaEdit($id, $name)){
                $this-> showEditView($id, "Nombre de cine ya existente. Intente con otro.");
            } else {
                $cinema = new Cinema();
                $cinema-> setName($name);
                if ($ticketValue>=0) {
                    $cinema-> setTicketValue($ticketValue);
                    $this-> cinemaDAO-> Add($cinema);
                    $newID = $cinema-> getID();
                    $roomsList = $this-> roomDAO-> GetAll(); /**Actualizamos los cinemaID de los rooms que tengan el ID del cine modificado */
                    foreach($roomsList as $room){ /**Como después se simplifica con sql, por el momento dejamos este foreach sin modularizar */
                        if ($room-> getCinemaID() == $id){
                            $newRoom = new Room();
                            $newRoom-> setName($room-> getName());
                            $newRoom-> setCapacity($room-> getCapacity());
                            $newRoom-> setCinemaID($newID);
                            $this-> roomDAO-> Add($newRoom);
                            $this-> roomDAO-> Delete($room-> getID());
                        }
                    }
                    $this-> cinemaDAO-> Delete($id);
                    $this-> showListView();
                } else {
                    $this-> showEditView($id, "Intente usar un valor de entrada positivo.");
                }
            }
        }
      
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> GetAll();
            $roomsList = $this-> roomDAO-> GetAll();

            foreach ($cinemasList as $cinema){
                $cinemaID = $cinema-> getID();
                $newRoomsList = array();
                $i = 0;
                foreach ($roomsList as $room){
                    if ($room-> getCinemaID() == $cinemaID){
                        array_push($newRoomsList, $room);
                    }
                    $i++;
                }
                $cinema-> setRooms($newRoomsList);
                $totalCapacity = $this-> countTotalCapacity($cinema-> getRooms());
                $cinema-> setTotalCapacity($totalCapacity);
            }
            require_once(VIEWS_PATH."cinema-list.php");
        }

        function showAddView ($message = "", Cinema $cinema = null){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        function showEditView ($id, $message = ""){
            $cinema = $this-> cinemaDAO-> getByID($id);
            require_once(VIEWS_PATH."cinema-edit.php");
        }
        
        private function validateCinemaName($name){
            $cinemasList = $this-> cinemaDAO-> GetAll();
            foreach ($cinemasList as $cinema){
                if ($cinema-> getName() === $name){
                    return true;
                }
            }
            return false;
        }
        
        private function validateCinemaEdit($id, $name){
            $cinema = new Cinema();
            $cinema = $this-> cinemaDAO-> GetByID($id);
            if ($cinema-> getName() != $name){
                return $this-> validateCinemaName($name);
            }
            return false;
        }

        private function countTotalCapacity ($roomsList){
            $count = 0;
            foreach ($roomsList as $room){
                $count += $room-> getCapacity();
            }
            return $count;
        }

    }

?>
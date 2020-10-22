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

        function addCinema($name, $address) {
            if ($this-> validateCinemaName($name)){
                $this-> showAddView("Nombre de cine ya existente. Intente con otro.");
            } else {
                $cinema = new Cinema();
                $cinema-> setName($name);
                $cinema-> setAddress($address);
                $this-> cinemaDAO-> Create($cinema);
                $this-> showListView();
            }
        }

        function removeCinema($id){
            if ($id!=-1){
                $cinema = $this-> cinemaDAO-> ReadByID($id);
                $roomsList = $this-> roomDAO-> ReadAll(); /**Borramos los cinemaID de los rooms que tengan el ID del cine modificado */
                    foreach($roomsList as $room){ /**Como después se simplifica con sql, por el momento dejamos este foreach sin modularizar */
                        if ($room-> getCinemaID() == $id){
                            $this-> roomDAO-> Delete($room-> getID());
                        }
                    }
                $this-> cinemaDAO-> Delete($id);
            }
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            $this-> showListView();
        }

        function editCinema ($id, $name, $address){
            if ($this-> validateCinemaEdit($id, $name)){
                $this-> showEditView($id, "Nombre de cine ya existente. Intente con otro.");
            } else {
                $cinema = new Cinema();
                $cinema-> setName($name);
                $cinema-> setAddress ($address);
                $this-> cinemaDAO-> Create($cinema);
                $newID = $cinema-> getID();
                $roomsList = $this-> roomDAO-> ReadAll(); /**Actualizamos los cinemaID de los rooms que tengan el ID del cine modificado */
                foreach($roomsList as $room){ /**Como después se simplifica con sql, por el momento dejamos este foreach sin modularizar */
                    if ($room-> getCinemaID() == $id){
                        $newRoom = new Room();
                        $newRoom-> setName($room-> getName());
                        $newRoom-> setCapacity($room-> getCapacity());
                        $newRoom-> setCinemaID($newID);
                        $this-> roomDAO-> Create($newRoom);
                        $this-> roomDAO-> Delete($room-> getID());
                    }
                }
                $this-> cinemaDAO-> Delete($id);
                $this-> showListView();
            }
        }
      
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            $roomsList = $this-> roomDAO-> ReadAll();
            foreach ($cinemasList as $cinema){
                $newRooms = $this-> roomDAO-> ReadByCinemaID($cinema-> getID());
                $cinema-> setRooms($newRooms);
                $cinema-> setTotalCapacity ($this-> countTotalCapacity($newRooms));
            }
            require_once(VIEWS_PATH."cinema-list.php");
        }

        function showAddView ($message = "", Cinema $cinema = null){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        function showEditView ($id, $message = ""){
            $cinema = $this-> cinemaDAO-> ReadByID($id);
            require_once(VIEWS_PATH."cinema-edit.php");
        }
        
        private function validateCinemaName($name){
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            foreach ($cinemasList as $cinema){
                if ($cinema-> getName() === $name){
                    return true;
                }
            }
            return false;
        }
        
        private function validateCinemaEdit($id, $name){
            $cinema = new Cinema();
            $cinema = $this-> cinemaDAO-> ReadByID($id);
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
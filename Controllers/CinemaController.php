<?php

    namespace Controllers;
    use \Exception as Exception;
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
            if (!empty($this-> cinemaDAO-> ReadByName($name))){
                $this-> showAddView("Nombre de cine ya existente. Intente con otro.");
            } else {
                if (!empty($this-> cinemaDAO-> ReadByAddress($address))){
                    $this-> showAddView("Dirección ya existente. Intente con otra.");
                } else {
                    $cinema = new Cinema();
                    $cinema-> setName($name);
                    $cinema-> setAddress($address);
                    $cinema-> setIsActive(true);
                    $this-> cinemaDAO-> Create($cinema);
                    $this-> showListView();
                }
            }
        }

        function removeCinema($id){
            if ($id!=-1){
                $cinema = ($this-> cinemaDAO-> ReadByID($id))[0];
                $cinema-> setIsActive(false);
                $this-> cinemaDAO-> Update($cinema);
            }
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            $this-> showListView();
        }

        function editCinema ($id, $name, $address){
            $cinema = $this-> cinemaDAO-> ReadByID($id)[0];
            if ($this-> validateCinemaName($id, $name)){
                $this-> showEditView($id, "Nombre de cine ya existente. Intente con otro.");
            } else {
                if ($this-> validateCinemaAddress($id, $address)){
                    $this-> showEditView($id, "Dirección ya existente. Intente con otra.");
                } else {
                    $cinema-> setName($name);
                    $cinema-> setAddress ($address);
                    $this-> cinemaDAO-> Update($cinema);
                    $this-> showListView();
                }
            }
        }
      
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            $roomsList = array();
            if (!empty($cinemasList)){
                $use = true;
                $cinemasList = array_filter($cinemasList, function($cinema) use($use){
                    return $cinema-> getIsActive() == $use;
                });
                $roomsList = $this-> roomDAO-> ReadAll();
                foreach ($cinemasList as $cinema){
                    $newRooms = $this-> roomDAO-> ReadByCinemaID($cinema-> getID());
                    if ($newRooms != null){
                        $cinema-> setRooms($newRooms);
                        $cinema-> setTotalCapacity ($this-> countTotalCapacity($newRooms));
                    } else {
                        $cinema-> setTotalCapacity (0);
                        $cinema-> setRooms(array());
                    }
                }
            } else {
                $cinemasList = array();
            }
            require_once(VIEWS_PATH."cinema-list.php");
        }

        function showAddView ($message = "", Cinema $cinema = null){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        function showEditView ($id, $message = ""){
            $cinema = $this-> cinemaDAO-> ReadByID($id)[0];
            require_once(VIEWS_PATH."cinema-edit.php");
        }

        private function validateCinemaName($id, $name){
            $cinemaToCompare = $this-> cinemaDAO-> ReadByName($name);
            if (!empty($cinemaToCompare)){
                return !($cinemaToCompare[0]-> getID() == $id);
            } else {
                return false;
            }
        }

        private function validateCinemaAddress($id, $address){
            $cinemaToCompare = $this-> cinemaDAO-> ReadByAddress($address);
            if (!empty($cinemaToCompare)){
                return !($cinemaToCompare[0]-> getID() == $id);
            } else {
                return false;
            }
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
<?php

    namespace Controllers;
    use \Exception as Exception;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MovieDAO as MovieDAO;
    use Models\Cinema as Cinema;
    use Models\Room as Room;

    class CinemaController {

        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;

        public function __construct()
        {
            $this-> cinemaDAO = new CinemaDAO();
            $this-> roomDAO = new RoomDAO();
            $this-> showDAO = new ShowDAO();
            $this-> movieDAO = new MovieDAO();
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
                $cinema = ($this-> cinemaDAO-> ReadByID($id));
                $roomsList = $this-> roomDAO-> ReadByCinemaID($id);
                if ($roomsList instanceof Room){
                    $aux = $roomsList;
                    $roomsList = array();
                    array_push($roomsList, $aux);
                }
                if ($this-> validateCinemaShows($roomsList)){
                    foreach ($roomsList as $room){
                        $room-> setIsActive(false);
                        $this-> roomDAO-> Update($room);
                    }
                    $cinema-> setIsActive(false);
                    $this-> cinemaDAO-> Update($cinema);
                    $cinemasList = $this-> cinemaDAO-> ReadAll();
                    $this-> showListView("Cine eliminado con éxito.", 1);
                } else {
                    $this-> showListView("El cine no pudo ser eliminado porque tiene funciones próximas.", 2);
                }
            } else {
                $cinemasList = $this-> cinemaDAO-> ReadAll();
                $this-> showListView();
            }
        }

        function retrieveCinema($id){
            $cinema = ($this-> cinemaDAO-> ReadByID($id));
            $cinema-> setIsActive(true);
            $this-> cinemaDAO-> Update($cinema);
            $cinemasList = $this-> cinemaDAO-> ReadAll();
            $this-> showListView("Cine dado de alta con éxito.", 1);
        }

        private function validateCinemaShows ($roomsList){
            foreach ($roomsList as $room){
                $upcomingShows = $this-> showDAO-> ReadUpcomingByRoomID($room-> getID());
                if ((is_array($upcomingShows) && !empty($upcomingShows)) || $upcomingShows instanceof Show){
                    return false;
                }
            }
            return true;
        }


        function editCinema ($id, $name, $address){
            $cinema = $this-> cinemaDAO-> ReadByID($id);
            if ($this-> validateCinemaName($id, $name)){
                $this-> showEditView($id, "Nombre de cine ya existente. Intente con otro.");
            } else {
                if ($this-> validateCinemaAddress($id, $address)){
                    $this-> showEditView($id, "Dirección ya existente. Intente con otra.");
                } else {
                    $cinema-> setName($name);
                    $cinema-> setAddress ($address);
                    $this-> cinemaDAO-> Update($cinema);
                    $this-> showListView("Cine editado con éxito.", 1);
                }
            }
        }

        public function generateMovieListing(){
            $cinemasList = $this->cinemaDAO->ReadActiveCinemas();
            if ($cinemasList!= null) {
            
                $showsList = $this->showDAO->ReadAll();
                if ($showsList != null) {
                    
                    $movieListing = array();

                    foreach($showsList as $show){
                        array_push($movieListing, $this->movieDAO->ReadById($show->getMovie()));
                    }

                    foreach($cinemasList as $cinema){
                            $cinema->setMovieListing($movieListing);
                    }      
                }   
            }
            require_once(VIEWS_PATH."generate-movielisting.php");
        }
      
        function showListView ($message = "", $messageCode = 0){
            if (isset($_GET["roomMessage"])){
                $messageCode = $_GET["roomMessage"];
                switch ($messageCode){
                    case 1:
                        $message = "Sala eliminada con éxito.";
                        break;
                    case 2:
                        $message = "No se pudo eliminar la sala, porque hay funciones próximas.";
                        break;
                    case 3:
                        $message = "Sala dada de alta con éxito.";
                        break;
                    case 4:
                        $message = "No se pudo dar de alta la sala, porque pertenece a un cine eliminado.";
                        break;
                }
            } else {

            }
            if (isset($_GET['filter'])){
                $filter = $_GET['filter'];
                if (strcmp($filter, "all") == 0){
                    $cinemasList = $this-> cinemaDAO-> ReadAll();
                    if ($cinemasList instanceof Cinema){
                        $aux = $cinemasList;
                        $cinemasList = array();
                        array_push($cinemasList, $aux);
                    }
                } else {
                    $cinemasList = $this-> cinemaDAO-> ReadUnactiveCinemas();
                    if ($cinemasList instanceof Cinema){
                        $aux = $cinemasList;
                        $cinemasList = array();
                        array_push($cinemasList, $aux);
                    }
                }
            } else {
                $cinemasList = $this-> cinemaDAO-> ReadActiveCinemas();
            }
            $roomsList = array();
            if (!empty($cinemasList)){
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
            $cinema = $this-> cinemaDAO-> ReadByID($id);
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
                if ($room-> getIsActive())
                    $count += $room-> getCapacity();
            }
            return $count;
        }

    }

?>
<?php

    namespace Controllers;
    use \Exception as Exception;
    use DAO\ShowDAO as ShowDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Show as Show;
    use Models\Room as Room;
    use Models\Movie as Movie;
    use Models\Cinema as Cinema;

    class ShowController {

        private $showDAO;
        private $roomDAO;
        private $movieDAO;
        private $cinemaDAO;

        public function __construct()
        {
            $this-> showDAO = new ShowDAO();
            $this-> roomDAO = new RoomDAO();
            $this-> movieDAO = new MovieDAO();
            $this-> cinemaDAO = new CinemaDAO();
        }

        function addShow($name, $address) {
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
                    $newRooms = $this-> roomDAO-> ReadByCinemaIDValid($cinema-> getID());
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

        function showAddView ($message = ""){
            $moviesList = $this-> movieDAO-> ReadActiveMovies();
            require_once(VIEWS_PATH."show-add.php");
        }

        function addShowSecondForm (){
            if (isset($_POST['movieID']) && isset($_POST['showDate'])){
                $movieID = $_POST['movieID'];
                $showDate = $_POST['showDate'];
            }
            $dateOccupied = $this-> showDAO-> ReadByDateAndMovie($showDate, $movieID);
            if ($dateOccupied){
                $roomID = $dateOccupied;
                $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
                $movie = $this-> movieDAO-> ReadByID($movieID);
                $room = $this-> roomDAO-> ReadByID($roomID);
                $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
                require_once(VIEWS_PATH."show-add-third.php");
            } else {
                $cinemasList = $this-> cinemaDAO-> ReadActiveCinemasWithRooms();
                foreach ($cinemasList as $cinema){
                    $cinema-> setRooms($this-> roomDAO-> ReadByCinemaID($cinema-> getID()));
                }
                require_once(VIEWS_PATH."show-add-second.php");
            }
        }

        function addShowThirdForm (){
            if (isset($_POST['movieID']) && isset($_POST['showDate']) && isset($_POST['roomID'])){
                $movieID = $_POST['movieID'];
                $showDate = $_POST['showDate'];
                $roomID = $_POST['roomID'];
            }
            $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
            $movie = $this-> movieDAO-> ReadByID($movieID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $cinema = $this-> cinemaDAO-> ReadByID($cinemaID);
            require_once(VIEWS_PATH."show-add-third.php");
        }

        function horario(){
            $showTime = $_POST['showTime'];
            $endTime = date('H:i', strtotime($showTime) + 900);
            var_dump($endTime);
        }

        function validateAddShow(){
            if (isset($_POST['movieID']) && isset($_POST['showDate']) && isset($_POST['roomID']) && isset($_POST['showTime'])){
                $roomID = $_POST['roomID'];
                $movieID = $_POST['movieID'];
                $showDate = $_POST['showDate'];
                $showTime = $_POST['showTime'];
            }
            $movie = $this-> movieDAO-> ReadByID($movieID);
            $endTime = date('H:i', strtotime($showTime) + TIME_AFTER_SHOW + $movie-> getLength() * 60);
            $show = new Show();
            $show-> setDate($showDate);
            $show-> setStartTime($showTime);
            $show-> setEndTime($endTime);
            $this-> showDAO-> Create($show, $roomID, $movieID);
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
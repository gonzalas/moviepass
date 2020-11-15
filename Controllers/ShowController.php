<?php

    namespace Controllers;
    use \Exception as Exception;
    use DAO\ShowDAO as ShowDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Show as Show;
    use Models\Room as Room;
    use Models\Movie as Movie;
    use Models\Cinema as Cinema;
    use Helpers\SessionValidatorHelper as SessionValidatorHelper;

    class ShowController {

        private $showDAO;
        private $roomDAO;
        private $movieDAO;
        private $cinemaDAO;
        private $genreDAO;

        public function __construct()
        {
            $this-> showDAO = new ShowDAO();
            $this-> roomDAO = new RoomDAO();
            $this-> movieDAO = new MovieDAO();
            $this-> cinemaDAO = new CinemaDAO();
            $this-> genreDAO = new GenreDAO();
        }

        function showAddView ($message = "", $messageCode = 0){
            SessionValidatorHelper::ValidateSessionAdmin();
            $moviesList = $this-> movieDAO-> ReadActiveMovies();
            $cinemaList = $this->cinemaDAO->ReadActiveCinemasWithRooms();
            require_once(VIEWS_PATH."show-add.php");
        }

        function addShowSecondForm ($movieID, $showDate){
            SessionValidatorHelper::ValidateSessionAdmin();
            $dateOccupied = $this-> showDAO-> ReadByDateAndMovie($showDate, $movieID);
            if ($dateOccupied){
                $roomID = $dateOccupied;
                $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
                $movie = $this-> movieDAO-> ReadByID($movieID);
                $room = $this-> roomDAO-> ReadByID($roomID);
                $room-> setCinema($this-> cinemaDAO-> ReadByID($cinemaID));
                $showsList = $this-> showDAO-> ReadByDateAndRoom ($showDate, $roomID);
                if ($showsList instanceof Show){
                    $aux = $showsList;
                    $showsList = array();
                    array_push($showsList, $aux);
                }
                require_once(VIEWS_PATH."show-add-third.php");
            } else {
                $cinemasList = $this-> cinemaDAO-> ReadActiveCinemasWithRooms();
                foreach ($cinemasList as $cinema){
                    $cinema-> setRooms($this-> roomDAO-> ReadByCinemaIDValid($cinema-> getID()));
                }
                require_once(VIEWS_PATH."show-add-second.php");
            }
        }

        function addShowThirdForm ($roomID, $showDate, $movieID){
            SessionValidatorHelper::ValidateSessionAdmin();
            $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
            $movie = $this-> movieDAO-> ReadByID($movieID);
            $room = $this-> roomDAO-> ReadByID($roomID);
            $room-> setCinema($this-> cinemaDAO-> ReadByID($cinemaID));
            $showsList = $this-> showDAO-> ReadByDateAndRoom ($showDate, $roomID);
            if ($showsList instanceof Show){
                $aux = $showsList;
                $showsList = array();
                array_push($showsList, $aux);
            }
            require_once(VIEWS_PATH."show-add-third.php");
        }

        function validateAddShow($movieID, $cinemaID, $roomID, $showDate, $showTime){
            $movie = $this-> movieDAO-> ReadByID($movieID);
            $endTime = date('H:i', strtotime($showTime) + TIME_AFTER_SHOW + $movie-> getLength() * 60);
            $showsList = $this-> showDAO-> ReadByDateAndRoom ($showDate, $roomID);
            if ($showsList instanceof Show){
                $aux = $showsList;
                $showsList = array();
                array_push($showsList, $aux);
            }
            if ($this-> validateShowTime($showTime, $endTime, $showsList)){
                $show = new Show();
                $show-> setDate($showDate);
                $show-> setStartTime($showTime);
                $show-> setEndTime($endTime);
                $this-> showDAO-> Create($show, $roomID, $movieID);
                $this-> showAddView("Función agregada con éxito.", 1);
            } else {
                $this-> showAddView("La función no pudo ser agregada porque coincide con los horarios de otra función.", 2);
            }
        }

        /**Validates if selected times for a show are available */
        private function validateShowTime($startTime, $endTime, $showsList){
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            /**Times used to avoid conflicts if a show ends on the next day */
            $endTimeLimit = strtotime("23:59:59");
            $startTimeLimit = strtotime("10:59:00");
            /** Used to avoid conflicts if a show ends on the next day */
            if ($endTime < $startTimeLimit){
                $endTime = $endTimeLimit;
            }
            if (is_array($showsList)){ 
                foreach ($showsList as $show){
                    $showStartTime = strtotime($show-> getStartTime());
                    /**Determines if the current show starts before the new show */
                    if ($showStartTime < $startTime){
                        $showEndTime = strtotime($show-> getEndTime());
                        /** Used to avoid conflicts if a show ends on the next day */
                        if ($showEndTime < $startTimeLimit){
                            $showEndTime = $endTimeLimit;
                        }
                        /**If the current show ending time has a conflict with the new show start time */
                        if ($showEndTime > $startTime){
                            return false;
                        }
                    } else {
                        /**If the current show start time has a conflict with the new show ending time */
                        if ($showStartTime < $endTime){
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        function showEditView ($id, $message = ""){
            SessionValidatorHelper::ValidateSessionAdmin();
            $cinema = $this-> cinemaDAO-> ReadByID($id)[0];
            require_once(VIEWS_PATH."cinema-edit.php");
        }

        function showUpcomingShows ($success = 0, $time = "upcoming", $genreID = -1){
            SessionValidatorHelper::ValidateSessionAdmin();
            if (strcmp($time, "0") != 0){
                if (strcmp($time, "previous") == 0){
                    $showsList = $this-> showDAO-> ReadPrevious();
                    if ($showsList instanceof Show){
                        $aux = $showsList;
                        $showsList = array();
                        array_push($showsList, $aux);
                    }
                } else {
                    $showsList = $this-> showDAO-> ReadUpcoming();
                    if ($showsList instanceof Show){
                        $aux = $showsList;
                        $showsList = array();
                        array_push($showsList, $aux);
                    }
                }
            } else {
                if ($genreID != -1){
                    $filterGenre = $this-> genreDAO-> ReadByID($genreID);
                    $showsList = $this-> showDAO-> ReadByGenreID($genreID);
                    if ($showsList instanceof Show){
                        $aux = $showsList;
                        $showsList = array();
                        array_push($showsList, $aux);
                    }
                } else {
                    $showsList = $this-> showDAO-> ReadAll();
                    if ($showsList instanceof Show){
                        $aux = $showsList;
                        $showsList = array();
                        array_push($showsList, $aux);
                    }
                }
            }

            $emptyList = empty($showsList);
            if(!$emptyList){
                foreach ($showsList as $show){
                    $movieID = $this-> showDAO-> ReadMovieID($show-> getID());
                    $show-> setMovie($this-> movieDAO-> ReadByID($movieID));
                }
                foreach ($showsList as $show){
                    $roomID = $this-> showDAO-> ReadRoomID($show-> getID());
                    $cinemaID = $this-> roomDAO-> ReadCinemaID($roomID);
                    $room = $this-> roomDAO-> ReadByID ($roomID);
                    $room-> setCinema($this-> cinemaDAO-> ReadByID($cinemaID));
                    $show-> setRoom($room);
                    $soldTickets = $this-> showDAO-> CountShowSoldTickets($show-> getID());
                    $show-> setSoldTickets($soldTickets);
                    $gatheredMoney = $this-> showDAO-> SumGatheredMoney($show->getID());
                    $show-> setGatheredMoney($gatheredMoney);
                }    
            }

            if ($success == 1){
                $message = "Función eliminada con éxito.";
            }
            
            $genresList = $this-> genreDAO-> ReadAll();
            $today = $today = date("Y-m-d");
            require_once (VIEWS_PATH."show-list.php");
        }

        function removeShow($showID){
            SessionValidatorHelper::ValidateSessionAdmin();
            $this-> showDAO-> Delete($showID);
            header ("location: ".FRONT_ROOT."Show/showUpcomingShows/?success=1");
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
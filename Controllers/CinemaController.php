<?php

    namespace Controllers;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaController {

        private $cinemaDAO;

        public function __construct()
        {
            $this-> cinemaDAO = new CinemaDAO();
        }

        function addCinema($name, $ticketValue) {
            $cinema = new Cinema();
            $cinema-> setName($name);
            $ticketValue>0 ? $cinema-> setTicketValue($ticketValue) : $this-> showAddView("Try using a positive ticket value.");
            $this-> cinemaDAO-> Add($cinema);
            $this-> showListView();
        }

        function removeCinema($id){
            $this-> cinemaDAO-> Delete($id);
            require_once(VIEWS_PATH."cinema-list.php");
        }

        function editCinema ($id){
            $cinema = $cinemaDAO-> getByID($id);
            $this-> showAddView($cinema);
        }

        private function showListView (){
            $cinemasList = $this-> cinemaDAO-> GetAll();
            require_once(VIEWS_PATH."cinema-list.php");
        }

        private function showAddView ($message = ""){
            require_once(VIEWS_PATH."cinema-add.php");
        }

    }

?>
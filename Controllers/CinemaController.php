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
            $this-> cinemaDAO-> Delete($id);
            $cinemasList = $this-> cinemaDAO-> GetAll();
            require_once(VIEWS_PATH."cinema-list.php");
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
                    $this-> removeCinema($id);
                } else {
                    $this-> showEditView($id, "Intente usar un valor de entrada positivo.");
                }
            }
        }
      
        function showListView (){
            $cinemasList = $this-> cinemaDAO-> GetAll();
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

    }

?>
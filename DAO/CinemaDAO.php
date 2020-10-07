<?php

    namespace DAO;
    use Models\Cinema as Cinema;
    use Models\Room as Room;
    use DAO\ICinemaDAO as ICinemaDAO;

    class CinemaDAO implements ICinemaDAO{

        private $fileName = ROOT."Data/cinemas.json";
        private $cinemaList = array();

        function Add(Cinema $cinema) {
            $this-> RetrieveData();
            $cinema-> setID (GetNextID());
            array_push($this-> cinemaList, $cinema);
            $this-> SaveData();
        }

        function GetAll() {
            $this-> RetrieveData();
            return $this-> cinemaList;
        }

        function GetByID($id) {
            $this-> RetrieveData();
            foreach ($this-> cinemaList as $currentCinema){
                if ($currentCinema-> getID() == $id){
                    return $currentCinema;
                }
            }
            return null;
        }

        function Delete($id) {
            $this-> RetrieveData();
            $this-> cinemaList = 
            array_filter ($this-> cinemaList, function($cinema) use($id){
                return $cinema-> getID() != $id;
            });
            $this-> SaveData();
        }

        private function GetNextID() {
            $id = 0;
            if (count($this-> cinemaList)){ //Checks if cinemaList has at least 1 value
                $cinema = array_pop($cinemaList);
                $id = ($cinema-> getID()) + 1;
            }

            return $id;
        }

        private function RetrieveData() {
            $this-> cinemaList = array();
            if (file_exists($this-> fileName)){
                $jsonContent = file_get_contents($this-> fileName);
                if ($jsonContent){
                    $arrayToDecode = json_decode($jsonContent, true);

                    foreach ($arrayToDecode as $arrayContent){
                        $cinema = new Cinema();
                        $cinema-> setID ($arrayContent["ID"]);
                        $cinema-> setName ($arrayContent["name"]);
                        $cinema-> setTicketValue ($arrayContent["ticketValue"]);
                        $cinema-> setMovieListing ($arrayContent["movieListing"]);
                        $cinemaCapacity = 0;
                        $roomsList = array();

                        foreach($arrayContent["roomsList"] as $room){
                            $newRoom = new Room();
                            $newRoom-> setID($room["ID"]);
                            $newRoom-> setName($room["name"]);
                            $newRoom-> setIs3D($room["is3D"]);
                            $newRoom-> setIsAtmos($room["isAtmos"]);
                            $newRoom-> setCapacity($room["capacity"]);
    
                            $cinemaCapacity += $room["capacity"];
                            array_push ($roomsList, $newRoom);
                        }

                        $cinema-> setRoomsList ($roomsList);
                        $cinema-> setTotalCapacity ($cinemaCapacity);

                        array_push ($this-> cinemaList, $cinema);
                    }
                }
            }
        }

        private function SaveData() {
            $arrayToEncode = array();

            foreach($this-> cinemaList as $cinema)
            {
                //Cinema
                $valuesArray["ID"] = $cinema-> getID();
                $valuesArray["name"] = $cinema-> getName();
                $valuesArray["ticketValue"] = $cinema-> getTicketValue();
                $valuesArray["totalCapacity"] = $cinema-> getTotalCapacity();
                $valuesArray["movieListing"] = $cinema-> getMovieListing();

                //Rooms List
                $valuesArray["roomsList"] = array();
                foreach($cinema->getRoomsList() as $room){
                    $valuesArray["roomsList"][] = array(
                        'ID' => $room-> getID(),
                        'name' => $room-> getName(),
                        'is3D' => $room-> getIs3D(),
                        'isAtmos' => $room-> getIsAtmos(),
                        'capacity' => $room-> getCapacity(),
                    );
                }

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this-> fileName, $jsonContent);
        }

    }

?>
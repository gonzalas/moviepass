<?php

    namespace DAO;
    use Models\Cinema as Cinema;
    use Models\Room as Room;
    use DAO\ICinemaDAO as ICinemaDAO;

    class JCinemaDAO /* implements ICinemaDAO */{

        private $fileName = ROOT."Data/cinemas.json";
        private $cinemaList = array();

        function Create(Cinema $cinema) {
            $this-> RetrieveData();
            $cinema-> setID ($this-> GetNextID());
            $cinema-> setTotalCapacity (0);
            array_push($this-> cinemaList, $cinema);
            $this-> SaveData();
        }

        function ReadAll() {
            $this-> RetrieveData();
            return $this-> cinemaList;
        }

        function ReadByID($id) {
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
                $cinema = array_pop($this-> cinemaList);
                $id = ($cinema-> getID()) + 1;
                array_push($this-> cinemaList, $cinema);
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
                        $cinema-> setAddress($arrayContent["address"]);
                        $cinemaCapacity = 0;
                        $roomsList = array();

                        foreach($arrayContent["roomsList"] as $room){
                            $newRoom = new Room();
                            $newRoom-> setID($room["ID"]);
                            $newRoom-> setCinemaID($room["cinemaID"]); /*En json no es necesario pero lo dejamos para sql*/
                            $newRoom-> setName($room["name"]);
                            $newRoom-> setTicketValue($room['ticketValue']);
                            $newRoom-> setCapacity($room["capacity"]);
    
                            $cinemaCapacity += $room["capacity"];
                            array_push ($roomsList, $newRoom);
                        }

                        $cinema-> setRooms ($roomsList);
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
                $valuesArray["address"] = $cinema-> getAddress();
                $valuesArray["totalCapacity"] = $cinema-> getTotalCapacity();

                //Rooms List
                $valuesArray["roomsList"] = array();
                foreach($cinema->getRooms() as $room){
                    $valuesArray["roomsList"][] = array(
                        'ID' => $room-> getID(),
                        'cinemaID' => $room-> getCinemaID(),
                        'ticketValue' => $room-> getTicketValue(),
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
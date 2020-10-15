<?php

    namespace DAO;
    use Models\Room as Room;
    use Models\Cinema as Cinema;
    use DAO\IRoomDAO as IRoomDAO;

    class RoomDAO implements IRoomDAO{

        private $fileName = ROOT."Data/rooms.json";
        private $roomList = array();

        function Add(Room $room) {
            $this-> RetrieveData();
            $room-> setID ($this-> GetNextID());
            array_push($this-> roomList, $room);
            $this-> SaveData();
        }

        function GetAll() {
            $this-> RetrieveData();
            return $this-> roomList;
        }

        function GetByID($id) {
            $this-> RetrieveData();
            foreach ($this-> roomList as $currentRoom){
                if ($currentRoom-> getID() == $id){
                    return $currentRoom;
                }
            }
            return null;
        }

        function Delete($id) {
            $this-> RetrieveData();
            $this-> roomList = 
            array_filter ($this-> roomList, function($room) use($id){
                return $room-> getID() != $id;
            });
            $this-> SaveData();
        }

        private function GetNextID() {
            $id = 0;
            if (count($this-> roomList)){ //Checks if roomList has at least 1 value
                $room = array_pop($this-> roomList);
                $id = ($room-> getID()) + 1;
                array_push($this-> roomList, $room);
            }

            return $id;
        }

        private function RetrieveData() {
            $this-> roomList = array();
            if (file_exists($this-> fileName)){
                $jsonContent = file_get_contents($this-> fileName);
                if ($jsonContent){
                    $arrayToDecode = json_decode($jsonContent, true);

                    foreach ($arrayToDecode as $arrayContent){
                        $room = new Room();
                        $room-> setID ($arrayContent["ID"]);
                        $room-> setCinemaID ($arrayContent["cinemaID"]);
                        $room-> setName ($arrayContent["name"]);
                        $room-> setCapacity ($arrayContent["capacity"]);

                        array_push ($this-> roomList, $room);
                    }
                }
            }
        }

        private function SaveData() {
            $arrayToEncode = array();

            foreach($this-> roomList as $room)
            {
                $valuesArray["ID"] = $room-> getID();
                $valuesArray["cinemaID"] = $room-> getCinemaID();
                $valuesArray["name"] = $room-> getName();
                $valuesArray["capacity"] = $room-> getCapacity();

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this-> fileName, $jsonContent);
        }

    }

?>
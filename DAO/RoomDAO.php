<?php

    namespace DAO;
    use Models\Room as Room;
    use DAO\IRoomDAO as IRoomDAO;
    use DAO\Connection as Connection;

    class RoomDAO implements IRoomDAO{

        private $connection;


        public function Create(Room $room, $cinemaID) {
            $sql = "INSERT INTO rooms (cinemaID, name, capacity, ticketValue, isActive) VALUES (:cinemaID, :name, :capacity, :ticketValue, :isActive)";
        
            $parameters['cinemaID'] = $cinemaID;
            $parameters['name'] = $room->getName();
            $parameters['capacity'] = $room->getCapacity();
            $parameters['ticketValue'] = $room->getTicketValue();
            $parameters['isActive'] = $room->getIsActive();

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }
        }

        public function ReadAll() {
            $sql = "SELECT * FROM rooms";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }
            
            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }


        public function ReadByID($id) {
            
            $sql = "SELECT * FROM rooms WHERE roomID = :id";

            $parameters['id'] = $id;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result)[0];
            } else
                return false;
        }


        public function ReadCinemaID($roomID){
            $sql = "SELECT cinemaID FROM rooms WHERE roomID = :roomID";

            $parameters['roomID'] = $roomID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            return $result[0][0];
        }

        public function ReadByCinemaID($cinemaID){
            $sql = "SELECT * FROM rooms WHERE cinemaID = :cinemaID";

            $parameters['cinemaID'] = $cinemaID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return array();
        }

        public function ReadByCinemaIDValid($cinemaID){
            $sql = "SELECT * FROM rooms WHERE cinemaID = :cinemaID and isActive = 1";

            $parameters['cinemaID'] = $cinemaID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadRoomByCinemaIDValid($cinemaID, $roomID){
            $sql = "SELECT * FROM rooms WHERE cinemaID = :cinemaID and roomID = :roomID and isActive = 1";

            $parameters['cinemaID'] = $cinemaID;
            $parameters['roomID'] = $roomID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadByName($cinemaID, $name) {
        
            $sql = "SELECT * FROM rooms WHERE name = :name AND cinemaID = :cinemaID";

            $parameters['name'] = $name;
            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $this->mapear($result);
            } else {
                return false;
            }
        }


        public function Update($room){
            $sql = "UPDATE rooms SET roomID = :id, name = :name, ticketValue = :ticketValue, capacity = :capacity, isActive = :isActive WHERE roomID = :id";

            $parameters['id'] = $room->getID();
            $parameters['name'] = $room->getName();
            $parameters['ticketValue'] = $room->getTicketValue();
            $parameters['capacity'] = $room->getCapacity();
            $parameters['isActive'] = $room->getIsActive();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch (PDOException $ex) {
                throw $ex;
            }

        } 


        public function Delete($id) {
            
        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];
        
            $resp = array_map(function($p){
                    $room = new Room();
                    $room->setID($p["roomID"]);
                    $room->setCinema($p["cinemaID"]);
                    $room->setName($p["name"]);
                    $room->setTicketValue($p['ticketValue']);
                    $room->setCapacity($p["capacity"]);
                    $room->setIsActive($p["isActive"]);
                    return $room;
                },$value);

                return $resp;
        }
    } 

?>
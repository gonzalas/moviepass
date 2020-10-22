<?php

    namespace DAO;
    use Models\Room as Room;
    use DAO\IRoomDAO as IRoomDAO;
    use DAO\Connection as Connection;

    class RoomDAO implements IRoomDAO{

        private $connection;


        public function Create(Room $room) {
            $sql = "INSERT INTO rooms (cinemaID, name, capacity, ticketValue, isActive) VALUES (:cinemaID, :name, :capacity, :ticketValue, :isActive)";
        
            $parameters['cinemaID'] = $room->getcinemaID();
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
            
            $sql = "SELECT * FROM rooms WHERE id = :id";

            $parameters['id'] = $id;
            
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

        public function ReadByCinemaID($cinemaID){
            $sql = "SELECT * FROM rooms WHERE cinemaID = :cinemaID";

            $parameters['cinemaID'] = $id;
            
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


        public function Update($room){
            $sql = "UPDATE rooms SET id = :id, cinemaID = :cinemaID, name = :name, ticketValue = :ticketValue, capacity = :capacity, isActive = :isActive";

            $parameters['id'] = $room->getID();
            $parameters['cinemaID'] = $room->getCinemaID();
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
            $sql = "DELETE FROM rooms WHERE id = :id";

            $parameters['id'] = $room->getID();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch (PDOException $ex) {
                throw $ex;
            }
        }


        private function GetNextID() {
            
        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];
        
            $resp = array_map(function($p){
                    $room = new Room();
                    $room->setID($p["id"]);
                    $room->setCinemaID($p["cinemaID"]);
                    $room->setName($p["name"]);
                    $room->setTicketValue($p['ticketValue']);
                    $room->setCapacity($p["capacity"]);
                    $room->setIsActive($p["isActive"]);
                    return $room;
                },$value);

                return count($resp) > 1 ? $resp : $resp['0'];
        }
    } 

?>
<?php

    namespace DAO;
    use Models\Cinema as Cinema;
    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;

    class CinemaDAO implements ICinemaDAO{
        
        
        private $connection;

        public function Create(Cinema $cinema) {
            
            $sql = "INSERT INTO cinemas(name, address, isActive) VALUES (:name, :address, :isActive)";

            $parameters['name'] = $cinema->getName();
            $parameters['address'] = $cinema->getAddress();
            $parameters['isActive'] = $cinema->getIsActive();

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql,$parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }
            
        }


        public function ReadByID($id) {
        
            $sql = "SELECT * FROM cinemas WHERE cinemaID = :id";

            $parameters['id'] = $id;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $this->mapear($result)[0];
            }else
            {
                return false;
            }
        }

        public function ReadByName($name) {
        
            $sql = "SELECT * FROM cinemas WHERE name = :name";

            $parameters['name'] = $name;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $this->mapear($result);
            }else
            {
                return false;
            }
        }

        public function ReadByAddress($address) {
        
            $sql = "SELECT * FROM cinemas WHERE address = :address";

            $parameters['address'] = $address;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $this->mapear($result);
            }else
            {
                return false;
            }
        }


        public function ReadAll() {
            $sql = "SELECT * FROM cinemas";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $this->mapear($result);
            }else {
                return false;
            }
        }

        public function ReadActiveCinemas(){
 
            $sql = "SELECT * FROM cinemas WHERE isActive = true";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;
        }

        public function CountCinemaSoldTickets($cinemaID){
            $sql = "select count(*) from tickets t
            inner join purchases p
            on t.purchaseID = p.purchaseID
            inner join shows s
            on p.showID = s.showID
            inner join rooms r
            on s.roomID = r.roomID and r.cinemaID = :cinemaID;";

            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountCinemaTotalShowsCapacity($cinemaID){
            $sql = "select sum(r.capacity) from rooms r
            inner join shows s
            on s.roomID = r.roomID and r.cinemaID = :cinemaID;";

            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountCinemaPossibleTotalMoney($cinemaID){
            $sql = "select sum(r.ticketValue * r.capacity) from rooms r
            inner join shows s
            on s.roomID = r.roomID and r.cinemaID = :cinemaID;";

            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountCinemaGatheredMoney($cinemaID){
            $sql = "SELECT ifnull(sum(p.purchaseTotal), 0) as totalSales from purchases p
            INNER JOIN shows s
            ON p.showID = s.showID 
            inner join rooms r
            on s.roomID = r.roomID and r.cinemaID = :cinemaID;";

            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function ReadUnactiveCinemas(){
 
            $sql = "SELECT * FROM cinemas WHERE isActive = false";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadActiveCinemasWithRooms(){
 
            $sql = "SELECT c.cinemaID as cinemaID, c.name as name, c.isActive as isActive, c.address as address FROM
                    cinemas c
                    INNER JOIN rooms r
                    ON r.cinemaID = c.cinemaID AND r.isActive = true AND c.isActive = true
                    GROUP BY c.cinemaID;";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;
        }

        public function Update($cinema) {
            
            $sql = "UPDATE cinemas SET name = :name, address = :address, isActive = :isActive WHERE cinemaID = :cinemaID";

            $parameters['name'] = $cinema->getName();
            $parameters['address'] = $cinema->getAddress();
            $parameters['isActive'] = $cinema->getIsActive();
            $parameters['cinemaID'] = $cinema->getID();

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }
        }

        public function Delete($id){}

        private function mapear($value) {
           
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $cinema = new Cinema();
                $cinema->setID($p['cinemaID']);
                $cinema->setName($p['name']);
                $cinema->setAddress($p['address']);
                $cinema->setIsActive($p['isActive']);
                return $cinema;
            },$value);

            return $resp;
        }

    }

?>
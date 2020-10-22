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
                return $this->mapear($result);
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

        public function Delete($id){

        }

        public function GetNextID() {
            
        }

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
<?php
    namespace DAO;
    use DAO\IShowDAO as IShowDAO;
    use DAO\Connection as Connection;
    use Models\Show as Show;

    class ShowDAO implements IShowDAO{  
    
        private $connection;

        public function Create($show){

            $sql = "INSERT INTO shows (roomID, movieID, date, time, isActive) VALUES (:roomID, :movieID, :date, :time, :isActive)";

            $parameters['roomID'] = $show->getRoomID(); 
            $parameters['movieID'] = $show->getMovieID(); 
            $parameters['date'] = $show->getDate(); 
            $parameters['time'] = $show->getTime(); 
            $parameters['isActive'] = $show->getIsActive(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(PDOException $ex){
                throw $ex;
            }
        } 
        
        public function ReadById($id){
            
            $sql = "SELECT * FROM shows WHERE id = :id";

            $parameters['id'] = $id;
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;    
        }

        public function ReadAllByRoomID($roomID){
            $sql = "SELECT * FROM shows WHERE roomID = :roomID";

            $this->connection = Connection::getInstance();
            $result = $this->connection->execute($sql);

            try {

                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);

            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function Update($show){

            $sql = "UPDATE shows SET id = :id, roomID = :roomID, movieID = :movieID, date = :date, time = :time, isActive = :isActive";

            $parameters['id'] = $show->getID();
            $parameters['roomID'] = $show->getRoomID(); 
            $parameters['movieID'] = $show->getMovieID(); 
            $parameters['date'] = $show->getDate(); 
            $parameters['time'] = $show->getTime(); 
            $parameters['isActive'] = $show->getIsActive(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function Delete($id){
            $sql = "DELETE FROM shows WHERE id = :id";

            $parameters['id'] = $id;

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            }catch(PDOException $ex){
                throw $ex;
            }
        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $show = new Show();
                $show->setID($p['id']);
                $show->setRoomID($p['roomID']);
                $show->setMovieID($p['movieID']);
                $show->setDate($p['date']);
                $show->setTime($p['time']);
                $show->setIsActive($p['isActive']);
                return $show;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
}   
?>
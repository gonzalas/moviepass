<?php
    namespace DAO;
    use DAO\IShowDAO as IShowDAO;
    use DAO\Connection as Connection;
    use Models\Show as Show;

    class ShowDAO implements IShowDAO{  
    
        private $connection;

        public function Create(Show $show, $roomID, $movieID){

            $sql = "INSERT INTO shows (roomID, movieID, showDate, startTime, endTime, isActive) VALUES (:roomID, :movieID, :showDate, :startTime, :endTime, :isActive)";

            $parameters['roomID'] = $roomID; 
            $parameters['movieID'] = $movieID; 
            $parameters['showDate'] = $show->getDate(); 
            $parameters['startTime'] = $show->getStartTime(); 
            $parameters['endTime'] = $show->getEndTime();
            $parameters['isActive'] = true; 

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

        /**Returns a room ID if the date is already in use, 0 if not */
        public function ReadByDateAndMovie($showDate, $movieID){
            
            $sql = "SELECT roomID FROM shows WHERE showDate = :showDate AND movieID = :movieID GROUP BY roomID";

            $parameters['showDate'] = $showDate;
            $parameters['movieID'] = $movieID;
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)) {
                return $result[0][0];
            } else
                return false;    
        }

        public function ReadMovieID($showID){
            $sql = "SELECT movieID FROM shows WHERE showID = :showID";

            $parameters['showID'] = $showID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            return $result[0][0];
        }

        public function ReadRoomID($showID){
            $sql = "SELECT roomID FROM shows WHERE showID = :showID";

            $parameters['showID'] = $showID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            return $result[0][0];
        }

        public function ReadAll(){
            $sql = "SELECT * FROM shows";

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

        public function ReadPrevious(){
            $sql = "SELECT * FROM shows WHERE (showDate < CURDATE() OR (showDate = CURDATE() AND startTime <= CURTIME()));";

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

        public function ReadUpcoming(){
            $sql = "SELECT * FROM shows WHERE (showDate > CURDATE() OR (showDate = CURDATE() AND startTime >= CURTIME()));";

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

        public function ReadAllByRoomID($roomID){
            $sql = "SELECT * FROM shows WHERE roomID = :roomID";

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadUpcomingByRoomID($roomID){
            $sql = "SELECT * FROM shows WHERE ((showDate > CURDATE() AND roomID = :roomID) OR (showDate = CURDATE() AND startTime >= CURTIME() AND roomID = :roomID));";
            $parameters['roomID'] = $roomID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->Execute($sql, $parameters);

            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function Update($show, $roomID, $movieID){

            $sql = "UPDATE shows SET roomID = :roomID, movieID = :movieID, showDate = :showDate, startTime = :startTime, endTime = :endTime, isActive = :isActive";

            $parameters['roomID'] = $roomID; 
            $parameters['movieID'] = $movieID; 
            $parameters['showDate'] = $show->getDate(); 
            $parameters['startTime'] = $show->getStartTime();
            $parameters['endTime'] = $show->getEndTime();  
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
                $show->setID($p['showID']);
                $show->setDate($p['showDate']);
                $show->setStartTime($p['startTime']);
                $show->setEndTime($p['endTime']);
                $show->setIsActive($p['isActive']);
                return $show;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
}   
?>
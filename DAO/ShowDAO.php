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
        
        public function ReadById($showID){
            
            $sql = "SELECT * FROM shows WHERE showID = :showID";

            $parameters['showID'] = $showID;
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

        public function ReadByDateAndRoom($showDate, $roomID){
            
            $sql = "SELECT * FROM shows WHERE showDate = :showDate AND roomID = :roomID order by startTime";

            $parameters['showDate'] = $showDate;
            $parameters['roomID'] = $roomID;
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
            $sql = "SELECT * FROM shows WHERE isActive = true order by showDate";

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
            $sql = "SELECT * FROM shows WHERE (showDate < CURDATE() OR (showDate = CURDATE() AND startTime <= CURTIME())) AND isActive = true order by showDate";

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
            $sql = "SELECT * FROM shows WHERE (showDate > CURDATE() OR (showDate = CURDATE() AND startTime >= CURTIME())) order by showDate";

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
            $sql = "SELECT * FROM shows WHERE roomID = :roomID order by showDate";

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

        /**Used to check if a room selected to delete has upcoming shows */
        public function ReadUpcomingByRoomID($roomID){
            $sql = "SELECT * FROM shows WHERE ((showDate > CURDATE() AND roomID = :roomID) OR (showDate = CURDATE() AND startTime >= CURTIME() AND roomID = :roomID)) order by startTime";
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

        /**Used to build a cinema schedule. Returns one function per upcoming movie */
        public function ReadMovieListingByCinemaID($cinemaID){
            $sql = "SELECT showID, showDate, startTime, endTime, s.isActive FROM shows s 
            INNER JOIN rooms r 
            ON s.roomID = r.roomID AND r.cinemaID = :cinemaID 
            HAVING (showDate > CURDATE()) OR (showDate = CURDATE() AND startTime >= CURTIME());";
            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadUpcomingByCinemaID($cinemaID){
            $sql = "SELECT showID, showDate, startTime, endTime, s.isActive FROM shows s 
            INNER JOIN rooms r 
            ON s.roomID = r.roomID AND r.cinemaID = :cinemaID 
            HAVING (showDate > CURDATE()) OR (showDate = CURDATE() AND startTime >= CURTIME());";
            $parameters['cinemaID'] = $cinemaID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadUpcomingByCinemaAndMovie($cinemaID, $movieID){
            $sql = "SELECT showID, showDate, startTime, endTime, s.isActive FROM shows s 
            INNER JOIN rooms r 
            ON s.roomID = r.roomID AND r.cinemaID = :cinemaID AND s.movieID = :movieID
            HAVING (showDate > CURDATE()) OR (showDate = CURDATE() AND startTime >= CURTIME());";
            $parameters['cinemaID'] = $cinemaID;
            $parameters['movieID'] = $movieID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function ReadByGenreID($genreID){
            $sql = "SELECT showID, showDate, startTime, endTime, isActive FROM shows s 
            INNER JOIN genresxmovies gxm
            ON s.movieID = gxm.movieID AND gxm.genreID = :genreID
            HAVING (showDate > CURDATE()) OR (showDate = CURDATE() AND startTime >= CURTIME())
            ORDER BY showDate";
            $parameters['genreID'] = $genreID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
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

        public function CountShowSoldTickets($showID){
            $sql = "SELECT count(*) FROM tickets t
            INNER JOIN purchases p
            ON t.purchaseID = p.purchaseID AND p.showID = :showID;";

            $parameters['showID'] = $showID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function SumGatheredMoney($showID){
            $sql = "SELECT sum(p.purchaseTotal) FROM purchases p WHERE p.showID = :showID;";

            $parameters['showID'] = $showID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function Delete($id){
            $sql = "UPDATE shows SET isActive = false WHERE showID = :id";

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
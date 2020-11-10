<?php
    namespace DAO;
    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use Models\Movie as Movie;

    class MovieDAO implements IMovieDAO{
        private $connection;
        
        public function Create($movie){

            $sql = "INSERT INTO movies (movieID, title, overview, dateRelease, length, posterPath, trailerPath, language, voteAverage, isActive) VALUES (:movieID, :title, :overview, :dateRelease, :length, :posterPath, :trailerPath, :language, :voteAverage, :isActive)";
            
            $parameters['movieID'] = $movie->getID();
            $parameters['title'] = $movie->getTitle();
            $parameters['overview'] = $movie->getOverview();
            $parameters['dateRelease'] = $movie->getReleaseDate();
            $parameters['length'] = $movie->getLength();
            $parameters['posterPath'] = $movie->getImage();
            $parameters['trailerPath'] = $movie->getTrailer();
            $parameters['language'] = $movie->getLanguage();
            $parameters['voteAverage'] = $movie->getVoteAverage();
            $parameters['isActive'] = true;

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }
        }

        public function ReadById($id){
 
            $sql = "SELECT * FROM movies WHERE movieID = :movieID";

            $parameters['movieID'] = $id;

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

        public function ReadActiveMovies(){
 
            $sql = "SELECT * FROM movies WHERE isActive = true";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                if (count($result)>1){
                    return $this->mapear($result);
                } else {
                    $mappedResult = $this->mapear($result);
                    $finalResult = array();
                    array_push($finalResult, $mappedResult);
                    return $finalResult;
                }
            } else
                return false;
        }

        public function ReadDeletedMovies(){
 
            $sql = "SELECT * FROM movies WHERE isActive = false";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if(!empty($result)) {
                if (count($result)>1){
                    return $this->mapear($result);
                } else {
                    $mappedResult = $this->mapear($result);
                    $finalResult = array();
                    array_push($finalResult, $mappedResult);
                    return $finalResult;
                }
            } else
                return false;
        }

        public function ReadAll(){

            $sql = "SELECT * FROM movies";

            try {

                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);

            } catch(Exception $err){
                throw $err;
            }

            if(!empty($result)) {
                if (count($result)>1){
                    return $this->mapear($result);
                } else {
                    $mappedResult = $this->mapear($result);
                    $finalResult = array();
                    array_push($finalResult, $mappedResult);
                    return $finalResult;
                }
            } else
                return false;

        }

        public function Update($movie){

            $sql = "UPDATE movies SET title = :title, overview = :overview, dateRelease = :dateRelease, length = :length, posterPath = :posterPath, trailerPath = :trailerPath, language = :language, voteAverage = :voteAverage, isActive = :isActive WHERE movieID = :movieID";
            
            $parameters['movieID'] = $movie->getID();
            $parameters['title'] = $movie->getTitle();
            $parameters['overview'] = $movie->getOverview();
            $parameters['dateRelease'] = $movie->getReleaseDate();
            $parameters['length'] = $movie->getLength();
            $parameters['posterPath'] = $movie->getImage();
            $parameters['trailerPath'] = $movie->getTrailer();
            $parameters['language'] = $movie->getLanguage();
            $parameters['voteAverage'] = $movie->getVoteAverage();
            $parameters['isActive'] = $movie->getisActive();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }

        }

        public function CountMovieSoldTickets($movieID){
            $sql = "SELECT count(*) FROM tickets t
            INNER JOIN purchases p
            ON t.purchaseID = p.purchaseID
            INNER JOIN shows s
            ON s.movieID = :movieID and p.showID = s.showID;";

            $parameters['movieID'] = $movieID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountMovieTotalCapacity($movieID){
            $sql = "SELECT sum(r.capacity) FROM rooms r
            INNER JOIN shows s
            ON s.roomID = r.roomID AND s.movieID = :movieID;";

            $parameters['movieID'] = $movieID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountMoviePossibleTotalMoney($movieID){
            $sql = "SELECT sum(r.ticketValue * r.capacity) FROM rooms r
            INNER JOIN shows s
            ON s.roomID = r.roomID AND s.movieID = :movieID;";

            $parameters['movieID'] = $movieID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function CountMovieGatheredMoney($movieID){
            $sql = "SELECT ifnull(sum(p.purchaseTotal), 0) as totalSales from purchases p
            INNER JOIN shows s
            ON p.showID = s.showID AND s.movieID = :movieID;";

            $parameters['movieID'] = $movieID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->execute($sql, $parameters)[0][0];
            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function ReadByGenreAndActiveShows($genreID) {
        
            $sql = "SELECT * FROM movies m
            inner join genresxmovies gxm
            on gxm.movieID = m.movieID and gxm.genreID = :genreID
            join shows s
            on s.movieID = m.movieID and (s.showDate > CURDATE()) OR (s.showDate = CURDATE() AND s.startTime >= CURTIME())
            group by m.movieID";

            $parameters['genreID'] = $genreID;

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            if (!empty($result)) {
                return $result;
            }else
            {
                return false;
            }
        }

        public function ReadByActiveShows() {
        
            $sql = "SELECT m.movieID, m.title, m.overview, m.dateRelease, m.length, m.posterPath, m.trailerPath, m.language, m.voteAverage, m.isActive FROM movies m
            join shows s
            on s.movieID = m.movieID and (s.showDate > CURDATE()) OR (s.showDate = CURDATE() AND s.startTime >= CURTIME())
            group by m.movieID";

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

        public function Delete($id){

        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $movie = new Movie();
                $movie->setID($p['movieID']);
                $movie->setTitle($p['title']);
                $movie->setOverview($p['overview']);
                $movie->setImage($p['posterPath']);
                $movie->setReleaseDate($p['dateRelease']);
                $movie->setTrailer($p['trailerPath']);
                $movie->setLength($p['length']);
                $movie->setLanguage($p['language']);
                $movie->setVoteAverage($p['voteAverage']);
                $movie->setIsActive($p['isActive']);
                return $movie;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }

    }

?>
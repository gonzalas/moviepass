<?php
    namespace DAO;
    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use Models\Movie as Movie;

    class UserDAO implements IMovieDAO{
        private $connection;
        
        public function Create($movie){

            $sql = "INSERT INTO movies (id, title, overview, dateRelease, length, image, trailer, language, genres, voteAverage, isActive) VALUES (:id, :title, :overview, :dateRelease, :length, :image, :trailer, :language, :genres, :voteAverage, :isActive)";
            
            $parameters['id'] = $user->getID();
            $parameters['title'] = $user->getTitle();
            $parameters['overview'] = $user->getOverview();
            $parameters['dateRelease'] = $user->getDateRelease();
            $parameters['length'] = $user->getLength();
            $parameters['image'] = $user->getImage();
            $parameters['trailer'] = $user->getTrailer();
            $parameters['language'] = $user->getLanguage();
            $parameters['genres'] = $user->getGenres();
            $parameters['voteAverage'] = $user->getVoteAverage();
            $parameters['isActive'] = $user->getisActive();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }
        }

        public function ReadById($id){
 
            $sql = "SELECT * FROM movies WHERE id = :id";

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

        public function ReadAll(){

            $sql = "SELECT * FROM movies";

            try {

                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);

            } catch(Exception $err){
                throw $err;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;

        }

        public function GetByID($id){

        }

        public function Update($user){

            $sql = "UPDATE movies SET id = :id, title = :title, overview = :overview, dateRelease = :dateRelease, length = :length, image = :image, trailer = :trailer, language = :language, genres = :genres, voteAverage = :voteAverage, isActive = :isActive";
            
            $parameters['id'] = $user->getID();
            $parameters['title'] = $user->getTitle();
            $parameters['overview'] = $user->getOverview();
            $parameters['dateRelease'] = $user->getDateRelease();
            $parameters['length'] = $user->getLength();
            $parameters['image'] = $user->getImage();
            $parameters['trailer'] = $user->getTrailer();
            $parameters['language'] = $user->getLanguage();
            $parameters['genres'] = $user->getGenres();
            $parameters['voteAverage'] = $user->getVoteAverage();
            $parameters['isActive'] = $user->getisActive();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }

        }

        public function Delete($id){

        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $movie = new Movie();
                $movie->setID($p['id']);
                $movie->setTitle($p['title']);
                $movie->setOverview($p['overview']);
                $movie->setImage($p['image']);
                $movie->setDateRelease($p['dateRelease']);
                $movie->setTrailer($p['trailer']);
                $movie->setLength($p['length']);
                $movie->setLanguage($p['language']);
                $movie->setGenres($p['genres']);
                $movie->setVoteAverage($p['voteAverage']);
                $movie->setIsActive($p['isActive']);
                return $movie;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }

    }

?>
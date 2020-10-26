<?php
    namespace DAO;
    use DAO\IGenreDAO as IGenreDAO;
    use DAO\Connection as Connection;
    use Models\Genre as Genre;

    class GenreDAO implements IGenreDAO{
        private $connection;
        
        public function Create($genre){

            $sql = "INSERT INTO genres (genreID, name) VALUES (:genreID, :name)";
            
            $parameters['genreID'] = $genre->getID();
            $parameters['name'] = $genre->getName();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }
        }

        public function ReadById($id){
 
            $sql = "SELECT * FROM genres WHERE genreID = :genreID";

            $parameters['genreID'] = $id;

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

            $sql = "SELECT * FROM genres";

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

        public function Delete($id){
            
        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $genre = new Genre();
                $genre->setID($p['genreID']);
                $genre->setName($p['name']);
                return $genre;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }

    }

?>
<?php

    namespace DAO;

    class GenreMovieDAO implements IGenreMovieDAO{
        
        private $connection;

        public function Create($movieID, $genreID) {
            
            $sql = "INSERT INTO genresxmovies(movieID, genreID) VALUES (:movieID, :genreID)";

            $parameters['movieID'] = $movieID;
            $parameters['genreID'] = $genreID;

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql,$parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }
            
        }

        public function ReadByMovieID($movieID) {
        
            $sql = "SELECT gxm.genreID, g.name from genresxmovies gxm
                    join genres g
                    on gxm.genreID = g.genreID and gxm.movieID = :movieID;";

            $parameters['movieID'] = $movieID;

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

        public function ReadByGenreID($genreID) {
        
            $sql = "SELECT * FROM genresxmovies WHERE genreID = :genreID";

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

        public function ReadAll() {
            $sql = "SELECT * FROM genresxmovies";

            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);
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

        public function Delete($id){

        }
    }

?>
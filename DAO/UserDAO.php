<?php
    namespace DAO;
    use DAO\IUserDAO as IUserDAO;
    use DAO\Connection as Connection;
    use Models\User as User;

    class UserDAO implements IUserDAO{
        private $connection;
        
        public function Create($user){
            $sql = "INSERT INTO users (firstName, lastName, email, userName, password) VALUES (:firstName, :lastName, :email, :userName, :password)";
            
            $parameters['firstName'] = $user->getFirstName();
            $parameters['lastName'] = $user->getaLastName();
            $parameters['email'] = $user->getEmail();
            $parameters['userName'] = $user->getUserName();
            $parameters['password'] = $user->getPassword();

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(\PDOException $err){
                throw $err;
            }
        }

        public function Read($userEmail){
 
            $sql = "SELECT * FROM users where email = :email";

            $parameters['email'] = $userEmail;

            try {

                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);

            } catch(Exception $err){
                throw $err;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;

        }

        public function ReadAll(){

            $sql = "SELECT * FROM users";

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

            $sql = "UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, userName = :userName, password = :password";

            $parameters['firstName'] = $user->getFirstName();
            $parameters['lastName'] = $user->getaLastName();
            $parameters['email'] = $user->getEmail();
            $parameters['userName'] = $user->getUserName();
            $parameters['password'] = $user->getPassword();

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
                $user = new User();
                $user->setFirstName($p['firstName']);
                $user->setLastName($p['lastName']);
                $user->setEmail($p['email']);
                $user->setUserName($p['userName']);
                $user->setPassword($p['password']);
                return $user;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }

    }

?>
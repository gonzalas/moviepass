<?php
    namespace Models;


    class User
    {
        private $name;
        private $lastName;
        private $userName;
        private $password;
        private $email;
        
        public  function getName()
        {
            return $this->name;
        }

        public function getLastName()
        {
            return $this->lastName;
        }

        public function getUserName()
        {
            return $this->userName;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function setlastName($lastName)
        {
            $this->lastName = $lastName;
        }

        
        public function setUserName($userName)
        {
            $this->userName = $userName;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }
    }





?>
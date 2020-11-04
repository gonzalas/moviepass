<?php
    namespace Models;


    class User
    {
        private $id;
        private $firstName;
        private $lastName;
        private $userName;
        private $password;
        private $email;
        private $isAdmin;
        private $purchases = array();

        public function setID($id){$this->id = $id;}
        public function getID(){return $this->id;}
        
        public  function getFirstName()
        {
            return $this->firstName;
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

        public function getIsAdmin()
        {
            return $this->isAdmin;
        }

        public function getPurchases()
        {
            return $this->purchases;
        }

        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;
        }

        public function setLastName($lastName)
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

        public function setIsAdmin($isAdmin)
        {
            $this->isAdmin = $isAdmin;
        }

        public function setPurchases($purchases)
        {
            $this->purchases = $purchases;
        }
    }
?>

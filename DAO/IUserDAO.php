<?php
    namespace DAO;
    use Models\User as User;

    interface IUserDAO {
        function Create(User $user);
        function Read($userName, $userPassword);
        function ReadAll();
        function GetByID($id);
        function Update(User $user);
        function Delete($id);
    }

?>
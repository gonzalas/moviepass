<?php
    namespace DAO;
    use Models\User as User;

    interface IUserDAO {
        function Create(User $user);
        function Read($userName, $userPassword);
        function ReadByUserName($userName);
        function ReadByUserEmail($email);
        function ReadAll();
        function UpdateUserNamePassword(User $user, $userName, $password);
        function Update(User $user);
    }

?>
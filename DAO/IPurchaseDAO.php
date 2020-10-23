<?php

    namespace DAO;
    use Models\Purchase as Purchase;

    interface IPurchaseDAO {
        function Create(Purchase $purchase, $userID);
        function ReadByID($purchaseID);
        function Update($purchase);
        function Delete($purchaseID);
    }

?>
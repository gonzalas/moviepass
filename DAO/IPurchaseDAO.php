<?php

    namespace DAO;
    use Models\Purchase as Purchase;

    interface IPurchaseDAO {
        function Create(Purchase $purchase);
        function ReadByID($purchaseID);
        function Update($purchase);
        function Delete($purchaseID);
    }

?>
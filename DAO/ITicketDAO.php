<?php

    namespace DAO;
    use Models\Ticket as Ticket;

    interface ITicketDAO {
        function Create(Ticket $ticket, $showID, $purchaseID);
        function ReadByID($id);
        function ReadAllByShowID($showID);
        function Update($ticket);
        function Delete($id);
    }

?>
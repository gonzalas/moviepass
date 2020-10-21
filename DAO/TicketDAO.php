<?php
    namespace DAO;
    use DAO\ITicketDAO as ITicketDAO;
    use DAO\Connection as Connection;
    use Models\Ticket as Ticket;

    class TicketDAO implements ITicketDAO{  
    
        private $connection;

        public function Create($ticket){

            $sql = "INSERT INTO tickets (ticketID, showID, purchaseID, seatLocation, qrCodeURL) VALUES (:ticketID, :showID, :purchaseID, :seatLocation, :qrCodeURL)";

            $parameters['ticketID'] = $ticket->getTicketID(); 
            $parameters['showID'] = $ticket->getShowID(); 
            $parameters['purchaseID'] = $ticket->getPurchaseID(); 
            $parameters['seatLocation'] = $ticket->getSeatLocation(); 
            $parameters['qrCodeURL'] = $ticket->getQRCode(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(PDOException $ex){
                throw $ex;
            }
        } 
        
        public function ReadById($id){
            
            $sql = "SELECT * FROM tickets WHERE ticketID = :ticketID";

            $parameters['ticketID'] = $id;
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)) {
                return $this->mapear($result);
            } else
                return false;    
        }

        public function ReadAllByShowID($showID){
            $sql = "SELECT * FROM tickets WHERE showID = :showID";

            $this->connection = Connection::getInstance();
            $result = $this->connection->execute($sql);

            try {

                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql);

            } catch(PDOException $ex){
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapear($result);
            } else
                return false;
        }

        public function Update($ticket){

            $sql = "UPDATE tickets SET ticketID = :ticketID, showID = :showID, purchaseID = :purchaseID, seatLocation = :seatLocation, qrCodeURL = :qrCodeURL";

            $parameters['ticketID'] = $show->getTciketID();
            $parameters['showID'] = $show->getShowID(); 
            $parameters['purchaseID'] = $show->getPurchaseID(); 
            $parameters['seatLocation'] = $show->getSeatLocation(); 
            $parameters['qrCodeURL'] = $show->getQRCode(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function Delete($ticketID){
            $sql = "DELETE FROM tickets WHERE ticketID = :ticketID";

            $parameters['ticketID'] = $ticketID;

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            }catch(PDOException $ex){
                throw $ex;
            }
        }

        protected function mapear($value){

            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $ticket = new Ticket();
                $ticket->setTicketID($p['ticketID']);
                $ticket->setRoomShowID($p['showID']);
                $ticket->setPurchaseID($p['purchaseID']);
                $ticket->setSeatLocation($p['seatLocation']);
                $ticket->setQRCode($p['qrCodeURL']);
                return $ticket;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
}   
?>
<?php
    namespace DAO;
    use DAO\IPurchaseDAO as IPurchaseDAO;
    use DAO\Connection as Connection;
    use Models\Purchase as Purchase;

    class PurchaseDAO implements IPurchaseDAO{  
    
        private $connection;

        public function Create(Purchase $purchase, $userID){

            $sql = "INSERT INTO purchases (userID, purchaseDate, subTotal, hasDiscount, purchaseTotal) VALUES (:userID, :purchaseDate, :subTotal, :hasDiscount, :purchaseTotal)";

            $parameters['userID'] = $userID; 
            $parameters['purchaseDate'] = $purchase->getPurchaseDate(); 
            $parameters['subTotal'] = $purchase->getSubTotal(); 
            $parameters['hasDiscount'] = $purchase->getHasDiscount(); 
            $parameters['purchaseTotal'] = $purchase->getPurchaseTotal(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            } catch(PDOException $ex){
                throw $ex;
            }
        } 
        
        public function ReadById($purchaseID){
            
            $sql = "SELECT * FROM purchases WHERE purchaseID = :purchaseID";

            $parameters['purchaseID'] = $purchaseID;
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

        public function Update($purchase){

            $sql = "UPDATE purchases SET subTotal = :subTotal, hasDiscount = :hasDiscount, purchaseTotal = :purchaseTotal WHERE purchaseID = :purchaseID";

            $parameters['subTotal'] = $purchase->getSubTotal(); 
            $parameters['hasDiscount'] = $purchase->getHasDiscount(); 
            $parameters['purchaseTotal'] = $purchase->getPurchaseTotal(); 

            try {

                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);

            }catch(PDOException $ex){
                throw $ex;
            }
        }

        public function ReadUserID($purchaseID){
            $sql = "SELECT userID FROM purchases WHERE purchaseID = :purchaseID";

            $parameters['shpurchaseID'] = $purchaseID;
            
            try {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sql, $parameters);
            } catch ( PDOException $ex) {
                throw $ex;
            }

            return $result[0][0];
        }

        public function Delete($purchaseID){
            $sql = "DELETE FROM purchases WHERE purchaseID = :purchaseID";

            $parameters['purchaseID'] = $purchaseID;

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
                $purchase = new Purchase();
                $purchase->setPurchaseID($p['purchaseID']);
                $purchase->setPurchaseDate($p['purchaseDate']);
                $purchase->setSubTotal($p['subTotal']);
                $purchase->setHasDiscount($p['hasDiscount']);
                $purchase->setPurchaseTotal($p['purchaseTotal']);
                return $purchase;
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
}   
?>
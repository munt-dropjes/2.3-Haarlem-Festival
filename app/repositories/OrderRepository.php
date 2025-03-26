<?php

namespace Repositories;

use Exception;
use PDO;
use Models\Order;

class OrderRepository extends BaseRepository {
    // ~~Read~~
    public function getAllOrders($limit, $offset, $search) : array {
        try {
            $sql = "SELECT * 
                    FROM Orders 
                    WHERE ( 
                        UPPER(OrderID) LIKE UPPER(CONCAT('%', :search, '%'))
                        OR UPPER(UserID) LIKE UPPER(CONCAT('%', :search, '%')) 
                        OR UPPER(Status) LIKE UPPER(CONCAT('%', :search, '%'))
                        OR UPPER(PaymentMethod) LIKE UPPER(CONCAT('%', :search, '%'))
                    )
                    ORDER BY CreatedAt
                    LIMIT :limit
                    OFFSET :offset;";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':search', $search, PDO::PARAM_STR);

            $stmt->execute();
            $obj = $stmt->fetchAll(PDO::FETCH_CLASS, 'Models\Order');
            return $obj;
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all orders");
        }
    }

    public function countTotalOrders() : int {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM Orders");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to count total orders");
        }
    }
}
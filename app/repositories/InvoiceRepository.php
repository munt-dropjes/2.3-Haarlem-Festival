<?php

namespace Repositories;

class InvoiceRepository extends BaseRepository
{
    public function GetInvoiceByOrderID($OrderID) {
        $query = "SELECT * FROM invoices WHERE OrderID = :order_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':order_id', $OrderID, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertInvoice($invoice) {
        $query = "INSERT INTO invoices (
            InvoiceID, 
            OrderID, 
            UserID, 
            TotalAmount, 
            VAT, 
            InvoiceDate, 
            Subtotal, 
            Vat21, 
            Vat9, 
            PaymentDate
        ) VALUES (
            :invoice_id, 
            :order_id, 
            :user_id, 
            :total_amount, 
            :vat, 
            :invoice_date, 
            :subtotal, 
            :vat21, 
            :vat9, 
            :payment_date
        )";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':invoice_id', $invoice->getInvoiceNumber(), \PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $invoice->getOrderID(), \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $invoice->getUserID(), \PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $invoice->getTotalAmount(), \PDO::PARAM_STR);
        $stmt->bindParam(':vat', $invoice->getVat21() + $invoice->getVat9(), \PDO::PARAM_STR);
        $stmt->bindParam(':invoice_date', $invoice->getInvoiceDate(), \PDO::PARAM_STR);
        $stmt->bindParam(':subtotal', $invoice->getSubtotal(), \PDO::PARAM_STR);
        $stmt->bindParam(':vat21', $invoice->getVat21(), \PDO::PARAM_STR);
        $stmt->bindParam(':vat9', $invoice->getVat9(), \PDO::PARAM_STR);
        $stmt->bindParam(':payment_date', $invoice->getPaymentDate(), \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updatePaymentDate($orderID, $paymentDate) {
        $query = "UPDATE invoices SET PaymentDate = :payment_date WHERE OrderID = :order_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':payment_date', $paymentDate, \PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $orderID, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
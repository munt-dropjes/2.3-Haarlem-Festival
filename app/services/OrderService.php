<?php

namespace Services;

use Exception;
use Models\Order;
use Repositories\OrderRepository;

class OrderService {
    private $orderRepository;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
    }

    // ~~Read~~
    public function getAllOrders($limit, $offset, $search) : array {
        return $this->orderRepository->getAllOrders($limit, $offset, $search);
    }

    public function countTotalOrders() : int {
        return $this->orderRepository->countTotalOrders();
    }

    public function updateOrderStatus($orderId, $status) : void {
        $this->orderRepository->updateOrderStatus($orderId, $status);
    }
}
<?php

namespace Controllers;

use Services\OrderService;
use Models\Order;

class CmsOrderController extends Controller {
    private $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    // all cms routes will be automically checked for authentication
    public function index() {
        $limit = $_GET['limit'] ?? 10;
        $offset = $_GET['offset'] ?? 0;
        $search = $_GET['search'] ?? '';

        // check if the limit and offset are valid
        if ((!is_numeric($offset) || !is_numeric($limit)) || ($offset < 0 || $limit < 1)) {
            $currentUri = $_SERVER['REQUEST_URI'];
            $search = explode('search=', $currentUri)[1] ?? "";
            header('Location: /cms/orders?limit=10&offset=0&search=' . $search);
        }

        $this->view('cms/orders/index', [
            'orders' => $this->orderService->getAllOrders($limit, $offset, $search),
            'totalEntries' => $this->orderService->countTotalOrders(),
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search
        ]);
    }
}
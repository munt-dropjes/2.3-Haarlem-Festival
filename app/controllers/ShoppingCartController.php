<?php

namespace Controllers;

use Exception;
use Services\ShoppingCartService;

class ShoppingCartController extends Controller
{
	private ShoppingCartService $shoppingCart;
	private $user;

	public function __construct()
	{
		// Start session if not already started
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		// Check if user is logged in
		if (!isset($_SESSION['user'])) {
			header("Location: /login"); // Redirect to login page
			exit();
		}

		$this->user = $_SESSION['user'];

		$this->shoppingCart = new ShoppingCartService();
	}

	public function index()
	{
		$data = [
			'ShoppingCartItems' => $this->shoppingCart->getUserShoppingCartItems($this->user->getID()),
		];

		$this->view('shopping-cart/index', $data);
	}

	public function updateQuantity(int $itemID, int $quantity)
	{
		try {
			if ($quantity < 1) {
				throw new Exception("Quantity cannot be less than 1");
			}

			$newQuantity = $this->shoppingCart->updateQuantity($this->user->getID(), $itemID, $quantity);

			echo json_encode(['success' => true, 'newQuantity' => $newQuantity]);
			exit();
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}

	public function removeItem(int $itemID)
	{
		try {
			$this->shoppingCart->removeItem($this->user->getID(), $itemID);

			echo json_encode(['success' => true]);
			exit();
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}

	public function selectItem(int $itemID, mixed $selected)
	{
		try {
			// Normalize the boolean value
			$selected = filter_var($selected, FILTER_VALIDATE_BOOL);

			$this->shoppingCart->selectItem($this->user->getID(), $itemID, $selected);

			echo json_encode(['success' => true]);
			exit();
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}

	public function selectAll(mixed $selected = true)
	{
		try {
			// Normalize the boolean value
			$selected = filter_var($selected, FILTER_VALIDATE_BOOL);

			$this->shoppingCart->selectAll($this->user->getID(), $selected);

			echo json_encode(['success' => true]);
			exit();
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}
}
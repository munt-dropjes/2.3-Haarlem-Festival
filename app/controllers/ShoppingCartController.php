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
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
		} else {
			$this->user = null;
		}

		$this->shoppingCart = new ShoppingCartService();

		// example session data for testing
		// $_SESSION['shoppingCart'] = [
		// 	[
		// 		'eventID' => 10,
		// 		'quantity' => 2,
		// 		'selected' => true
		// 	],
		// 	[
		// 		'eventID' => 11,
		// 		'quantity' => 1,
		// 		'selected' => false
		// 	],
		// 	[
		// 		'eventID' => 3,
		// 		'quantity' => 4,
		// 		'selected' => true
		// 	]
		// ];
	}

	public function index()
	{
		$data = [];

		if (!isset($this->user)) {
			// Use session shopping cart for guests
			$_SESSION['shoppingCart'] = $_SESSION['shoppingCart'] ?? [];
			$data['ShoppingCartItems'] = $this->shoppingCart->getMultipleEventsById($_SESSION['shoppingCart']);
		} else {
			// Use database shopping cart for logged-in users
			$this->user = $_SESSION['user'];
			$data['ShoppingCartItems'] = $this->shoppingCart->getUserShoppingCartItems($this->user->getID());
		}

		$this->view('shopping-cart/index', $data);
	}

	// public function checkout()
	// {
	// 	$data = [];

	// 	if (!isset($this->user)) {
	// 		header('Location: /login');
	// 	}

	// 	$this->user = $_SESSION['user'];
	// 	$data['ShoppingCartItems'] = $this->shoppingCart->getUserShoppingCartItems($this->user->getID());

	// 	$this->view('shopping-cart/checkout', $data);
	// }

	public function addItem(int $eventID, int $quantity = 1, $isFamilyTicket = false)
	{
		try {
			if (isset($isFamilyTicket)) {
				$isFamilyTicket = filter_var($isFamilyTicket, FILTER_VALIDATE_BOOL);
			}

			if ($quantity < 0) {
				throw new Exception("Quantity cannot be less than 1");
			}

			if ($eventID < 0) {
				throw new Exception("Invalid event ID");
			}

			if (!isset($this->user)) {
				// If the user is not logged in, add the item to the session shopping cart
				if (!isset($_SESSION['shoppingCart'])) {
					$_SESSION['shoppingCart'] = [];
				}

				$found = false;
				foreach ($_SESSION['shoppingCart'] as &$item) {
					if ($item['eventID'] === $eventID) {
						$item['quantity'] += $quantity;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$_SESSION['shoppingCart'][] = [
						'eventID' => $eventID,
						'quantity' => $quantity,
						'selected' => false,
						'isFamilyTicket' => $isFamilyTicket
					];
				}

				echo json_encode(['success' => true]);
				exit();
			} else {
				// If the user is logged in, add the item to the database shopping cart
				$this->shoppingCart->addItem($this->user->getID(), $eventID, $quantity, $isFamilyTicket);

				echo json_encode(['success' => true]);
				exit();
			}
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}

	public function updateQuantity(int $itemID, int $quantity)
	{
		try {
			if ($quantity < 1) {
				throw new Exception("Quantity cannot be less than 1");
			}

			if (!isset($this->user)) {
				// If the user is not logged in, update the session shopping cart
				if (!isset($_SESSION['shoppingCart'])) {
					throw new Exception("Shopping cart is empty");
				}

				$found = false;
				foreach ($_SESSION['shoppingCart'] as &$item) {
					if ($item['eventID'] === $itemID) {
						$item['quantity'] = $quantity;
						$found = true;
						break;
					}
				}

				if (!$found) {
					throw new Exception("Item not found in the shopping cart");
				}

				echo json_encode(['success' => true, 'newQuantity' => $quantity]);
				exit();
			} else {
				// If the user is logged in, update the database shopping cart
				$newQuantity = $this->shoppingCart->updateQuantity($this->user->getID(), $itemID, $quantity);

				echo json_encode(['success' => true, 'newQuantity' => $newQuantity]);
				exit();
			}
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}

	public function removeItem(int $itemID)
	{
		try {
			if (!isset($this->user)) {
				// If the user is not logged in, remove the item from the session shopping cart
				if (!isset($_SESSION['shoppingCart'])) {
					throw new Exception("Shopping cart is empty");
				}

				$found = false;
				foreach ($_SESSION['shoppingCart'] as $key => $item) {
					if ($item['eventID'] === $itemID) {
						unset($_SESSION['shoppingCart'][$key]);
						$found = true;
						break;
					}
				}

				if (!$found) {
					throw new Exception("Item not found in the shopping cart");
				}

				echo json_encode(['success' => true]);
				exit();
			} else {
				// If the user is logged in, remove the item from the database shopping cart
				$this->shoppingCart->removeItem($this->user->getID(), $itemID);

				echo json_encode(['success' => true]);
				exit();
			}
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

			if (!isset($this->user)) {
				// If the user is not logged in, update the session shopping cart
				if (!isset($_SESSION['shoppingCart'])) {
					throw new Exception("Shopping cart is empty");
				}

				$found = false;
				foreach ($_SESSION['shoppingCart'] as &$item) {
					if ($item['eventID'] === $itemID) {
						$item['selected'] = $selected;
						$found = true;
						break;
					}
				}

				if (!$found) {
					throw new Exception("Item not found in the shopping cart");
				}

				echo json_encode(['success' => true, 'selected' => $selected]);
				exit();
			} else {
				// If the user is logged in, update the database shopping cart
				$this->shoppingCart->selectItem($this->user->getID(), $itemID, $selected);

				echo json_encode(['success' => true, 'selected' => $selected]);
				exit();
			}
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

			if (!isset($this->user)) {
				// If the user is not logged in, update the session shopping cart
				if (!isset($_SESSION['shoppingCart'])) {
					throw new Exception("Shopping cart is empty");
				}

				foreach ($_SESSION['shoppingCart'] as &$item) {
					$item['selected'] = $selected;
				}

				echo json_encode(['success' => true]);
				exit();
			} else {
				// If the user is logged in, update the database shopping cart
				$this->shoppingCart->selectAll($this->user->getID(), $selected);

				echo json_encode(['success' => true]);
				exit();
			}
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
			exit();
		}
	}
}
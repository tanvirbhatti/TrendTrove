<?php
session_start();


// Importing all the classes
require_once('Product.php');
require_once('Cart.php');
require_once('User.php');

header('Content-Type: application/json');

$productObj = new Product();
$cartObj = new Cart();
$userObj = new User();

try {

    // Handling all the POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // post request for adding products to cart
        if (isset($_POST['add_to_cart'])) {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['error' => 'User not logged in']);
                exit();
            }

            $productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

            if ($quantity > 10) {
                echo json_encode(['error' => 'Quantity cannot exceed 10']);
                exit();
            }

            $userId = $_SESSION['user_id'];
            $cartObj->addToCart($userId, $productId, $quantity);

            header("Location: cart_page.php");
            exit();
        } 
        
        // Api request for updating products in cart
        elseif (isset($_POST['update_cart'])) {
            parse_str(file_get_contents("php://input"), $_PUT);

            $productId = isset($_PUT['product_id']) ? $_PUT['product_id'] : null;
            $quantity = isset($_PUT['quantity']) ? $_PUT['quantity'] : 1;

            if ($quantity > 10) {
                echo json_encode(['error' => 'Quantity cannot exceed 10']);
                exit();
            }

            $userId = $_SESSION['user_id'];
            $cartObj->updateCartItem($userId, $productId, $quantity);

            header("Location: cart_page.php");
            exit();
        } 
        
        // api request for deleting product from carts
        elseif (isset($_POST['delete_cart'])) {
            parse_str(file_get_contents("php://input"), $_DELETE);

            $productId = isset($_DELETE['product_id']) ? $_DELETE['product_id'] : null;

            $userId = $_SESSION['user_id'];
            $cartObj->removeFromCart($userId, $productId);

            header("Location: cart_page.php");
            exit();
        } 
        
        // api request for deleting all products from cart
        elseif (isset($_POST['clear_cart'])) {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['error' => 'User not logged in']);
                exit();
            }

            $userId = $_SESSION['user_id'];
            $cartObj->clearCart($userId);
            header("Location: cart_page.php");
            exit();
        } 
        
        // api request for adding user into database
        elseif (isset($_POST['register'])) {
            $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
            $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';

            if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($address)) {
                echo json_encode(['error' => 'All fields are required']);
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['error' => 'Invalid email format']);
                exit();
            }

            if ($userObj->isEmailRegistered($email)) {
                echo json_encode(['error' => 'Email is already registered']);
                exit();
            }

            $userObj->registerUser($firstName, $lastName, $email, $password, $address);
            echo json_encode(['success' => true, 'message' => 'User registered successfully']);

            // Redirect to the login page after registration
            header('Location: login.php?registration=success');
            exit();
        }
    }

    // getting products from database
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $genderFilter = isset($_GET['gender']) ? $_GET['gender'] : null;
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;

        $products = $productObj->getFilteredProducts($genderFilter, $categoryFilter);

        if ($products === false) {
            echo json_encode(['error' => 'Failed to fetch products']);
        } else {
            echo json_encode($products);
        }
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

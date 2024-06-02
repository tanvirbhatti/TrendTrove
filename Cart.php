<?php
require_once('db.php');

class Cart extends Database {
    // Add a product to the cart
    public function addToCart($userId, $productId, $quantity) {
        // Check if the product is already in the cart for the user
        $existingCartItem = $this->getCartItem($userId, $productId);

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $newQuantity = $existingCartItem['Quantity'] + $quantity;
            $this->updateCartItemQuantity($userId, $productId, $newQuantity);
        } else {
            $query = "INSERT INTO Cart (UserID, ProductID, Quantity) VALUES ($userId, $productId, $quantity)";
            $this->conn->query($query);
        }
    }

    // Get all items in the cart for a user
    public function getCartItems($userId) {
        $query = "SELECT p.ProductID, p.Name AS ProductName, p.Price, c.Quantity, (p.Price * c.Quantity) AS Total
                  FROM Cart c
                  INNER JOIN Products p ON c.ProductID = p.ProductID
                  WHERE c.UserID = $userId";
    
        $result = $this->conn->query($query);
    
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        return $cartItems;
    }
    

    // Get a specific cart item for a user and product
    private function getCartItem($userId, $productId) {
        $query = "SELECT * FROM Cart WHERE UserID = $userId AND ProductID = $productId";
        $result = $this->conn->query($query);

        return $result->fetch_assoc();
    }

    // Update the quantity of a product in the cart
    private function updateCartItemQuantity($userId, $productId, $quantity) {
        $query = "UPDATE Cart SET Quantity = $quantity WHERE UserID = $userId AND ProductID = $productId";
        $this->conn->query($query);
    }

    public function updateCartItem($userId, $productId, $quantity) {
        // Check if the product is in the cart
        $existingCartItem = $this->getCartItem($userId, $productId);
    
        if ($existingCartItem) {
            $this->updateCartItemQuantity($userId, $productId, $quantity);
        } else {
            throw new Exception('Product not found in the cart');
        }
    }
    // Remove a product from the cart
    public function removeFromCart($userId, $productId) {
        $query = "DELETE FROM Cart WHERE UserID = $userId AND ProductID = $productId";
        $this->conn->query($query);
    }

    // Clear the entire cart for a user
    public function clearCart($userId) {
        $query = "DELETE FROM Cart WHERE UserID = $userId";
        $this->conn->query($query);
    }
    
}

?>
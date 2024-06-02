<?php
require_once('db.php');

class Product extends Database {
    public function getProducts() {
        $query = "SELECT * FROM Products";
        $result = $this->conn->query($query);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function getFilteredProducts($gender, $category) {
        // Start with a true condition
        $query = "SELECT * FROM Products WHERE 1=1";
    
        // Add conditions based on selected filters
        if ($gender && $gender !== 'All Genders') {
            $query .= " AND Gender = ?";
        }
    
        if ($category) {
            $query .= " AND CategoryID = ?";
        }
    
        // Use prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare($query);
        
    
        // Bind parameters
        if ($gender && $gender !== 'All Genders') {
            $stmt->bind_param("s", $gender);
        }
    
        if ($category) {
            $stmt->bind_param("i", $category);
        }
    
        // Execute the statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    
        // Close the statement
        $stmt->close();
    
        return $products;
    }
    
    

    public function getProductDetails($productId) {
        $query = "SELECT * FROM Products WHERE ProductID = $productId";
        $result = $this->conn->query($query);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }

        return null;
    }
}

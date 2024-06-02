<!-- product_details.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-details {
            padding: 20px;
        }

        .product-details h2 {
            color: #333;
        }

        .product-details p {
            color: #666;
            margin-bottom: 10px;
        }

        .quantity-section {
            margin-top: 20px;
        }

        /* Style for quantity input */
        #quantity-input {
            width: 60px;
            padding: 8px;
            margin-right: 10px;
        }

        /* Style for login line */
        .login-line {
            color: #888;
        }

        .login-line a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-line a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <?php
    require_once('Product.php');
    require_once('Cart.php');

    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];

        // Fetch product details based on the product ID
        $productObj = new Product();
        $productDetails = $productObj->getProductDetails($productId);

        // Display product details
        if ($productDetails) {
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<img class="img-fluid" src="' . $productDetails['ImagePath'] . '" alt="' . $productDetails['Name'] . '">';
            echo '</div>';
            echo '<div class="col-md-6 product-details">';
            echo '<h2>' . $productDetails['Name'] . '</h2>';
            echo '<p>Description: ' . $productDetails['Description'] . '</p>';
            echo '<p>Price: $' . $productDetails['Price'] . '</p>';
            echo '<p>Gender: ' . $productDetails['Gender'] . '</p>';

            // Add a form for entering quantity
            echo '<form method="post" action="api.php" class="quantity-section">';
            echo '<input type="hidden" name="product_id" value="' . $productId . '">';

            // Display the quantity input with an associated label
            echo '<label for="quantity-input">Quantity:</label>';
            echo '<input type="number" id="quantity-input" name="quantity" value="1" min="1" max="10" class="form-control">';
            
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                echo '<button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>';
            } else {
                // If not logged in, provide a link to the login page
                echo '<p class="login-line">Please <a href="login.php">log in</a> to add this product to your cart.</p>';
            }

            echo '</form>';

            echo '</div></div>';
        } else {
            echo '<p>Product not found.</p>';
        }
    } else {
        echo '<p>Invalid request.</p>';
    }
    ?>
</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

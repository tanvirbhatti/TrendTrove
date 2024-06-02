<!-- cart_page.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .product-img {
            max-width: 80px;
            max-height: 80px;
            margin-right: 10px;
        }

        .cart-item {
            margin-bottom: 20px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .cart-actions {
            margin-top: 20px;
        }

        .checkout-btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1>Shopping Cart</h1>

        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once('Cart.php');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo '<p>Please <a href="login.php">log in</a> to view your cart.</p>';
        } else {
            $userId = $_SESSION['user_id'];
            $cartObj = new Cart();
            $cartItems = $cartObj->getCartItems($userId);

            if ($cartItems) {
                $total = 0;
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $cartItem): ?>
                                <tr>
                                    <td>

                                        <?php echo $cartItem['ProductName']; ?>
                                    </td>
                                    <td>$
                                        <?php echo $cartItem['Price']; ?>
                                    </td>
                                    <td>
                                        <form method="post" action="api.php">
                                            <input type="hidden" name="product_id" value="<?php echo $cartItem['ProductID']; ?>">
                                            <input type="number" name="quantity" value="<?php echo $cartItem['Quantity']; ?>"
                                                min="1" max="10">
                                            <button type="submit" class="btn btn-primary btn-sm" name="update_cart">Update</button>
                                        </form>
                                    </td>
                                    <td>$
                                        <?php echo $cartItem['Price'] * $cartItem['Quantity']; ?>
                                    </td>
                                    <td>
                                        <form method="post" action="api.php">
                                            <input type="hidden" name="product_id" value="<?php echo $cartItem['ProductID']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_cart">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                $total += ($cartItem['Price'] * $cartItem['Quantity']);
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Display total, clear cart, and checkout buttons -->
                <p class="total">Total: $
                    <?php echo $total; ?>
                </p>
                <div class="cart-actions">
                    <form method="post" action="api.php" class="d-flex justify-content-around ">
                    <button type="submit" class="icon-link" name="clear_cart">Clear Cart
                        <svg fill="none" class="rubicons arrow-right-up" xmlns="http://www.w3.org/2000/svg" width="auto"
                            height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                            <path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>
                            <path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <a href="checkout.php" class="icon-link mx-5">Checkout
                    <svg fill="none" class="rubicons arrow-ri-ht-up" xmlns="http://www.w3.org/2000/svg" width="auto"
                            height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                            <path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>
                            <path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                    </form>
                    
                    
                </div>
                <?php
            } else {
                echo '<p>Your cart is empty.</p>';
            }
        }
        ?>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
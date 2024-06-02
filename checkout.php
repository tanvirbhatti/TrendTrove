<!-- checkout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .container1 {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container container1 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="">
                    <div class="">
                    <h2 class="text-center">Checkout</h2>
                    </div>
                    <div class="card-body">

                        <?php

                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);

                        // Include necessary files
                        require_once('Cart.php');
                        require_once('User.php');
                        require_once('genrate_invoice.php');
                        // Start the session
                        

                        // Check if the user is logged in
                        if (!isset($_SESSION['user_id'])) {
                            echo '<p class="text-center">Please <a href="login.php">log in</a> to proceed with the checkout.</p>';
                        } else {
                            // User is logged in, proceed with checkout
                        
                            // Create instances of Cart and User classes
                            $cartObj = new Cart();
                            $userObj = new User();

                            // Get the user ID from the session
                            $userId = $_SESSION['user_id'];
                            $cartItems = $cartObj->getCartItems($userId);

                            // Handle form submission
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Validate and sanitize user input (add your validations)
                                $streetAddress = isset($_POST['street_address']) ? htmlspecialchars($_POST['street_address']) : '';
                                $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
                                $state = isset($_POST['state']) ? htmlspecialchars($_POST['state']) : '';
                                $zipCode = isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : '';
                                $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
                                $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
                                $paymentMethod = isset($_POST['payment_method']) ? htmlspecialchars($_POST['payment_method']) : '';

                                // Validate address and payment method (add your validations)
                                if (empty($streetAddress) || empty($city) || empty($state) || empty($zipCode) || empty($phone) || empty($email) || empty($paymentMethod)) {
                                    echo '<div class="alert alert-danger" role="alert">All fields are required.</div>';
                                } else {
                                    // Proceed with order processing 
                                    $orderProcessedSuccessfully = true;

                                    if ($orderProcessedSuccessfully) {
                                        // Generate and save the invoice
                                        $pdfFileName = generateInvoice($userId, $cartItems, $userObj->getLoggedInUser());

                                        // Clear the cart
                                        $cartObj->clearCart($userId);

                                        $pdfFileName = 'invoice.pdf';  
                                        echo '<div class="alert alert-success" role="alert">Order placed successfully! Thank you for your purchase. <a href="/TrendTrove/' . $pdfFileName . '" target="_blank">Download Invoice</a></div>';
                                        echo '<script>
                                              </script>';
                                        
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Failed to process the order. Please try again.</div>';
                                    }
                                }
                            }
                            ?>

                            <!-- Checkout form -->
                            <form method="post" action="checkout.php">
                                <div class="form-group">
                                    <label for="street_address">Street Address:</label>
                                    <input type="text" class="form-control" id="street_address" name="street_address"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="city">City:</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label for="state">State:</label>
                                    <input type="text" class="form-control" id="state" name="state" required>
                                </div>
                                <div class="form-group">
                                    <label for="zip_code">Zip Code:</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="payment_method">Payment Method:</label>
                                    <input type="text" class="form-control" id="payment_method" name="payment_method"
                                        required>
                                </div>
                                <button type="submit" class="icon-link">Place your order
                <svg fill="none" class="rubicons arrow-right-up" xmlns="http://www.w3.org/2000/svg" width="auto"
                    height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                    <path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>
                    <path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Client-side validation using JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('form').addEventListener('submit', function (event) {
                // Validate address and payment method on the client side
                // You can add additional client-side validations here
                var streetAddress = document.getElementById('street_address').value;
                var city = document.getElementById('city').value;
                var state = document.getElementById('state').value;
                var zipCode = document.getElementById('zip_code').value;
                var phone = document.getElementById('phone').value;
                var email = document.getElementById('email').value;
                var paymentMethod = document.getElementById('payment_method').value;

                if (streetAddress.trim() === '' || city.trim() === '' || state.trim() === '' || zipCode.trim() === '' || phone.trim() === '' || email.trim() === '' || paymentMethod.trim() === '') {
                    event.preventDefault();
                    alert('All fields are required.');
                }
            });
        });
    </script>

</body>

</html>
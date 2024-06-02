<!-- account.php -->
<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the logout logic
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the home page or any other desired page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<!-- Include the navbar -->
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h1>Account</h1>

    <?php
    if (isset($_SESSION['user_id'])) {
        // Display user details
        echo '<p>Welcome, ' . $_SESSION['user_email'] . '!</p>';
        // Add more user details as needed
        echo '<a href="?logout=true" class="btn btn-danger">Logout</a>';
    } else {
        // User is not logged in
        echo '<p>You are not logged in. <a href="login.php">Login</a></p>';
    }
    ?>
</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

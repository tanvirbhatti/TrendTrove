<?php
require_once('User.php');
session_start();

$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate input data (add more validations as needed)
    if (empty($email) || empty($password)) {
        echo '<p class="text-danger">Email and password are required</p>';
    } else {
        // Check if the user credentials are valid
        $loggedIn = $userObj->loginUser($email, $password);

        if ($loggedIn) {
            // Set user data in session
            $loggedInUser = $userObj->getLoggedInUser();
            $_SESSION['user_id'] = $loggedInUser['UserID'];
            $_SESSION['user_email'] = $loggedInUser['Email'];

            // Set user data in cookies (example, adjust as needed)
            setcookie('user_id', $loggedInUser['UserID'], time() + (86400 * 30), "/"); // 30 days
            setcookie('user_email', $loggedInUser['Email'], time() + (86400 * 30), "/"); // 30 days

            // Redirect to the home page or any other desired page
            header('Location: index.php');
            exit();
        } else {
            echo '<p class="text-danger">Invalid email or password</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        .container1 {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container1 container ">
    <h2 class="text-center">Login</h2>

    <?php
    // Display registration success message if redirected from the signup page
    if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
        echo '<p class="text-success">Registration successful! Please log in.</p>';
    }
    ?>

    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="icon-link">Login
                <svg fill="none" class="rubicons arrow-right-up" xmlns="http://www.w3.org/2000/svg" width="auto"
                    height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                    <path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>
                    <path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
    </form>
    <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign up</a></p>

</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

</body>
</html>

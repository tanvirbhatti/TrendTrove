<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
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

    <div class="container container1">
        <h2 class="text-center">Sign Up</h2>

        <?php
        // Display registration success message if redirected from the API
        if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
            echo '<p class="text-success">Registration successful! Please log in.</p>';
        }
        ?>

        <form action="api.php" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" name="firstName" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" name="lastName" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" required>
            </div>

            <input type="hidden" name="register" value="1"> <!-- Add this hidden input field for registration -->

            <button type="submit" class="icon-link">Sign Up
                <svg fill="none" class="rubicons arrow-right-up" xmlns="http://www.w3.org/2000/svg" width="auto"
                    height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                    <path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>
                    <path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </form>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

</body>

</html>
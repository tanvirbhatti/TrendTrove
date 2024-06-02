<?php
require_once('db.php');
class User extends Database {
    public function registerUser($firstName, $lastName, $email, $password, $address) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Password, Address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $address);
        $stmt->execute();
        $stmt->close();
    }

    public function isEmailRegistered($email) {
        $stmt = $this->conn->prepare("SELECT UserID FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $numRows = $stmt->num_rows;
        $stmt->close();

        return $numRows > 0;
    }

    public function loginUser($email, $password) {
    $stmt = $this->conn->prepare("SELECT UserID, Password FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userID, $hashedPassword);

    if ($stmt->fetch()) {
        // Assign the results to variables before checking the password
        $_SESSION['user_id'] = $userID;  // Assigning a value to $_SESSION['user_id']

        if (password_verify($password, $hashedPassword)) {
            $stmt->close();
            return true;
        }
    }

    // Close the statement in case of failure or incorrect credentials
    $stmt->close();
    return false;
}

    
    


    public function getLoggedInUser() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE UserID = ?");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result;
        } else {
            return null;
        }
    }
}
?>

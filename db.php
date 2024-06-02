<?php

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'TrendTrove';
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Set charset to UTF-8 (or any other charset you prefer)
        $this->conn->set_charset("utf8");
    }

    public function __destruct() {
        // Close the database connection when the object is destroyed
        $this->conn->close();
    }
}

<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_db_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8mb4"); // Set character encoding
?>

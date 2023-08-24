<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Using prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

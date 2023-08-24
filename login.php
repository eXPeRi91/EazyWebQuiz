<?php
session_start();
include("db_config.php"); // Include your database configuration file

if (isset($_SESSION["username"])) {
    header("Location: index.php"); // Redirect logged-in users to the home page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $db_username, $db_password); // Bind columns from the query
    $stmt->fetch();

    if ($db_username !== null && password_verify($password, $db_password)) {
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($login_error)) : ?>
            <p class="error"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>
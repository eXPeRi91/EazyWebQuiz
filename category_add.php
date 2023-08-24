<?php
session_start();
include("db_config.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim($_POST["category_name"]);

    // Check if the category already exists
    $query_check = "SELECT id FROM quiz_categories WHERE category_name = ?";
    $stmt_check = $conn->prepare($query_check);

    if ($stmt_check) {
        $stmt_check->bind_param("s", $category_name);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();
            $error_message = "Category already exists!";
        } else {
            $stmt_check->close();

            // Insert the new category
            $query_insert = "INSERT INTO quiz_categories (category_name) VALUES (?)";
            $stmt_insert = $conn->prepare($query_insert);

            if ($stmt_insert) {
                $stmt_insert->bind_param("s", $category_name);
                if ($stmt_insert->execute()) {
                    $stmt_insert->close();
                    header("Location: index.php");
                    exit();
                } else {
                    die("Error in the query: " . $conn->error);
                }
            } else {
                die("Error in the query: " . $conn->error);
            }
        }
    } else {
        die("Error in the query: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_question.php">Add Question</a></li>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Add Category</h2>
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="category_add.php" method="post">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" required>
            <button type="submit">Add Category</button>
        </form>
    </div>
</body>
</html>

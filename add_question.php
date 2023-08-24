<?php
session_start();
include("db_config.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Fetch existing categories
$query = "SELECT id, category_name FROM quiz_categories";
$categories = array();

if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $categories[$row["id"]] = $row["category_name"];
    }
    $result->free();
} else {
    die("Error in the query: " . $conn->error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $option_a = $_POST["option_a"];
    $option_b = $_POST["option_b"];
    $option_c = $_POST["option_c"];
    $option_d = $_POST["option_d"];
    $correct_answer = $_POST["correct_answer"];
    $category_id = $_POST["category_id"];

    $query = "INSERT INTO quiz_questions (question, option_a, option_b, option_c, option_d, correct_answer, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssi", $question, $option_a, $option_b, $option_c, $option_d, $correct_answer, $category_id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: index.php");
            exit();
        } else {
            die("Error in the query: " . $conn->error);
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
    <title>Add Question</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category_add.php">Add Category</a></li>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Add Question</h2>
        <form action="add_question.php" method="post">
            <label for="category_id">Select Category:</label>
            <select name="category_id" id="category_id">
                <?php foreach ($categories as $id => $category_name) : ?>
                    <option value="<?php echo $id; ?>"><?php echo $category_name; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="question">Question:</label>
            <textarea name="question" id="question" required></textarea>
            <label for="option_a">Option A:</label>
            <input type="text" name="option_a" id="option_a" required>
            <label for="option_b">Option B:</label>
            <input type="text" name="option_b" id="option_b" required>
            <label for="option_c">Option C:</label>
            <input type="text" name="option_c" id="option_c" required>
            <label for="option_d">Option D:</label>
            <input type="text" name="option_d" id="option_d" required>
            <label for="correct_answer">Correct Answer:</label>
            <input type="text" name="correct_answer" id="correct_answer" required>
            <button type="submit">Add Question</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
include("db_config.php"); // Include your database configuration file

if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect non-logged-in users to the login page
    exit();
}

// Fetch quiz questions from the database
$quiz_questions = array(); // Initialize an array to store quiz questions

$query = "SELECT id, correct_answer FROM quiz_questions";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($id, $correct_answer);

    while ($stmt->fetch()) {
        $quiz_questions[$id] = $correct_answer;
    }

    $stmt->close();
} else {
    die("Error in the query: " . $conn->error);
}

// Calculate score
$score = 0;

foreach ($quiz_questions as $id => $correct_answer) {
    if (isset($_POST["answer_" . $id]) && $_POST["answer_" . $id] === $correct_answer) {
        $score++;
    }
}

// Store the score in the database
if ($score > 0) {
    $username = $_SESSION["username"];
    $insert_query = "INSERT INTO quiz_scores (username, score) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);

    if ($insert_stmt) {
        $insert_stmt->bind_param("si", $username, $score);
        $insert_stmt->execute();
        $insert_stmt->close();
    } else {
        die("Error in inserting score: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
        </ul>
    </nav>
    <div class="container quiz-result-container">
        <h2>Quiz Result</h2>
        <p>Your score: <?php echo $score; ?></p>
    </div>
</body>
</html>

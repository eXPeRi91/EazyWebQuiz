<?php
session_start();
include("db_config.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Mistakes Review</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="review.php">Review Mistakes</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Quiz Mistakes Review</h2>
        <?php
        $quiz_questions = $_SESSION["quiz_questions"];

        foreach ($quiz_questions as $quiz_question) {
            if ($quiz_question["selected_answer"] !== $quiz_question["correct_answer"]) {
                echo "<div>";
                echo "<p>Question: " . $quiz_question["question"] . "</p>";
                echo "<p>Your Answer: " . $quiz_question["selected_answer"] . "</p>";
                echo "<p>Correct Answer: " . $quiz_question["correct_answer"] . "</p>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>

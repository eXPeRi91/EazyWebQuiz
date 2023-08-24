<?php
session_start();
include("db_config.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Fetch quiz categories from the database
$quiz_categories = array();
$query_categories = "SELECT id, category_name FROM quiz_categories";
$stmt_categories = $conn->prepare($query_categories);

if ($stmt_categories) {
    $stmt_categories->execute();
    $stmt_categories->bind_result($category_id, $category_name);

    while ($stmt_categories->fetch()) {
        $quiz_categories[] = array(
            "id" => $category_id,
            "name" => $category_name
        );
    }

    $stmt_categories->close();
} else {
    die("Error in the query: " . $conn->error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_category_id = $_POST["category"];
    // Fetch questions for the selected category
    $quiz_questions = array();
    $query_questions = "SELECT id, question, option_a, option_b, option_c, option_d, correct_answer FROM quiz_questions WHERE category_id = ?";
    $stmt_questions = $conn->prepare($query_questions);

    if ($stmt_questions) {
        $stmt_questions->bind_param("i", $selected_category_id);
        $stmt_questions->execute();
        $stmt_questions->bind_result($id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);

        while ($stmt_questions->fetch()) {
            $quiz_questions[] = array(
                "id" => $id,
                "question" => $question,
                "option_a" => $option_a,
                "option_b" => $option_b,
                "option_c" => $option_c,
                "option_d" => $option_d,
                "correct_answer" => $correct_answer,
                "selected_answer" => "" // Initialize selected answer
            );
        }

        $stmt_questions->close();
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
    <title>Quiz</title>
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
    <div class="container quiz-container">
        <?php if (!isset($_POST["category"])) : ?>
            <h2>Select a Category</h2>
            <form action="quiz.php" method="post">
                <select name="category">
                    <?php foreach ($quiz_categories as $category) : ?>
                        <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Start Quiz</button>
            </form>
        <?php else : ?>
            <h2>Quiz</h2>
            <form action="quiz_result.php" method="post">
                <?php foreach ($quiz_questions as $quiz_question) : ?>
                    <div class="quiz-question">
                        <div class="question-box"><?php echo $quiz_question["question"]; ?></div>
                        <div class="answer-options">
                            <label class="answer-box">
                                <input type="radio" name="answer_<?php echo $quiz_question["id"]; ?>"
                                       value="<?php echo $quiz_question["option_a"]; ?>"
                                       <?php if ($quiz_question["selected_answer"] === $quiz_question["option_a"]) echo "checked"; ?>>
                                <?php echo $quiz_question["option_a"]; ?>
                            </label>
                            <label class="answer-box">
                                <input type="radio" name="answer_<?php echo $quiz_question["id"]; ?>"
                                       value="<?php echo $quiz_question["option_b"]; ?>"
                                       <?php if ($quiz_question["selected_answer"] === $quiz_question["option_b"]) echo "checked"; ?>>
                                <?php echo $quiz_question["option_b"]; ?>
                            </label>
                        </div>
                        <div class="answer-options">
                            <label class="answer-box">
                                <input type="radio" name="answer_<?php echo $quiz_question["id"]; ?>"
                                       value="<?php echo $quiz_question["option_c"]; ?>"
                                       <?php if ($quiz_question["selected_answer"] === $quiz_question["option_c"]) echo "checked"; ?>>
                                <?php echo $quiz_question["option_c"]; ?>
                            </label>
                            <label class="answer-box">
                                <input type="radio" name="answer_<?php echo $quiz_question["id"]; ?>"
                                       value="<?php echo $quiz_question["option_d"]; ?>"
                                       <?php if ($quiz_question["selected_answer"] === $quiz_question["option_d"]) echo "checked"; ?>>
                                <?php echo $quiz_question["option_d"]; ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit">Submit Answers</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

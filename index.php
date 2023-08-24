<?php
session_start();
include("db_config.php"); // Include your database configuration file

// Fetch a random news item from the database
$random_news = "";
$query = "SELECT news_content FROM news ORDER BY RAND() LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $random_news = $row["news_content"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morty Quiz Website</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cookie-consent.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION["username"])) : ?>
                <li><a href="quiz.php">Quiz</a></li>
                <li><a href="logout.php">Log Out</a></li>
                <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
            <?php else : ?>
                <li><a href="login.php">Log In</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Cookie Consent Banner -->
    <div class="cookie-consent" id="cookieConsent">
        This website uses cookies to ensure you get the best experience on our website.
        <button class="cookie-consent-btn" id="cookieConsentBtn">Got it!</button>
    </div>
    <div class="container">
        <h1>Welcome to Quiz Eazy Web Testing</h1>
        <?php if (isset($_SESSION["username"])) : ?>
            <p>Welcome back, <?php echo $_SESSION["username"]; ?>!</p>
        <?php else : ?>
            <p>This website is made with passion by M.Vladimirov A.K.A eXPeRi91</p>
        <?php endif; ?>

        <!-- News box -->
        <div class="news-box">
            <h2>Latest News</h2>
            <?php if (!empty($random_news)) : ?>
                <p><?php echo $random_news; ?></p>
            <?php else : ?>
                <p>No news available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Cookie Consent Script -->
    <script src="cookie-consent.js"></script>
</body>
</html>

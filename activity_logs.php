<?php
session_start();
include("db_config.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Fetch activity logs from the database
$activity_logs = array();
$query_logs = "SELECT username, action, created_at FROM activity_logs ORDER BY created_at DESC";
$result_logs = $conn->query($query_logs);

if ($result_logs) {
    while ($row = $result_logs->fetch_assoc()) {
        $activity_logs[] = $row;
    }
} else {
    die("Error in the query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="activity_logs.php">Activity Logs</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>Welcome, <?php echo $_SESSION["username"]; ?></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Activity Logs</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            <?php foreach ($activity_logs as $log) : ?>
                <tr>
                    <td><?php echo $log["username"]; ?></td>
                    <td><?php echo $log["action"]; ?></td>
                    <td><?php echo $log["created_at"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
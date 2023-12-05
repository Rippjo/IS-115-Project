<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // The user is not logged in, redirect to the login page
    header("Location: login.inc.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    // End the session
    session_unset();
    session_destroy();

    header("Location: login.inc.php?logout=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student page - Booking System</title>
    <link rel="stylesheet" href="../css/student.css">
</head>
<body>

<div class="container">
    <h2>Welcome to the Student page!</h2>
    <div class="button-container">
        <a href="../html/SB.html" class="action-button">Booking</a>
        <a href="calendar_student.inc.php" class="action-button">Calendar</a>
        <a href="profile_student.inc.php" class="action-button">Profile</a>

        <!-- Logout form -->
        <form action="" method="post">
            <button type="submit" name="logout" class="action-button">Logout</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Brukeren er ikke logget inn, videresend til innloggingssiden
    header("Location: login.inc.php");
    exit();
}

// Utloggingsfunksjonalitet
if (isset($_POST['logout'])) {
    // Avslutt sesjonen
    session_unset();
    session_destroy();

    // Videresend til innloggingssiden med utloggingsmelding
    header("Location: login.inc.php?logout=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher page - Booking System</title>
    <link rel="stylesheet" href="../css/student.css">
</head>
<body>

<div class="container">
    <h2>Welcome to the assistant teacher page!</h2>
    <div class="button-container">
        <a href="calendar_teacher.inc.php" class="action-button">Calendar</a>
        <a href="profile_teacher.inc.php" class="action-button">Profile</a>

        <!-- Logout form -->
        <form action="" method="post">
            <button type="submit" name="logout" class="action-button">Logout</button>
        </form>
    </div>
</div>

</body>
</html>

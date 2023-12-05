<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or show an error message
    header("Location: login.inc.php");
    exit();
}

// Include your database connection file
require_once "../../../Private/dbConn.php";

// Fetch available hours from the database
$sql = "SELECT * FROM teacher_availability WHERE is_booked = 0";
$result = $conn->query($sql);

// Create an array to store available hours by day
$availableHoursByDay = [];

// Check if there are available hours
if ($result->num_rows > 0) {
    // Organize available hours by day
    while ($row = $result->fetch_assoc()) {
        $dayOfWeek = $row['day_of_week'];
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];

        // Store the available hours in the array
        $availableHoursByDay[$dayOfWeek][] = [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoring Availability Calendar</title>
    <link rel="stylesheet" href="../css/calendar_student.css">
</head>
<body>
    <h2>Tutoring Availability Calendar</h2>

    <div class="calendar">
        <?php
        // Define days of the week
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Loop through each day of the week
        foreach ($daysOfWeek as $day) {
            echo "<div class='day'>";
            echo "<h3>$day</h3>";

            // Check if there are available hours for the day
            if (isset($availableHoursByDay[$day])) {
                // Display available hours
                echo "<div class='available-hours'>";
                foreach ($availableHoursByDay[$day] as $hours) {
                    echo "<p>{$hours['start_time']} - {$hours['end_time']}</p>";
                }
                echo "</div>";
            } else {
                echo "<p class='no-available-hours'>No available hours</p>";
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
</html>

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

// Fetch available hours with teacher information from the database
$sql = "SELECT ta.*, u.name AS teacher_name, u.user_id, ta.course_name
        FROM teacher_availability ta
        JOIN user u ON ta.teacher_id = u.user_id
        WHERE ta.is_booked = 0";

$result = $conn->query($sql);

// Create an array to store available hours by day and teacher
$availableHoursByDayAndTeacher = [];

// Check if there are available hours
if ($result->num_rows > 0) {
    // Organize available hours by day and teacher
    while ($row = $result->fetch_assoc()) {
        $dayOfWeek = $row['day_of_week'];
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];
        $teacherName = $row['teacher_name'];
        $teacherId = $row['user_id'];
        $courseName = $row['course_name'];

        // Store the available hours in the array
        $availableHoursByDayAndTeacher[$dayOfWeek][$teacherId][] = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'teacher_name' => $teacherName,
            'course_name' => $courseName,
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
            if (isset($availableHoursByDayAndTeacher[$day])) {
                // Display available hours
                foreach ($availableHoursByDayAndTeacher[$day] as $teacherId => $teacherHours) {
                    echo "<div class='teacher-column'>";
                    echo "<h4>{$teacherHours[0]['teacher_name']} - {$teacherHours[0]['course_name']}</h4>";
                    echo "<div class='available-hours'>";
                    foreach ($teacherHours as $hours) {
                        echo "<p>{$hours['start_time']} - {$hours['end_time']}</p>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-available-hours'>No available hours</p>";
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
</html>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or show an error message
    header("Location: login.inc.php");
    exit();
}

// Include the database connection file 
require_once "../../../Private/dbConn.php";

// Get the user ID of the logged-in student
$user_id = $_SESSION['user_id'];

// Retrieve upcoming bookings for the logged-in student
$sql = "SELECT * FROM student_booking 
        WHERE student_id = '$user_id' 
        AND booking_date >= CURDATE()
        ORDER BY booking_date, start_time";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through the results and display the upcoming booking information
    while ($row = $result->fetch_assoc()) {
       
        echo '<div class="booking-entry">';
        echo '<h3>Booking ID: ' . $row['booking_id'] . '</h3>';
        echo '<div class="booking-details">';
        echo '<span>Teaching Assistant ID:</span> ' . $row['teacher_id'] . '<br>';
        echo '<span>Course:</span> ' . $row['course_name'] . '<br>';
        echo '<span>Booking Date:</span> ' . $row['booking_date'] . '<br>';
        echo '<span>Time:</span> ' . $row['start_time'] . ' - ' . $row['end_time'] . '<br>';
        echo '<span>Explanation:</span> ' . $row['explanation'] . '<br>';
        echo '<span>Confirmed:</span> <span class="';
        echo ($row['is_confirmed'] ? 'confirmed-yes">Yes' : 'confirmed-no">No') . '</span><br>';
        
        echo '</div></div>';
    }
} else {
    echo "No upcoming appointments found for this student.";
}

$conn->close();
?>

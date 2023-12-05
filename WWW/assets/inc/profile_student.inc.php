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

// Get the user ID of the logged-in student
$user_id = $_SESSION['user_id'];

// Retrieve bookings for the logged-in student
$sql = "SELECT * FROM booking WHERE student_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through the results and display the booking information
    while ($row = $result->fetch_assoc()) {
        // Output the booking details, you can customize this part based on your table structure
        echo "Booking ID: " . $row['booking_id'] . "<br>";
        echo "Teaching Assistant ID: " . $row['teacher_id'] . "<br>";
        echo "Booking Date: " . $row['booking_date'] . "<br>";
        // Add more details as needed
        echo "<hr>";
    }
} else {
    echo "No bookings found for this student.";
}

$conn->close();
?>

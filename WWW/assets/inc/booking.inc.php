<?php
require_once '../lib/SB.lib.php'; // Include the Booking class file

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the form sends these parameters: student_id, teacher_id, course_name, booking_date, start_time, end_time, explanation

    // Retrieve the posted data
    $studentId = $_POST['student_id'];
    $teacherId = $_POST['teacher_id'];
    $courseName = $_POST['course_name'];
    $bookingDate = $_POST['booking_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $explanation = $_POST['explanation'];

    // Create an instance of the Booking class
    $booking = new Booking(); // You might need to pass the database connection parameters here

    // Make the booking using the posted data
    $bookingMade = $booking->makeBooking($studentId, $teacherId, $courseName, $bookingDate, $startTime, $endTime, $explanation);

    // Check if the booking was made successfully
    if ($bookingMade) {
        echo "Booking made successfully";
        // You might want to redirect the user to another page or perform further actions
    } else {
        echo "Failed to make booking";
        // Handle the failure scenario
    }

    // Close the database connection (if needed)
    // $booking->closeConnection(); // Uncomment if your Booking class has a closeConnection method
} else {
    echo "Invalid request method"; // Handle if it's not a POST request
}
?>
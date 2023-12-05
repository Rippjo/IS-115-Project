<?php
require_once '../lib/TA.lib.php'; // Include the TA class file

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the form sends these parameters: teacher_id, day_of_week, start_time, end_time

    // Retrieve the posted data
    $teacherId = $_POST['teacher_id'];
    $dayOfWeek = $_POST['day_of_week'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Create an instance of the TA class
    $ta = new Ta(); // You might need to pass the database connection parameters here

    // Set the availability using the posted data
    $availabilitySet = $ta->setTeacherAvailability($teacherId, $dayOfWeek, $startTime, $endTime);

    // Check if the availability was set successfully
    if ($availabilitySet) {
        echo "Teacher availability set successfully";
        // You might want to redirect the teacher to another page or perform further actions
    } else {
        echo "Failed to set teacher availability";
        // Handle the failure scenario
    }

    // Close the database connection (if needed)
    // $ta->closeConnection(); // Uncomment if your TA class has a closeConnection method
} else {
    echo "Invalid request method"; // Handle if it's not a POST request
}
?>

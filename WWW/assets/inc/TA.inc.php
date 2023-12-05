<?php 
session_start();

require_once '../lib/TA.lib.php';
require_once "../../../Private/dbConn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login.inc.php");
        exit();
    }

    $teacherId = $_SESSION['user_id'];
    $dayOfWeek = $_POST['day_of_week'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $courseName = $_POST['course_name'];

    $stmt = $conn->prepare("SELECT course_id FROM course WHERE course_name = ?");
    $stmt->bind_param("s", $courseName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $courseId = $row['course_id'];
        
        // Output fetched course ID and name for debugging
        echo "Fetched Course ID: " . $courseId . ", Course Name: " . $courseName;

        $ta = new TA();
        $availabilitySet = $ta->setTeacherAvailability($teacherId, $courseId, $dayOfWeek, $startTime, $endTime);

        if ($availabilitySet) {
            echo "Teacher availability set successfully";
        } else {
            echo "Failed to set teacher availability";
        }
    } else {
        echo "No course found with the provided name";
    }

    $stmt->close();
    $conn->close();
}
?>
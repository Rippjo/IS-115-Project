<?php
require_once "../../../Private/dbConn.php";

class TA {
    protected $conn; // Database connection or instance

    public function __construct() {
        global $dbHost, $dbUser, $dbPass, $dbName; // Access global database connection details
        $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName); // Initialize the database connection

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to set the availability of a teacher
    public function setTeacherAvailability($teacherId, $dayOfWeek, $startTime, $endTime) {
        $sql = "INSERT INTO teacher_availability (teacher_id, day_of_week, start_time, end_time) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $teacherId, $dayOfWeek, $startTime, $endTime);
        
        if ($stmt->execute()) {
            return true; // Availability set successfully
        } else {
            return false; // Failed to set availability
        }
    }

    // Method to get the availability of a teacher
    public function getTeacherAvailability($teacherId) {
        $sql = "SELECT * FROM teacher_availability WHERE teacher_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $teacherId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $availability = $result->fetch_all(MYSQLI_ASSOC);
        
        return $availability;
    }

    // Additional methods for managing teacher availability can be added as required

    // Close the database connection
    public function closeConnection() {
        $this->conn->close();
    }
}
?>
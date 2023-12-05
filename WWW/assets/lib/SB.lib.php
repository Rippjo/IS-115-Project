<?php // Booking.lib.php

require_once '../../../Private/dbConn.php'; // Include database connection file

class Booking {
    protected $conn; // Database connection

    public function __construct() {
        global $dbHost, $dbUser, $dbPass, $dbName; // Access global database connection details
        $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName); // Initialize the database connection

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function makeBooking($studentId, $teacherId, $courseName, $bookingDate, $startTime, $endTime, $explanation) {
        $sql = "INSERT INTO student_booking (student_id, teacher_id, course_name, booking_date, start_time, end_time, explanation) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisssss", $studentId, $teacherId, $courseName, $bookingDate, $startTime, $endTime, $explanation);
        
        if ($stmt->execute()) {
            return true; // Booking made successfully
        } else {
            return false; // Failed to make booking
        }
    }

    // Method to retrieve bookings for a particular student
    public function getStudentBookings($studentId) {
        $sql = "SELECT * FROM student_booking WHERE student_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);
        
        return $bookings;
    }

    // Additional methods for managing bookings can be added as required

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
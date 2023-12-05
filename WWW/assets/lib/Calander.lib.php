<?php
class Calendar {

        protected $conn; // Database connection
    
        public function __construct() {
            global $dbHost, $dbUser, $dbPass, $dbName;
            $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
    
         // Method to retrieve available time slots for a specific teacher
         public function getAvailableTimeSlots($teacherId, $startDate, $endDate) {
            $sql = "SELECT * FROM teacher_availability WHERE teacher_id = ? 
                    AND day_of_week BETWEEN ? AND ? AND is_booked = 0";
            
            // Assuming 'day_of_week' is a date field representing available dates
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $teacherId, $startDate, $endDate);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $availableTimeSlots = $result->fetch_all(MYSQLI_ASSOC);
    
            return $availableTimeSlots;
        }
    
        // Method to retrieve booked classes for a teacher
        public function getBookedClasses($teacherId, $startDate, $endDate) {
            $sql = "SELECT sb.*, u.name AS student_name 
                    FROM student_booking sb
                    INNER JOIN user u ON sb.student_id = u.user_id
                    WHERE sb.teacher_id = ? 
                    AND sb.booking_date BETWEEN ? AND ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $teacherId, $startDate, $endDate);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $bookedClasses = $result->fetch_all(MYSQLI_ASSOC);
            
            return $bookedClasses;
        }
        
    
        // Additional methods for calendar functionality
    }
    
<?php
class Booking {
    // Properties
    private $booking_id;
    private $teacher_id;
    private $student_id;
    private $course_name;
    private $booking_datetime;
    private $explanation;
    private $is_confirmed;

    // Constructor
    public function __construct($teacher_id, $student_id, $course_name, $booking_datetime, $explanation) {
        // Assign the provided values to object properties
        $this->teacher_id = $teacher_id;
        $this->student_id = $student_id;
        $this->course_name = $course_name;
        $this->booking_datetime = $booking_datetime;
        $this->explanation = $explanation;
        $this->is_confirmed = false; // By default, a booking is not confirmed
    }

    // Getter and Setter methods for properties (if needed)

    public function saveBookingToDatabase() {
        // Assuming you have a database connection established

        // Prepare the SQL INSERT statement
        $sql = "INSERT INTO booking (teacher_id, student_id, course_name, booking_datetime, explanation, is_confirmed)
                VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare and bind parameters
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("iissss", $this->teacher_id, $this->student_id, $this->course_name, 
                          $this->booking_datetime, $this->explanation, $this->is_confirmed);

        // Execute the query
        if ($stmt->execute()) {
            // Booking successfully inserted into the database
            return true;
        } else {
            // Handle insertion failure (you can add more error handling logic here)
            return false;
        }

        // Close the statement and database connection
        $stmt->close();
        $connection->close();
    }

    
}
?>
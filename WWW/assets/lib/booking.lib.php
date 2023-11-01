<?php
/* A simple Booking class, which includes name of student/Teacher, booking date,
 and functions to get each variable from the constructor*/
class Booking {
    // Private instance variables
    private $studentName;
    private $tutorName;
    private $bookingDate;
    
    // constructor assigning each private instance variable to a method variable
    public function __construct($student, $tutor, $date) {
        $this->studentName = $student;
        $this->tutorName = $tutor;
        $this->bookingDate = $date;
    }
    
    // Functions to get the value of each    variable from outside of the class
    public function getStudentName() {
        return $this->studentName;
    }
    
    public function getTutorName() {
        return $this->tutorName;
    }
    
    public function getBookingDate() {
        return $this->bookingDate;
    }
}
?>

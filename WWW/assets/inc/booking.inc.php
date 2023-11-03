
<?php
// Requires the booking class from booking.lib.php, found in the lib directerory.
 require '../lib/booking.lib.php';
 ?>

<!-- Html code for input to create a booking object -->
<!DOCTYPE html>
<html>
<head>
    <title>Booking Test</title>
</head>
<body>
    <form method="post">
        <label for="student">Student Name:</label>
        <input type="text" id="student" name="student" required><br>
        
        <label for="tutor">Tutor Name:</label>
        <input type="text" id="tutor" name="tutor" required><br>
        
        <label for="date">Booking Date:</label>
        <input type="date" id="date" name="date" required><br>
        
        <input type="submit" value="Create Booking">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Fetch data from the form 
        $student = $_POST["student"];
        $tutor = $_POST["tutor"];
        $date = $_POST["date"];

        // Create a new Booking object with the data that was fetched
        $booking = new Booking($student, $tutor, $date);

        // Print out the information  the booking object.
        echo "<hr>";
        echo "Student: " . $booking->getStudentName() . "<br>";
        echo "Tutor: " . $booking->getTutorName() . "<br>";
        echo "Booking Date: " . $booking->getBookingDate() . "<br>";
    }
    ?>
</body>
</html>
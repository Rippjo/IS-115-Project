<!DOCTYPE html>
<html>
<head>
    <title>Set Teacher Availability</title>
    <link rel="stylesheet" type="text/css" href="../css/TA.css">
</head>
<body>

<h2>Set Teacher Availability</h2>

<form action="../inc/TA.inc.php" method="POST">
    <label for="day_of_week">Day of the Week:</label><br>
    <select id="day_of_week" name="day_of_week" required>
        <option value="">Select Day</option>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
    </select><br><br>

    <label for="start_time">Start Time:</label><br>
<select id="start_time" name="start_time" required>
    <option value="">Select Start Time</option>
    <?php
    // Generating options for start times from 07:00 to 14:00
    $startTime = strtotime('07:00');
    $endTime = strtotime('14:00');
    while ($startTime <= $endTime) {
        echo '<option value="' . date('H:i', $startTime) . '">' . date('h:i A', $startTime) . '</option>';
        $startTime = strtotime('+1 hour', $startTime);
    }
    ?>
</select><br><br>

<label for="end_time">End Time:</label><br>
<select id="end_time" name="end_time" required>
    <option value="">Select End Time</option>
    <?php
    // Generating options for end times from 08:00 to 15:00
    $startTime = strtotime('08:00');
    $endTime = strtotime('15:00');
    while ($startTime <= $endTime) {
        echo '<option value="' . date('H:i', $startTime) . '">' . date('h:i A', $startTime) . '</option>';
        $startTime = strtotime('+1 hour', $startTime);
    }
    ?>
</select><br><br>

<label for="course_name">Course:</label><br>
<select id="course_name" name="course_name" required>
    <option value="">Select Course</option>
    <?php
    // Include database connection
    require_once "../../../Private/dbConn.php";

    // Fetch course names from the database
    $sql = "SELECT course_name FROM course";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["course_name"] . '">' . $row["course_name"] . '</option>';
        }
    } else {
        echo '<option value="">No courses available</option>';
    }

    // Close the database connection
    $conn->close();
    ?>
</select><br><br>



    <input type="submit" value="Submit">
</form>

</body>
</html>


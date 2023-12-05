<?php
session_start();

// Check if the user is logged in and is a teaching assistant
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or show an error message
    header("Location: login.inc.php");
    exit();
}

// Include your database connection file
require_once "../../../Private/dbConn.php";

// Handle profile updates or creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    // Assuming you have input fields in your form with names like 'experience', 'courses_offer', etc.
    $experience = $_POST["experience"];
    $courses_offer = $_POST["courses_offer"];
    $tutoring_length = $_POST["tutoring_length"];
    $availability = $_POST["availability"];
    $topics_offered = $_POST["topics_offered"];

    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Check if the profile exists
    $sqlCheckProfile = "SELECT * FROM profile WHERE user_id = '$user_id'";
    $resultCheckProfile = $conn->query($sqlCheckProfile);

    if ($resultCheckProfile->num_rows > 0) {
        // Update the existing profile in the 'profile' table
        $sql = "UPDATE profile SET
            experience = '$experience',
            courses_offer = '$courses_offer',
            tutoring_length = '$tutoring_length',
            availability = '$availability',
            topics_offered = '$topics_offered'
            WHERE user_id = '$user_id'";
    } else {
        // Insert a new profile into the 'profile' table
        $sql = "INSERT INTO profile (user_id, experience, courses_offer, tutoring_length, availability, topics_offered)
            VALUES ('$user_id', '$experience', '$courses_offer', '$tutoring_length', '$availability', '$topics_offered')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating/inserting profile: " . $conn->error;
    }
}

// Fetch the current profile information for the teaching assistant
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM profile WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
} else {
    // Handle the case where the profile doesn't exist (insert a new profile, show an error, etc.)
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Assistant Profile</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../css/profile_teacher.css">
</head>
<body>

<h2>Teaching Assistant Profile</h2>

<!-- Display the current profile information -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="experience">Experience:</label>
    <input type="text" name="experience" value="<?php echo $profile['experience']; ?>"><br>

    <label for="courses_offer">Courses Offered:</label>
    <input type="text" name="courses_offer" value="<?php echo $profile['courses_offer']; ?>"><br>

    <label for="tutoring_length">Tutoring Length:</label>
    <input type="text" name="tutoring_length" value="<?php echo $profile['tutoring_length']; ?>"><br>

    <label for="availability">Availability:</label>
    <input type="text" name="availability" value="<?php echo $profile['availability']; ?>"><br>

    <label for="topics_offered">Topics Offered:</label>
    <input type="text" name="topics_offered" value="<?php echo $profile['topics_offered']; ?>"><br>

    <input type="submit" name="update_profile" value="Update Profile">
</form>

<!-- Add other HTML elements as needed -->

</body>
</html>

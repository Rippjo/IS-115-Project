<?php

require '../lib/user.lib.php';

// Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Check if all required fields are submitted
    if (
        isset($_POST["name"]) &&
        isset($_POST["lastName"]) &&
        isset($_POST["phone_number"]) &&
        isset($_POST["email"]) &&
        isset($_POST["password"]) &&
        isset($_POST["birthDate"]) &&
        isset($_POST["userType"])
    ) {
        $name = $_POST["name"];
        $lastName = $_POST["lastName"];
        $phoneNumber = $_POST["phone_number"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $birthDate = $_POST["birthDate"];
        $userType = $_POST["userType"]; 

        // Check if the selected userType is '1' (student) or '2' (teacher)
        if ($userType === '1' || $userType === '2') {
            // Create a User object
            try {
                // Modify the constructor to use $userType as user_type
                if ($userType === '1') {
                    $newUser = new Student($name, $lastName, $phoneNumber, $email, $password, $userType, $birthDate);
                } elseif ($userType === '2') {
                    $newUser = new Teacher($name, $lastName, $phoneNumber, $email, $password, $userType, $birthDate);
                }

                // Check if the email is valid and password is valid
                if (!$newUser->validateEmail($email)) {
                    $error_message = "Invalid email format. Please enter a valid email address.";
                } else if (!$newUser->isStrongPassword($password)) {
                    $error_message = "Password does not meet the required criteria. It should have at least 1 uppercase letter, 2 numbers, and be at least 6 characters long.";
                } else {
                    // Hash the password for better security
                    $newUser->hashPassword($password);
                    // Save the user to the database
                    if ($newUser->saveToDatabase()) {
                        // Redirect to login page after successful registration
                        header("Location: ../inc/login.inc.php");
                        exit();
                    } else {
                        $error_message = "Error registering user.";
                    }
                }
            } catch (InvalidArgumentException $e) {
                // Handle exceptions thrown in User class constructor
                $error_message = $e->getMessage();
            }
        } else {
            $error_message = "Please select a valid user type.";
        }
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/registrer.css">
</head>
<body>
    <div class="container">
        <h2>Registration</h2>
        
        <?php
        if (!empty($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required>

            <label for="email">Email:</label>
            <input type="text" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="birthDate">BirthDate:</label>
            <input type="date" name="birthDate" required>

            <div class="input-group">
    <input type="radio" id="student" name="userType" value="1" required>
    <label class="checkbox-label" for="student">Student</label>

    <input type="radio" id="teacher" name="userType" value="2" required>
    <label class="checkbox-label" for="teacher">Teacher Assistant</label>
</div>


            <input type="submit" name="register" value="Register">
        </form>
    </div>
</body>
</html>


<?php
session_start();

// Require the User class file
require '../lib/user.lib.php';

$error_message = ""; // Holds error messages

//registration

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Check if all required fields are submitted
    if (
        isset($_POST["name"]) &&
        isset($_POST["lastName"]) &&
        isset($_POST["phone_number"]) &&
        isset($_POST["email"]) &&
        isset($_POST["password"]) &&
        isset($_POST["userType"]) &&
        isset($_POST["birthDate"])
    ) {
        $name = $_POST["name"];
        $lastName = $_POST["lastName"];
        $phoneNumber = $_POST["phone_number"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $userType = $_POST["userType"];
        $birthDate = $_POST["birthDate"];

        // Create a User object
        try {
            $newUser = new User($name, $lastName, $phoneNumber, $email, $password, $userType, $birthDate);

            // Check if the email is valid and password is valid
            if (!$newUser->validateEmail($email)) {
                $error_message = "Invalid email format. Please enter a valid email address.";
            } else if (!$newUser->isStrongPassword($password)) {
                $error_message = "Password does not meet the required criteria. It should have at least 1 uppercase letter, 2 numbers, and be at least 6 characters long.";
            } else {
                // hash the password
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
    <link rel="stylesheet" href="../css/register.css">
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

            <label for="userType">Usertype:</label>
            <input type="text" name="userType" required>


            <input type="submit" name="register" value="Register">
        </form>
    </div>
</body>
</html>



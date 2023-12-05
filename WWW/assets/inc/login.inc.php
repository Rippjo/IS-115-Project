<?php
session_start();

require_once "../../../Private/dbConn.php";

// Login script
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // login succesful
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $row['user_id'];

            // logs into respective page after what usertype the loggedn in user is (if usertype=1 he will get loggen into student page, and usertype=2 gets loggen into teacher page)
            if ($row['user_type'] == 1) {
                header("Location: student_side.inc.php");
            } elseif ($row['user_type'] == 2) {
                header("Location: teacher_side.inc.php");
            }
            exit();
        } else {
            echo "Wrong password."; // 
        }
    } else {
        echo "Wrong username."; 
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <input type="submit" name="login" value="Log in">
    </form>
</body>
</html>


<!DOCTYPE html>
<html>

<!-- For å sjekke hvordan og om calcage metoden fungerer fra user.lib.php -->

<head>
    <title>Calculate Age Test</title>
</head>
<body>
    <form method="post">
        <label for="birthdate">Enter your birthdate (YYYY-MM-DD):</label>
        <input type="date" name="birthdate" id="birthdate" />
        <input type="submit" value="Calculate Age">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputBirthdate = $_POST['birthdate'];

        require_once '../lib/user.lib.php'; 

        $user = new User('TestUser', 'John', 'Doe', $inputBirthdate, '2023-10-30');
        $age = $user->calcAge();

        echo "<p>Your age is: $age years</p>";
    }
    ?>
</body>
</html>
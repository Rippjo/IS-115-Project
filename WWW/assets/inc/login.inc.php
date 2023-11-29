<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "prosjekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Innloggingsskript
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $epost = $_POST["epost"];
    $passord = $_POST["passord"];

    $sql = "SELECT * FROM reg_brukere WHERE epost = '$epost'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($passord, $row["passord"])) {
            // Innlogging vellykket, send brukeren til riktig side basert på valg
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $row['bruker_id'];

            // Sjekk hvilken knapp som ble trykket
            if (isset($_POST["student"])) {
                header("Location: student_side.inc.php");
            } elseif (isset($_POST["hjelpelaerer"])) {
                header("Location: hjelpelærer_side.inc.php");
            } 
            exit();
        } else {
            echo "Feil passord."; // Legg til denne feilsøkingsmeldingen
        }
    } else {
        echo "Feil e-postadresse."; // Legg til denne feilsøkingsmeldingen
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innlogging</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="container">
    <h2>Innlogging</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="epost">E-post:</label>
        <input type="text" name="epost" required><br>

        <label for="passord">Passord:</label>
        <input type="password" name="passord" required><br>

        <!-- Knapp for å logge inn som student -->
        <input type="submit" name="student" value="Logg inn som student">

        <!-- Knapp for å logge inn som hjelpelærer -->
        <input type="submit" name="hjelpelaerer" value="Logg inn som hjelpelærer">
    </form>
</body>
</html>

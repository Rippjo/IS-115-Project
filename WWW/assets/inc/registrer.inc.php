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

$error_message = ""; // Holder på feilmeldinger

// Registreringsskript
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $navn = $_POST["navn"];
    $mobilnummer = $_POST["mobilnummer"];
    $epost = $_POST["epost"];
    $passord = $_POST["passord"];

    // E-postvalidering
    if (!filter_var($epost, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Feil e-postformat. Vennligst skriv inn en gyldig e-postadresse.";
    } else {
        $hashetPassord = password_hash($passord, PASSWORD_DEFAULT);

        $sql = "INSERT INTO reg_brukere (navn, mobilnummer, epost, passord)
                VALUES ('$navn', '$mobilnummer', '$epost', '$hashetPassord')";

        if ($conn->query($sql) === TRUE) {
            // Redirect til innloggingssiden etter vellykket registrering
            header("Location: ../inc/login.inc.php");
            exit();
        } else {
            $error_message = "Feil ved registrering av bruker: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrering</title>
    <link rel="stylesheet" href="../css/registrer.css">
</head>
<body>
    <div class="container">
        <h2>Registrering</h2>
        
        <?php
        if (!empty($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="navn">Navn:</label>
            <input type="text" name="navn" required>

            <label for="mobilnummer">Mobilnummer:</label>
            <input type="text" name="mobilnummer" required>

            <label for="epost">E-post:</label>
            <input type="text" name="epost" required>

            <label for="passord">Passord:</label>
            <input type="password" name="passord" required>

            <input type="submit" name="register" value="Registrer">
        </form>
    </div>
</body>
</html>

<?php
// Database connection parameters
$dbHost = '10.228.19.18';  // The host where MySQL server is running (usually 'localhost' for XAMPP).
$dbUser = 'root';       // MySQL username.
$dbPass = '';           // MySQL password (empty by default in XAMPP).
$dbName = 'evkadb';     // Replace with your database name.

// Create a connection using mysqli
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>";

// Perform a SELECT query to fetch data from the 'users' table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["user_ID"] . "<br>". " name: " . $row["name"] . "<br>";
        // You should replace "username" with the actual column name in your table.
    }
} else {
    echo "0 results";
}

// Close the connection when done
$conn->close();
?>
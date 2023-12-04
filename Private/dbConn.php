<?php
// Database connection parameters
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '123';
$dbName = 'project';

// lager en database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>"; ?>
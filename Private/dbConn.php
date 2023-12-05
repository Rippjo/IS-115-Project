<?php
// Database connection parameters
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '123';
$dbName = 'project';

// Make a database connection. This makes it easier and more organized code because we can just require this file whenever we need a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

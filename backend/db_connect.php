<?php
// Database connection variables
$servername = "localhost"; // or your specific host
$username = "phpmyadmin";
$password = "your_password";
$dbname = "PatientManagementSystem"; // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful message (optional, for testing only)
// echo "Connected successfully";
?>

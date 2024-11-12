<?php
// config.php

// Database configuration
$host = 'localhost'; // Database host
$dbname = 'PatientManagementSystem'; // Database name
$username = 'phpmyadmin'; // Database username
$password = 'your_password'; // Database password

// Create a connection using MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset for the connection
$conn->set_charset("utf8");
?>

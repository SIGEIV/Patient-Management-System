<?php
$servername = "localhost";
$username = "phpmyadmin"; // Database username
$password = "your_password"; // Database password
$dbname = "PatientManagementSystem";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $RecordID = $_POST['RecordID'];
    
    // Delete record
    $sql = "DELETE FROM medical_records WHERE RecordID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $RecordID);
    $stmt->execute();
    
    // Redirect after deletion
    header("Location: view_medical_records.php");
    exit();
}

$conn->close();
?>

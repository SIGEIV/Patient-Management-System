<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection variables
$servername = "localhost"; // Server name (usually localhost)
$username = "phpmyadmin"; // Database username
$password = "your_password"; // Database password
$dbname = "PatientManagementSystem"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and sanitize inputs
$patient_id = htmlspecialchars($_POST['patient_id']);
$patient_name = htmlspecialchars($_POST['patient_name']);
$consultation_fees = (float) $_POST['consultation_fees'];
$lab_fees = (float) $_POST['lab_fees'];
$medication_costs = (float) $_POST['medication_costs'];

// Calculate total amount
$total_amount = $consultation_fees + $lab_fees + $medication_costs;

// Insert data into the database
$sql = "INSERT INTO invoices (patient_id, patient_name, consultation_fees, lab_fees, medication_costs, total_amount)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdddd", $patient_id, $patient_name, $consultation_fees, $lab_fees, $medication_costs, $total_amount);

if ($stmt->execute()) {
        // If successful, redirect back to the form with a success message
        header("Location: invoice.html?success=1");
        exit();
    } else {
        // Handle errors (e.g., log them or display an error message)
        echo "Error: " . $stmt->error;
    }

// Close the statement and connection
$stmt->close();
$conn->close();
?>

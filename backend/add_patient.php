<?php
// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db_connect.php'; // Ensure this connects to your MariaDB database
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $name = trim($_POST['name']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $medical_history = trim($_POST['medical_history']);

    // Validate input (simple validation, you can expand this)
    if (empty($name) || empty($dob) || empty($gender) || empty($contact) || empty($email)) {
        echo "All fields are required.";
        exit();
    }

    // Prepare an SQL statement for inserting the new patient
    $insertQuery = "INSERT INTO Patients (Name, DateOfBirth, Gender, Contact, Email, MedicalHistory) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param('ssssss', $name, $dob, $gender, $contact, $email, $medical_history);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // If successful, redirect back to the form with a success message
        header("Location: add_patient.html?success=1");
        exit();
    } else {
        // Handle errors (e.g., log them or display an error message)
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

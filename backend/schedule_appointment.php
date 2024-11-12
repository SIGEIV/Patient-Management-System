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


// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $patient_name = $conn->real_escape_string($_POST['patient_name']);
    $patient_contact = $conn->real_escape_string($_POST['patient_contact']);
    $ryr = isset($_POST['ryr']) ? $_POST['ryr'] : '';
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $doctor= $conn->real_escape_string($_POST['doctor']);
    $reason = $conn->real_escape_string($_POST['reason']);

    // Prepare and execute SQL statement
    $sql = "INSERT INTO Appointments (patient_id, patient_name, patient_contact, date, time, doctor, reason_for_visit) 
            VALUES ('$patient_id', '$patient_name', '$patient_contact', '$date', '$time', '$doctor', '$reason')";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: appointment.html?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Display error if insertion fails
    }
}

$conn->close(); // Close the connection
?>

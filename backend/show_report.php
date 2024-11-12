<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Include database connection (ensure the connection file is correct)
require_once('config.php');

// Get form data
$report_type = $_POST['report_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Create SQL query based on the selected report type
switch ($report_type) {
    case 'patients_per_doctor':
        $sql = "SELECT doctor_name, COUNT(patient_id) AS total_patients
                FROM Appointments
                WHERE appointment_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY doctor_name";
        break;

    case 'frequently_diagnosed_conditions':
        $sql = "SELECT Diagnosis, COUNT(*) AS occurrence_count
                FROM medical_records
                WHERE diagnosis_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY Diagnosis
                ORDER BY occurrence_count DESC";
        break;

    case 'appointment_volumes':
        $sql = "SELECT HOUR(appointment_time) AS hour_of_day, COUNT(*) AS total_appointments
                FROM Appointments
                WHERE appointment_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY hour_of_day
                ORDER BY hour_of_day";
        break;

    default:
        echo "Invalid report type!";
        exit;
}

// Execute the query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<h1>Report: $report_type</h1>";
    echo "<table border='1'>
            <tr><th>Column 1</th><th>Column 2</th></tr>"; // Adjust column names based on the query

    // Display results in a table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $column => $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No results found for the selected criteria.";
}

$conn->close();
?>

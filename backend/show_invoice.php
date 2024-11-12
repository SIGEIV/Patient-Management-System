<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection file
include('config.php');  // Ensure this file contains the necessary database connection details

// Check if the form is submitted and the patient_id is entered
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];

    // Validate patient ID
    if (!empty($patient_id)) {
        // SQL query to fetch invoice details based on the patient ID
        $sql = "SELECT id, patient_id, patient_name, consultation_fees, lab_fees, medication_costs, total_amount, created_at FROM invoices WHERE patient_id = ?";
        
        // Prepare the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the patient ID parameter
            $stmt->bind_param("s", $patient_id);
            
            // Execute the statement
            $stmt->execute();
            
            // Bind result variables
            $stmt->bind_result($id, $patient_id, $patient_name, $consultation_fees, $lab_fees, $medication_costs, $total_amount, $created_at);
            
            // Check if any invoice was found for the patient
            if ($stmt->fetch()) {
                echo "<h2>Invoice Details for Patient ID: $patient_id</h2>";
                echo "<table border='1' cellpadding='10' cellspacing='0'>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Patient Name</th>
                            <th>Consultation Fees</th>
                            <th>Lab Fees</th>
                            <th>Medication Costs</th>
                            <th>Total Amount</th>
                            <th>Invoice Date</th>
                        </tr>";
                
                // Display the fetched data in a table
                echo "<tr>
                        <td>$id</td>
                        <td>$patient_name</td>
                        <td>$consultation_fees</td>
                        <td>$lab_fees</td>
                        <td>$medication_costs</td>
                        <td>$total_amount</td>
                        <td>$created_at</td>
                      </tr>";
                echo "</table>";
            } else {
                echo "<p>No invoice found for Patient ID: $patient_id.</p>";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the SQL statement.";
        }
    } else {
        echo "<p>Please enter a valid Patient ID.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}

// Close the database connection
$conn->close();
?>

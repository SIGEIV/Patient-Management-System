<?php
// Include database connection file
include('config.php');  // Ensure this file contains your database connection details

// Check if the form was submitted and if the Patient_ID is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Patient_ID = $_POST['Patient_ID'];

    // Validate Patient_ID
    if (!empty($Patient_ID)) {
        // SQL query to fetch appointment details based on the Patient_ID
        $sql = "SELECT AppointmentID, Patient_ID, patient_name, patient_contact, ryr, date, time, reason_for_visit, doctor FROM Appointments WHERE Patient_ID = ?";
        
        // Prepare the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the Patient_ID parameter
            $stmt->bind_param("s", $Patient_ID);
            
            // Execute the statement
            $stmt->execute();
            
            // Bind result variables
            $stmt->bind_result($AppointmentID, $Patient_ID, $patient_name, $patient_contact, $ryr, $date, $time, $reason_for_visit, $doctor);
            
            // Check if appointment details were found
            if ($stmt->fetch()) {
                echo "<div style='width: 100%; max-width: 800px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-top: 40px; text-align: center;'>";
                echo "<h2>Appointment Details for Patient ID: $Patient_ID</h2>";
                echo "<table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                        <tr style='background-color: #4CAF50; color: white;'>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Appointment ID</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Patient Name</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Contact</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Year</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Date</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Time</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Reason for Visit</th>
                            <th style='padding: 10px; border: 1px solid #ddd;'>Doctor</th>
                        </tr>";
                
                // Display the fetched data in a table row
                echo "<tr style='background-color: #f9f9f9;'>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$AppointmentID</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$patient_name</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$patient_contact</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$ryr</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$date</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$time</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$reason_for_visit</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>$doctor</td>
                      </tr>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div style='width: 100%; max-width: 800px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-top: 40px; text-align: center;'>";
                echo "<p>No appointment found for Patient ID: $Patient_ID.</p>";
                echo "</div>";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the SQL statement.";
        }
    } else {
        echo "<div style='width: 100%; max-width: 800px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-top: 40px; text-align: center;'>";
        echo "<p>Please enter a valid Patient ID.</p>";
        echo "</div>";
    }
} else {
    echo "<div style='width: 100%; max-width: 800px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-top: 40px; text-align: center;'>";
    echo "<p>Invalid request method.</p>";
    echo "</div>";
}

// Close the database connection
$conn->close();
?>

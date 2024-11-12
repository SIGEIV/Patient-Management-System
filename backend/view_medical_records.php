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

// Fetch medical records
$sql = "SELECT * FROM medical_records";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

         .nav {
    display: flex;
    justify-content: center; /* Center the navigation links */
    background-color: #333;
    width: 100%; /* Ensure navigation spans the full width */
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px 0;
    z-index: 10;
}

.nav a {
    color: white;
    padding: 14px 20px;
    text-decoration: none;
    text-align: center;
}

.nav a:hover {
    background-color: #ddd;
    color: black;
}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="admin_dashboard.php">Home</a> <!-- Link to Dashboard Home -->
         <a href="add_patient.html">Add Patient</a> 
         <a href="appointment.html">Appointment</a> 
        <a href="invoice.html">Invoice</a> <!-- Link to Invoices -->
         <a href="generate_reports.html">Report</a>
          <a href="view_medical_records.php">Medical Records</a>
        <a href="admin_login.html">log out</a> <!-- Link to Log Out -->
    </div>

<h2>Medical Records</h2>

<table>
    <tr>
        <th>Record ID</th>
        <th>Patient ID</th>
        <th>Diagnosis</th>
        <th>Treatment</th>
        <th>Prescriptions</th>
        <th>Follow-up Instructions</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['RecordID'] . "</td>
                    <td>" . $row['PatientID'] . "</td>
                    <td>" . $row['Diagnosis'] . "</td>
                    <td>" . $row['Treatment'] . "</td>
                    <td>" . $row['Prescriptions'] . "</td>
                    <td>" . $row['FollowUpInstructions'] . "</td>
                    <td>
                        <form action='update_record.php' method='get' style='display:inline;'>
                            <input type='hidden' name='RecordID' value='" . $row['RecordID'] . "'>
                            <button type='submit'>Update</button>
                        </form>
                        <form action='delete_record.php' method='post' style='display:inline;'>
                            <input type='hidden' name='RecordID' value='" . $row['RecordID'] . "'>
                            <button type='submit'>Delete</button>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
$conn->close();
?>

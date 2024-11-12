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

// Get the RecordID from the URL
$RecordID = $_GET['RecordID'];

// Fetch record details to pre-fill the form
$sql = "SELECT * FROM medical_records WHERE RecordID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $RecordID);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the record based on form input
    $Diagnosis = $_POST['Diagnosis'];
    $Treatment = $_POST['Treatment'];
    $Prescriptions = $_POST['Prescriptions'];
    $FollowUpInstructions = $_POST['FollowUpInstructions'];

    $update_sql = "UPDATE medical_records SET Diagnosis=?, Treatment=?, Prescriptions=?, FollowUpInstructions=? WHERE RecordID=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $Diagnosis, $Treatment, $Prescriptions, $FollowUpInstructions, $RecordID);
    $update_stmt->execute();

    // Redirect after update
    header("Location: view_medical_records.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical Record</title>
</head>
<body>

<h2>Update Medical Record</h2>

<form action="update_record.php?RecordID=<?php echo $RecordID; ?>" method="post">
    <label for="Diagnosis">Diagnosis:</label>
    <input type="text" id="Diagnosis" name="Diagnosis" value="<?php echo $record['Diagnosis']; ?>" required><br><br>

    <label for="Treatment">Treatment:</label>
    <input type="text" id="Treatment" name="Treatment" value="<?php echo $record['Treatment']; ?>" required><br><br>

    <label for="Prescriptions">Prescriptions:</label>
    <input type="text" id="Prescriptions" name="Prescriptions" value="<?php echo $record['Prescriptions']; ?>" required><br><br>

    <label for="FollowUpInstructions">Follow-Up Instructions:</label>
    <input type="text" id="FollowUpInstructions" name="FollowUpInstructions" value="<?php echo $record['FollowUpInstructions']; ?>" required><br><br>

    <input type="submit" value="Update Record">
</form>

</body>
</html>

<?php
$conn->close();
?>

<?php
// Start session
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['adminEmail'];
    $password = $_POST['adminPassword'];

    // Validate credentials
    if ($username === 'admin' && $password === 'admin123') {
        // Set session variables for admin
        $_SESSION['admin_logged_in'] = true;

        // Redirect to admin dashboard
        header('Location: admin_dashboard.php');
        exit();
    } else {
        // Invalid login credentials, redirect back with an error
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='admin_login.html';</script>";
    }
}
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
    $response = mysqli_real_escape_string($conn, $_POST['response']);

    // Update the ticket with the new response
    $update_query = "UPDATE it_issues SET Response = '$response', Updated_At = NOW() WHERE Problem_ID = '$ticket_id'";
    
    if (mysqli_query($conn, $update_query)) {
        // Redirect back to admin dashboard with success message
        header("Location: admin.php?success=Response updated successfully!");
        exit();
    } else {
        // Redirect back with error message
        header("Location: admin.php?error=Failed to update response");
        exit();
    }
}

mysqli_close($conn);
?>
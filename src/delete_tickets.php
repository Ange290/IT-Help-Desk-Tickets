<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['ticket_id'])) {
    $ticket_id = intval($_GET['ticket_id']);
    $username = $_SESSION['username'];

    $check = mysqli_query($conn, "SELECT * FROM it_issues WHERE Problem_ID = $ticket_id  LIMIT 1");

    if ($check && mysqli_num_rows($check) > 0) {
        $ticket = mysqli_fetch_assoc($check);

        if ($ticket['status'] === 'Resolved') {
            $delete_query = "DELETE FROM it_issues WHERE Problem_ID = $ticket_id";
            if (mysqli_query($conn, $delete_query)) {
                $_SESSION['success_message'] = "Ticket deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to delete ticket: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error_message'] = "Only resolved tickets can be deleted!";
        }
    } else {
        $_SESSION['error_message'] = "Ticket not found or does not belong to you!";
    }
}

header("Location: index.php");
exit();
?>
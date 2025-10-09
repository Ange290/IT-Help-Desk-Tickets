<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Delete query
  $delete = "DELETE FROM it_issues WHERE Problem_ID = $id";
  if (mysqli_query($conn, $delete)) {
    echo "<script>alert('Ticket deleted successfully.'); window.location.href='admin.php';</script>";
  } else {
    echo "<script>alert('Error deleting ticket.'); window.location.href='admin.php';</script>";
  }
}

mysqli_close($conn);
?>
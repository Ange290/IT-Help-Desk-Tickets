<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
</head>
<body>
    <div>
  <h1 class="text-3xl font-bold text-center text-lime-500 pt-10">
    IT Help Desk Tickets
  </h1>
    <p class="text-center pt-5 font-bold">Welcome to the IT Help Desk Ticketing System. Please report any IT issues you are experiencing.</p>

  </div>
  <form action="#" method="POST" class="w-full max-w-1/2 mx-auto mt-10 p-6 border border-lime-300 rounded-lg shadow-lg font-bold">
    <label for="title">Problem Title:</label><br>
  <input type="text" id="title" name="title" required class="border border-lime-300 rounded-lg h-12 w-full px-3"><br><br>
    <label for="issue">Describe your issue:</label><br>
  <textarea id="issue" name="issue" rows="4" required class="border border-lime-300 rounded-lg w-full px-3 "></textarea> <br>
    <button type="submit" class="text-white hover:bg-black hover:text-lime-300 bg-lime-700  px-10 py-4 rounded-lg">Submit</button>
  </form>
</body>
</html>
<?php
//Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
  echo"Connected successfully";
}
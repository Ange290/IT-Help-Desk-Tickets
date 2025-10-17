<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role']; 

   
    $check = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username already exists!";
    } else {
        $query = "INSERT INTO users (username, password, role)
                  VALUES ('$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
                header('Location: login.php');
                 $success = "Account created successfully!";
  echo "<script>alert('$success');</script>";
           
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IT Helpdesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="min-h-screen bg-gradient-to-br from-lime-50 via-white to-lime-50 flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-6">
            <div class="bg-lime-500 rounded-full p-3 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
            <p class="text-gray-600 mt-1">IT Helpdesk Support System</p>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php elseif ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none" placeholder="Enter username">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none" placeholder="Enter password">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Role</label>
                <select name="role" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-lime-500 to-lime-600 text-white font-semibold py-3 rounded-lg hover:from-lime-600 hover:to-lime-700 transition">
                Register
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Already have an account? <a href="login.php" class="text-lime-600 font-semibold">Login</a></p>
        </div>
    </div>
</body>
</html>

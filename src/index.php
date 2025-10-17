<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);

$success_message = '';
$error_message = '';

if(isset($_POST["submit"])){
  
  $pb_title = $_POST["Problem_Title"];
  $pb_desc = $_POST["Problem_Desc"];

  $insert = "INSERT INTO it_issues (Problem_Title, Problem_Desc) VALUES ('$pb_title', '$pb_desc')";
  $result = mysqli_query($conn, $insert);
  
  if($result){
    $success_message = "Your ticket has been submitted successfully!";
    echo "<script>alert('$success_message');</script>";
  } else {
    $error_message = "Failed to submit ticket. Please try again.";
    echo"<script>alert('$error_message');</script>";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IT Helpdesk - Submit Ticket</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    .float-animation {
      animation: float 3s ease-in-out infinite;
    }
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .slide-in {
      animation: slideIn 0.5s ease-out;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-lime-50 via-white to-lime-50">
  
  <!-- Header -->
  <header class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="bg-lime-500 rounded-full p-2">
            <i data-feather="settings" class="text-white" style="width: 24px; height: 24px;"></i>
          </div>
          <div>
            <h1 class="text-xl font-bold text-gray-800">IT Helpdesk</h1>
            <p class="text-xs text-gray-500">Support System</p>
          </div>
        </div>
        <a href="admin.php" class="text-gray-600 hover:text-lime-500 transition flex items-center gap-2">
          <i data-feather="settings" style="width: 18px; height: 18px;"></i>
          <span class="text-sm font-medium">Admin</span>
        </a>
      </div>
    </div>
  </header>

  <div class="container mx-auto px-6 py-12">
    
    <!-- Hero Section -->
    <div class="text-center mb-12 slide-in">
   
      <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
        IT Help Desk <span class="text-lime-500">Tickets</span>
      </h1>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Welcome to the IT Help Desk Ticketing System. We're here to help resolve your technical issues quickly and efficiently.
      </p>
    </div>

   

    <!-- Main Form Card -->
    <div class="max-w-2xl mx-auto slide-in">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-lime-500 to-lime-600 px-8 py-6">
          <h2 class="text-2xl font-bold text-white flex items-center gap-3">
            Submit a New Ticket
          </h2>
          <p class="text-lime-100 mt-2">Fill out the form below to report your IT issue</p>
        </div>

        <!-- Form -->
        <form action="" method="POST" class="p-8">
          
        
          <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
            
              Problem Title
            </label>
            <input 
              type="text" 
              id="title" 
              name="Problem_Title" 
              required 
              placeholder=" Unable to access email"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 transition outline-none"
            >
          </div>

         
          <div class="mb-6">
            <label for="issue" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
             
              Describe Your Issue
            </label>
            <textarea 
              id="issue" 
              name="Problem_Desc" 
              rows="6" 
              required 
              placeholder="Please provide detailed information about the problem you're experiencing..."
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 transition outline-none resize-none"
            ></textarea>
          
          </div>

       

          <div class="flex gap-4">
            <button 
              type="submit" 
              name="submit"
              class="flex-1  bg-gradient-to-r from-lime-500 to-lime-600 text-white font-semibold py-4 px-6 rounded-lg hover:from-lime-600 hover:to-lime-700 transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
            >
              
              Submit Ticket
            </button>
            <button 
              type="reset"
              class="px-6 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition"
            >
              Reset
            </button>
          </div>

        </form>
      </div>

     
      <div class="mt-8 grid md:grid-cols-3 gap-4">    
          
        </div>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-16">
    <div class="container mx-auto px-6 text-center">
      <p class="text-gray-400">© 2025 IT Helpdesk System. Need urgent help? Call: <span class="text-lime-400 font-semibold">+250 123 456 789</span></p>
    </div>
  </footer>

  <script>
    feather.replace();
    
    // Auto-hide success/error messages after 5 seconds
    setTimeout(() => {
      const alerts = document.querySelectorAll('.slide-in > div');
      alerts.forEach(alert => {
        if(alert.classList.contains('bg-green-50') || alert.classList.contains('bg-red-50')) {
          alert.style.transition = 'opacity 0.5s';
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }
      });
    }, 5000);
  </script>

</body>
</html>
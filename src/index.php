<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
?>

<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'it_helpdesk_tickets';
$conn = new mysqli($host, $user, $password, $dbname);

$success_message = '';
$error_message = '';

if (isset($_POST["submit"])) {
  $pb_title = mysqli_real_escape_string($conn, $_POST["Problem_Title"]);
  $pb_desc = mysqli_real_escape_string($conn, $_POST["Problem_Desc"]);

  $insert = "INSERT INTO it_issues (Problem_Title, Problem_Desc, Status) VALUES ('$pb_title', '$pb_desc', 'Pending')";
  $result = mysqli_query($conn, $insert);

  if ($result) {
    $success_message = "Your ticket has been submitted successfully!";
  } else {
    $error_message = "Failed to submit ticket. Please try again.";
  }
}

// Fetch user's tickets with responses
$fetch_tickets = mysqli_query($conn, "SELECT * FROM it_issues ORDER BY Problem_ID DESC");
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

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-20px);
      }
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
        <a href="logout.php"
          class="bg-lime-500 hover:bg-lime-600 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition">
          <i data-feather="log-out" style="width: 18px; height: 18px;"></i>
          Logout
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
        Welcome to the IT Help Desk Ticketing System. We're here to help resolve your technical issues quickly and
        efficiently.
      </p>
    </div>

    <!-- Success/Error Messages -->
    <?php if ($success_message): ?>
      <div class="max-w-2xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        <p><?php echo $success_message; ?></p>
      </div>
    <?php endif; ?>

    <!-- Tabs Navigation -->
    <div class="max-w-2xl mx-auto mb-8">
      <div class="flex gap-4 border-b border-gray-200">
        <button onclick="showTab('submit')" id="submitTab"
          class="px-4 py-3 font-semibold text-lime-600 border-b-2 border-lime-600 transition">
          Submit Ticket
        </button>
        <button onclick="showTab('myTickets')" id="ticketsTab"
          class="px-4 py-3 font-semibold text-gray-600 border-b-2 border-transparent hover:border-gray-300 transition">
          My Tickets
        </button>
      </div>
    </div>

    <!-- Submit Ticket Tab -->
    <div id="submitTab_content" class="max-w-2xl mx-auto slide-in">
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
            <label for="title" class="block text-gray-700 font-semibold mb-2">
              Problem Title
            </label>
            <input type="text" id="title" name="Problem_Title" required placeholder="ex: Unable to access email"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 transition outline-none">
          </div>

          <div class="mb-6">
            <label for="issue" class="block text-gray-700 font-semibold mb-2">
              Describe Your Issue
            </label>
            <textarea id="issue" name="Problem_Desc" rows="6" required
              placeholder="Please provide detailed information about the problem you're experiencing..."
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 transition outline-none resize-none"></textarea>
          </div>

          <div class="flex gap-4">
            <button type="submit" name="submit"
              class="flex-1 bg-gradient-to-r from-lime-500 to-lime-600 text-white font-semibold py-4 px-6 rounded-lg hover:from-lime-600 hover:to-lime-700 transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
              Submit Ticket
            </button>
            <button type="reset"
              class="px-6 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
              Reset
            </button>
          </div>

        </form>
      </div>
    </div>

    <!-- My Tickets Tab -->
    <div id="ticketsTab_content" class="hidden max-w-4xl mx-auto">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">


        <div class="bg-gradient-to-r from-lime-500 to-lime-600 px-8 py-6">
          <h2 class="text-2xl font-bold text-white">Your Submitted Tickets</h2>
          <p class="text-lime-100 mt-2">View all your tickets and responses from the IT team</p>
        </div>

        <!-- Tickets List -->
        <div class="p-6">
          <?php
          if (mysqli_num_rows($fetch_tickets) > 0) {
            while ($ticket = mysqli_fetch_assoc($fetch_tickets)) {
              $status = isset($ticket["Status"]) ? $ticket["Status"] : "Pending";
              $statusColor = $status === "Resolved" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800";
              ?>
              <div class="mb-6 border-2 border-gray-200 rounded-lg p-6 hover:border-lime-500 transition">

                <div class="flex items-center justify-between mb-4">
                  <div>
                    <h3 class="text-xl font-bold text-gray-800">
                      <?php echo htmlspecialchars($ticket["Problem_ID"]); ?> -
                      <?php echo htmlspecialchars($ticket["Problem_Title"]); ?>
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                      Submitted:
                      <?php echo isset($ticket["Created_At"]) ? htmlspecialchars($ticket["Created_At"]) : "N/A"; ?>
                    </p>
                  </div>
                  <span
                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full <?php echo $statusColor; ?>">
                    <?php echo $status; ?>
                  </span>
                  <?php if ($ticket['status'] === 'Resolved'): ?>
                    <a href="delete_tickets.php?ticket_id=<?= $ticket['Problem_ID'] ?>"
                      onclick="return confirm('Are you sure you want to delete this ticket?');"
                      class="px-3 py-1 text-red-500 inline-flex text-sm leading-5 font-semibold rounded-full">
                      Delete
                    </a>
                  <?php endif; ?>



                </div>

                <!-- Issue Description -->
                <div class="mb-4">
                  <h4 class="font-semibold text-gray-700 mb-2">Your Issue:</h4>
                  <p class="text-gray-600 bg-gray-50 p-3 rounded">
                    <?php echo htmlspecialchars($ticket["Problem_Desc"]); ?>
                  </p>
                </div>

                <!-- Admin Response -->
                <?php if (isset($ticket["Response"]) && !empty($ticket["Response"])): ?>
                  <div class="bg-lime-50 border-2 border-lime-200 rounded-lg p-4">
                    <h4 class="font-semibold text-lime-800 mb-2 flex items-center gap-2">
                      <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
                      Response from IT Team:
                    </h4>
                    <p class="text-gray-700">
                      <?php echo htmlspecialchars($ticket["Response"]); ?>
                    </p>
                  </div>
                <?php else: ?>
                  <div class="bg-lime-500 border-2 border-blue-200 rounded-lg p-4">
                    <p class="text-white flex items-center gap-2">
                      <i data-feather="clock" style="width: 20px; height: 20px;"></i>
                      Waiting for IT team response...
                    </p>
                  </div>
                <?php endif; ?>

              </div>
              <?php
            }
          } else {
            ?>
            <div class="text-center py-12">
              <i data-feather="inbox" class="mx-auto text-gray-400" style="width: 48px; height: 48px;"></i>
              <p class="mt-4 text-gray-600 font-medium">No tickets found</p>
              <p class="text-gray-500 text-sm mt-1">Submit your first ticket to get started</p>
            </div>
            <?php
          }
          ?>
        </div>

      </div>
    </div>

  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-16">
    <div class="container mx-auto px-6 text-center">
      <p class="text-gray-400">© 2025 IT Helpdesk System. Need urgent help? Call: <span
          class="text-lime-400 font-semibold">+250 123 456 789</span></p>
    </div>
  </footer>

  <script>
    feather.replace();

    function showTab(tabName) {
      // Hide all tabs
      document.getElementById('submitTab_content').classList.add('hidden');
      document.getElementById('ticketsTab_content').classList.add('hidden');

      // Remove active state from all tabs
      document.getElementById('submitTab').classList.remove('text-lime-600', 'border-lime-600');
      document.getElementById('ticketsTab').classList.remove('text-lime-600', 'border-lime-600');

      document.getElementById('submitTab').classList.add('text-gray-600', 'border-transparent');
      document.getElementById('ticketsTab').classList.add('text-gray-600', 'border-transparent');

      // Show selected tab
      if (tabName === 'submit') {
        document.getElementById('submitTab_content').classList.remove('hidden');
        document.getElementById('submitTab').classList.remove('text-gray-600', 'border-transparent');
        document.getElementById('submitTab').classList.add('text-lime-600', 'border-lime-600');
      } else if (tabName === 'myTickets') {
        document.getElementById('ticketsTab_content').classList.remove('hidden');
        document.getElementById('ticketsTab').classList.remove('text-gray-600', 'border-transparent');
        document.getElementById('ticketsTab').classList.add('text-lime-600', 'border-lime-600');
      }
    }
  </script>

</body>

</html>
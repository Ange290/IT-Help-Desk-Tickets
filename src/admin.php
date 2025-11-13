<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IT Helpdesk - Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    .table-container::-webkit-scrollbar {
      height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
      background: #d9f99d;
      border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
      background: #84cc16;
      border-radius: 10px;
    }

    .modal {
      display: none;
    }

    .modal.active {
      display: flex;
    }
  </style>
</head>

<body class="min-h-screen bg-gray-50">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="bg-gradient-to-b from-lime-500 to-lime-600 w-64 p-6 flex flex-col shadow-xl">
      <div class="mb-8">
        <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
          <i data-feather="settings" class="text-lime-600" style="width: 32px; height: 32px;"></i>
        </div>
        <h1 class="text-2xl font-bold text-white text-center">
          Admin Dashboard
        </h1>
        <p class="text-lime-100 text-center text-sm mt-2">IT Helpdesk Manager</p>
      </div>

      <nav class="flex-1">
        <ul class="space-y-2">
          <li>
            <a href="#"
              class="flex items-center gap-3 px-4 py-3 text-white bg-lime-600 rounded-lg hover:bg-lime-700 transition">
              <i data-feather="list" style="width: 20px; height: 20px;"></i>
              <span>All Tickets</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="mt-auto pt-6 border-t border-lime-400">
        <a href="logout.php"
          class="flex items-center gap-3 px-4 py-3 text-white hover:bg-lime-600 rounded-lg transition">
          <i data-feather="log-out" style="width: 20px; height: 20px;"></i>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 bg-gray-50 p-8">
      <!-- Header -->
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
          IT Helpdesk Tickets
        </h2>
        <p class="text-gray-600">Manage and track all support requests</p>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">All Tickets</h3>
          </div>
        </div>

        <div class="overflow-x-auto table-container">
          <?php
          // Database connection
          $host = 'localhost';
          $user = 'root';
          $pass = '';
          $dbname = 'it_helpdesk_tickets';

          $conn = new mysqli($host, $user, $pass, $dbname);

          if ($conn->connect_error) {
            echo "<div class='p-6'>";
            echo "<div class='bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg'>";
            echo "<p class='font-semibold'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>";
            echo "</div>";
            echo "</div>";
          } else {
            $fetch = mysqli_query($conn, "SELECT * FROM it_issues ORDER BY Problem_ID DESC");

            if (mysqli_num_rows($fetch) > 0) {
              echo "<table class='min-w-full divide-y divide-gray-200'>";
              echo "<thead class='bg-gray-50'>";
              echo "<tr>
                      <th class='px-6 py-3 text-left text-xs font-bold text-lime-500 uppercase tracking-wider'>ID</th>
                      <th class='px-6 py-3 text-left text-xs font-bold text-lime-500 uppercase tracking-wider'>Title</th>
                      <th class='px-6 py-3 text-left text-xs font-bold text-lime-500 uppercase tracking-wider'>Description</th>
                      <th class='px-6 py-3 text-left text-xs font-bold text-lime-500 uppercase tracking-wider'>Status</th>
                      <th class='px-6 py-3 text-center text-xs font-bold text-lime-500 uppercase tracking-wider'>Actions</th>
                    </tr>";
              echo "</thead>";
              echo "<tbody class='bg-white divide-y divide-gray-200'>";

              while ($row = mysqli_fetch_assoc($fetch)) {
                $status = isset($row["Response"]) && !empty($row["Response"]) ? "Resolved" : "Pending";
                $statusColor = $status === "Resolved" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800";
                $ticketId = htmlspecialchars($row["Problem_ID"]);
                $ticketTitle = htmlspecialchars($row["Problem_Title"]);
                $ticketResponse = isset($row["Response"]) ? htmlspecialchars($row["Response"]) : "";
                
                echo "<tr class='hover:bg-gray-50 transition'>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>
                        <span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-lime-100 text-lime-800'>
                          " . $ticketId . "
                        </span>
                      </td>";
                echo "<td class='px-6 py-4'>
                        <div class='text-sm font-medium text-gray-900'>" . $ticketTitle . "</div>
                      </td>";
                echo "<td class='px-6 py-4'>
                        <div class='text-sm text-gray-600'>" . htmlspecialchars(substr($row["Problem_Desc"], 0, 50)) . "...</div>
                      </td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>
                        <span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full $statusColor'>
                          $status
                        </span>
                      </td>";

                // Action buttons
                $hasResponse = isset($row["Response"]) && !empty($row["Response"]);
                echo "<td class='px-6 py-4 whitespace-nowrap text-center'>
                        <div class='flex items-center justify-center gap-3'>";
                
                if ($hasResponse) {
                  $encodedResponse = json_encode($ticketResponse);
                  echo "<button onclick='openEditModal(\"" . $ticketId . "\", \"" . addslashes($ticketTitle) . "\", " . $encodedResponse . ")'
                       class='text-lime-600 hover:text-lime-800 transition font-medium' 
                       title='Edit Response'>
                        Edit
                      </button>";
                } else {
                  echo "<button onclick=\"openResponseModal('" . $ticketId . "', '" . addslashes($ticketTitle) . "')\"
                       class='text-blue-600 hover:text-blue-800 transition font-medium' 
                       title='Send Response'>
                        Response
                      </button>";
                }
                
                echo "<a href='delete.php?id=" . $ticketId . "' 
                       class='text-red-600 hover:text-red-800 transition font-medium' 
                       onclick='return confirm(\"Are you sure you want to delete this ticket?\")' 
                       title='Delete'>
                        Delete
                      </a>
                    </div>
                  </td>";
                echo "</tr>";
              }

              echo "</tbody>";
              echo "</table>";
            } else {
              echo "<div class='p-12 text-center'>";
              echo "<i data-feather='inbox' class='mx-auto text-gray-400' style='width: 48px; height: 48px;'></i>";
              echo "<p class='mt-4 text-gray-600 font-medium'>No tickets found</p>";
              echo "<p class='text-gray-500 text-sm mt-1'>Create your first ticket to get started</p>";
              echo "</div>";
            }

            mysqli_close($conn);
          }
          ?>
        </div>
      </div>

    </main>

  </div>

  <!-- Response Modal (Send New Response) -->
  <div id="responseModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      
      <!-- Modal Header -->
      <div class="bg-gradient-to-r from-lime-500 to-lime-600 px-6 py-4">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Send Response</h3>
          <button onclick="closeResponseModal()" class="text-white hover:text-lime-100">
            <i data-feather="x" style="width: 24px; height: 24px;"></i>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <form id="responseForm" action="send_response.php" method="POST" class="p-6">
        
        <input type="hidden" id="ticketId" name="ticket_id">

        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2">Issue Title</label>
          <input 
            type="text" 
            id="issueTitle" 
            readonly
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-50 text-gray-600"
          >
        </div>

        <div class="mb-6">
          <label for="responseText" class="block text-gray-700 font-semibold mb-2">Your Response</label>
          <textarea 
            id="responseText" 
            name="response" 
            rows="6" 
            required 
            placeholder="Enter your response to the user..."
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-lime-500 focus:ring-2 focus:ring-lime-200 transition outline-none resize-none"
          ></textarea>
        </div>

        <div class="flex gap-3">
          <button 
            type="submit"
            class="flex-1 bg-gradient-to-r from-lime-500 to-lime-600 text-white font-semibold py-3 rounded-lg hover:from-lime-600 hover:to-lime-700 transition"
          >
            Send Response
          </button>
          <button 
            type="button"
            onclick="closeResponseModal()"
            class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-50 transition"
          >
            Cancel
          </button>
        </div>

      </form>

    </div>
  </div>

  <!-- Edit Response Modal -->
  <div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      
      <!-- Modal Header -->
      <div class="bg-gradient-to-r from-lime-500 to-lime-600 px-6 py-4">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Edit Response</h3>
          <button onclick="closeEditModal()" class="text-white hover:text-purple-100">
            <i data-feather="x" style="width: 24px; height: 24px;"></i>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <form id="editForm" action="update_response.php" method="POST" class="p-6">
        
        <input type="hidden" id="editTicketId" name="ticket_id">

        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2">Issue Title</label>
          <input 
            type="text" 
            id="editIssueTitle" 
            readonly
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-50 text-gray-600"
          >
        </div>

        <div class="mb-6">
          <label for="editResponseText" class="block text-lime-700 font-semibold mb-2">Update Response</label>
          <textarea 
            id="editResponseText" 
            name="response" 
            rows="6" 
            required 
            placeholder="Update your response..."
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition outline-none resize-none"
          ></textarea>
        </div>

        <div class="flex gap-3">
          <button 
            type="submit"
            class="flex-1 bg-gradient-to-r from-lime-500 to-lime-600 text-white font-semibold py-3 rounded-lg hover:from-purple-600 hover:to-purple-700 transition"
          >
            Update Response
          </button>
          <button 
            type="button"
            onclick="closeEditModal()"
            class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-50 transition"
          >
            Cancel
          </button>
        </div>

      </form>

    </div>
  </div>

  <script>
    feather.replace();

    function openResponseModal(ticketId, issueTitle) {
      document.getElementById('ticketId').value = ticketId;
      document.getElementById('issueTitle').value = issueTitle;
      document.getElementById('responseText').value = '';
      document.getElementById('responseModal').classList.add('active');
    }

    function closeResponseModal() {
      document.getElementById('responseModal').classList.remove('active');
    }

    function openEditModal(ticketId, issueTitle, currentResponse) {
      document.getElementById('editTicketId').value = ticketId;
      document.getElementById('editIssueTitle').value = issueTitle;
      document.getElementById('editResponseText').value = currentResponse;
      document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.remove('active');
    }

    // Close modals when clicking outside
    document.getElementById('responseModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeResponseModal();
      }
    });

    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditModal();
      }
    });
  </script>

</body>

</html>
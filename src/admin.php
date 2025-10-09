<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IT Helpdesk - Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    /* Custom scrollbar for table */
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
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-white bg-lime-600 rounded-lg hover:bg-lime-700 transition">
              <i data-feather="list" style="width: 20px; height: 20px;"></i>
              <span>All Tickets</span>
            </a>
          </li>
        
        </ul>
      </nav>

      <div class="mt-auto pt-6 border-t border-lime-400">
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-lime-600 rounded-lg transition">
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
            <button class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
              <i data-feather="plus" style="width: 18px; height: 18px;"></i>
              <span>Add New</span>
            </button>
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
                      <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>ID</th>
                      <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Title</th>
                      <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Description</th>
                      <th class='px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>Actions</th>
                    </tr>";
              echo "</thead>";
              echo "<tbody class='bg-white divide-y divide-gray-200'>";
              
              while ($row = mysqli_fetch_assoc($fetch)) {
                echo "<tr class='hover:bg-gray-50 transition'>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>
                        <span class='px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-lime-100 text-lime-800'>
                          #" . htmlspecialchars($row["Problem_ID"]) . "
                        </span>
                      </td>";
                echo "<td class='px-6 py-4'>
                        <div class='text-sm font-medium text-gray-900'>" . htmlspecialchars($row["Problem_Title"]) . "</div>
                      </td>";
                echo "<td class='px-6 py-4'>
                        <div class='text-sm text-gray-600'>" . htmlspecialchars($row["Problem_Desc"]) . "</div>
                      </td>";
                
                // Action buttons
                echo "<td class='px-6 py-4 whitespace-nowrap text-center'>
                        <div class='flex items-center justify-center gap-3'>
                          <a href='edit.php?id=" . $row["Problem_ID"] . "' 
                             class='text-blue-600 hover:text-blue-800 transition' 
                             title='Edit'>
                            <i data-feather='edit-2' style='width: 18px; height: 18px;'></i>
                          </a>
                          <a href='delete.php?id=" . $row["Problem_ID"] . "' 
                             class='text-red-600 hover:text-red-800 transition' 
                             onclick='return confirm(\"Are you sure you want to delete this ticket?\")' 
                             title='Delete'>
                            <i data-feather='trash-2' style='width: 18px; height: 18px;'></i>
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

  <script>
    feather.replace(); // Initialize Feather icons
  </script>
</body>

</html>
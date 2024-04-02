<?php
        // Database connection
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'orphan_care';

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);


        session_start();
        if (!isset($_SESSION['trustid'])) {
          header("Location: ../tlogin/tlogin.php");
          exit();

}

$trustid = $_SESSION['trustid'];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to select all images from the table
        $sql = "SELECT * FROM form where trustid=$trustid";
        $result = $conn->query($sql);
        echo ("<script>alert($trustid)</script>");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Retrieve the data from the database
                $name22 = $row['full_name']; // Corrected column name
                $reason = $row['reason']; // Corrected column name
                $for = $row['mail'];
                $phone = $row['phone'];
                $id = $row['id'];


              }
            
            } else {
                echo 'No images found in the table.';
            }
    
            $conn->close();
            ?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New customer list - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="thomeg.css" />
    <link rel="stylesheet" href="thomes.css" />
    <style type="text/css">
        body {
            margin-top: 20px;
            background: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .avatar.sm {
            width: 2.25rem;
            height: 2.25rem;
            font-size: .818125rem;
        }

        .table-nowrap .table td,
        .table-nowrap .table th {
            white-space: nowrap;
        }

        .table>:not(caption)>*>* {
            padding: 0.75rem 1.25rem;
            border-bottom-width: 1px;
        }

        table th {
            font-weight: 600;
            background-color: #eeecfd !important;
        }

        .menu {
        position: fixed;
        left: 20px;
        top: 20px;
        z-index: 2;
        cursor: pointer;
      }

      /* Styles for the sliding menu container */
      .menu-container {
        position: fixed;
        width: 250px;
        height: 100%;
        background-color: #fff; /* Background color for the menu */
        left: -250px; /* Initially hide the menu */
        top: 0;
        transition: left 0.3s ease-in-out;
        z-index: 1; /* Place the menu below other elements */
      }

      /* Styles for the menu options */
      .menu-options {
        padding: 20px;
      }

      /* Styles for the menu options list */
      .menu-options ul {
        list-style-type: none;
        padding: 0;
      }

      .menu-options ul li {
        margin-bottom: 10px;
      }

      .menu-options ul li a {
        text-decoration: none;
        color: #333;
      }
    </style>
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus icon'></i>
        <div class="logo_name">award</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>


    <li>
     <a href="home.php">
         <i class='bx bx-home' ></i>
         <span class="links_name">Home</span>
       </a>
       <span class="tooltip">Home</span>
     </li>
    
      <li>
      <a href="../Profile/pro.php">
          <i class='bx bx-user' ></i>
          <span class="links_name">User</span>
        </a>
        <span class="tooltip">User</span>
      </li>

      <li>
  <div class="notification-container">
  <a href="../notification/noti.php">
      <i class='bx bx-bell' ></i>
      <span class="links_name">Notification</span>
      <!-- <span class="notification-badge" id="notificationBadge" style="position: relative;left: -87px;top: -10px;color: red;">4</span> -->
    </a>
  </div>

       <span class="tooltip">Notis</span>
     </li>
      <li>
        <a href="../cat/cat.html">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">category</span>
        </a>
         <span class="tooltip">Category</span>
      </li>
     <li>
       <a href="../feedback/feedback.php">
         <i class='bx bx-star' ></i>
         <span class="links_name">Feedback</span>
       </a>
       <span class="tooltip">Review</span>
     </li>
     <li>
       <a href="../donation/donate.php">
         <i class='bx bx-rupee' ></i>
         <span class="links_name">Donations</span>
       </a>
       <span class="tooltip">History</span>
     </li>
    
 
     <li class="profile">
      <a href="../start/start.php">
         <i class='bx bx-log-out' id="log_out" ></i>
    </a>
     </li>
    </ul>
  </div>
  <section class="home-section">

    <div class="home">
        <div class="div">
        
          <img
            class="menu"
            src="https://c.animaapp.com/r5lgXqXh/img/icons8-menu-50-1@2x.png"
            onclick="toggleMenu()"
          />



<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="container">
<div class="row">
<div class="col-12 mb-3 mb-lg-5">
<div class="overflow-hidden card table-nowrap table-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">New customers</h5>
        <a href="#!" class="btn btn-light btn-sm">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="small text-uppercase bg-body text-muted">
                <tr>
                    <th>Name</th>
                    <th style="left: 10px;position: relative;">Status</th>
                    <th>Mail</th>
                    <th>Phone Number</th>
                    <th>Created Date</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
                // Display data from the 'accepted' table
                while ($row = $result_accepted->fetch_assoc()) {
                    $name22 = $row['first_name'];
                    $trust = $row['mail'];
                    $dob = $row['dob'];
                    $phone = $row['phone'];
            ?>

                <tr class="align-middle">
                    <td>
                    <a href="../tform/form.php?userid=<?= $_SESSION['userid'] ?>" class="user-link">
                        <div class="h6 mb-0 lh-1"><?= $name22 ?></div>
                        </a>
                        </div>
                        </div>
                    </td>
                    <td>
<a class="__cf_email__">
<div style="background-color: green; border-radius: 40px; color: white; padding: 2px;">
<p style="left: 43px; top: 7px; position: relative; color: white; padding: 2px;">Accepted</p>


</div>
</a>
</td>
<td><span class="d-inline-block align-middle"><?= $trust ?></span></td>
<td><span><?= $phone ?></span></td>
<td>
<p><span class="info-label">Date :</span> <?= $dob ?></p>
</td>
<td class="text-end">
<div class="drodown">
    <a data-bs-toggle="dropdown" href="#!"class="btn p-1" aria-expanded="false">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end" style>
        <a href="#!" class="dropdown-item">View Details</a>
        <a href="#!" class="dropdown-item">Delete user</a>
    </div>
</div>
</td>
</tr>


        </div>
    </td>
</tr>

<?php
    }
?>

<?php
    if ($result_accepted->num_rows == 0 && $result_declined->num_rows == 0) {
        echo '<tr><td colspan="6">No data available</td></tr>';
    }
?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

<script data-cfasync="false"
src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script type="text/javascript"> -->
<script>
    // Function to filter the table data
    function filterTable() {
        const filterText = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.querySelectorAll('.overlap-group');

        tableRows.forEach((row) => {
            const cardTitle = row.querySelector('.eve_selector').textContent.toLowerCase();

            if (cardTitle.includes(filterText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        }
</script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>

document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const menuBtn = document.querySelector("#btn");
  const searchBtn = document.querySelector("#searchBtn");
  const trustnameSearch = document.querySelector("#trustnameSearch");
  const notificationBadge = document.querySelector("#notificationBadge"); // Add this line

  menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    menuBtnChange();
  });

  searchBtn.addEventListener("click", () => {
    const searchTerm = trustnameSearch.value.trim();
    if (searchTerm !== "") {
      fetch(`../search/search.php?trustname=${searchTerm}`)
        .then((response) => response.text())
        .then((data) => {
          const group = document.querySelector(".group");
          group.innerHTML += data;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    }
  });

  function getNotificationCount() {
  fetch("notification.php") // Check the URL
    .then((response) => response.json()) // Parse the JSON response
    .then((data) => {
      if (data && data.count !== undefined) {
        // Check if the "count" field exists in the response
        const notificationCount = data.count;
        notificationBadge.textContent = notificationCount;
      } else {
        console.error("Invalid response from server");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

  // Call the getNotificationCount function to initially load the count
  getNotificationCount();

  // Rest of your code...
});

// ...
  </script>
  

<script>
    function toggleMenu() {
      const menuContainer = document.querySelector(".menu-container");
      if (menuContainer.style.left === "-250px" || menuContainer.style.left === "") {
        menuContainer.style.left = "0";
      } else {
        menuContainer.style.left = "-250px";
      }
    }
  </script>
</script>
</body>
</html>

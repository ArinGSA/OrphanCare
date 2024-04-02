<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Responsive Sidebar Menu  | CodingLab </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tdonateg.css" />
    <link rel="stylesheet" href="tdonates.css" />
    <link rel="stylesheet" href="tdonatem.css" />
    <style>
    .group {
      height: 1080px; /* Adjust the height as needed */
      overflow-y: scroll;
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
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus icon'></i>
        <div class="logo_name">CodingLab</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
    
      <li>
        <a href="../tprofile/tpro.php">
          <i class='bx bx-user' ></i>
          <span class="links_name">User</span>
        </a>
        <span class="tooltip">User</span>
      </li>
      <li>
      <a href="../tnotification/noti.php">
         <i class='bx bx-bell' ></i>
         <span class="links_name">Notification</span>
       </a>
       <span class="tooltip">Notis</span>
     </li>
      <li>
        <a href="../../cat/cat.html">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">category</span>
        </a>
         <span class="tooltip">Category</span>
      </li>
     <li>
       <a href="#">
         <i class='bx bx-star' ></i>
         <span class="links_name">Feedback</span>
       </a>
       <span class="tooltip">Review</span>
     </li>
     <li>
       <a href="#">
         <i class='bx bx-rupee' ></i>
         <span class="links_name">Donations</span>
       </a>
       <span class="tooltip">History</span>
     </li>
    

     <li class="profile">
      <a href="../../start/start.html">
         <i class='bx bx-log-out' id="log_out" ></i>
    </a>
     </li>
    </ul>
  </div>
  <section class="home-section">

    <div class="home">
        <div class="div">
          <!-- Menu Icon -->
          <img
            class="menu"
            src="https://c.animaapp.com/r5lgXqXh/img/icons8-menu-50-1@2x.png"
            onclick="toggleMenu()"
          />

        
            <div class="group">

            <?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$usernameSearchTerm = $_GET['username'];

$sql = "SELECT * FROM donation WHERE username LIKE '%$usernameSearchTerm%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $name22 = $row['username'];
        $reason = $row['amount'];
        $for = $row['date'];
        $phone = $row['payment_id'];
        
        $capitalizedUsername = ucfirst($row['username']);


        echo '<div class="emp-home-page">';
        echo '<div class="overlap-group">';
        echo '<div class="group-wrapper">';
        echo '<div class="div-wrapper">';
        echo '<div class="group-2">';
        echo '<div class="custom-info1">';
    
       
        
        echo '<span class="out1">' . $capitalizedUsername . '</h2>';
        echo '<p><span class="info-label2">Amount:</span> <span class="out2"> Rs.' . $row['amount'] . '</p>';
        echo '<p><span class="info-label3">Date:</span> <span class="out3">' . $row['date'] . '</span></p>';
        echo '<p><span class="info-label4">Ref ID:</span> <span class="out4">' . $row['payment_id'] . '</p>';
        echo '</div>';
        echo '</a>';
    
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
        } else {
            echo 'No results found.';
        }

        $conn->close();
        ?>
          <div class="rectangle"></div>
          <div class="overlap-wrapper">
            <div class="overlap">
              <div class="text-wrapper-5">🔎</div>
              <input type="text" id="usernameSearch" style="border:none;font-size: 15px;position: relative;left: 80px;background-color: #fff;width: 300px;height: 60px;" placeholder="Search by username">
             
            </div>
          </div>
        </div>
      </div>
  </section>
  <script>


document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const menuBtn = document.querySelector("#btn");
  const searchBtn = document.querySelector("#searchBtn"); 
  const usernameSearch = document.querySelector("#usernameSearch");

  menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    menuBtnChange();
  });

  searchBtn.addEventListener("click", () => {
    const searchTerm = usernameSearch.value.trim();
    if (searchTerm !== "") {
 
      fetch(`../search/search.php?username=${searchTerm}`)
        .then((response) => response.text())
        .then((data) => {
 
          const group = document.querySelector(".group");
          group.innerHTML = data;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    }
  });

});


  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();
  });

  searchBtn.addEventListener("click", ()=>{ 
    sidebar.classList.toggle("open");
    menuBtnChange(); 
  });

  
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
   }
  }
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
</body>
</html>
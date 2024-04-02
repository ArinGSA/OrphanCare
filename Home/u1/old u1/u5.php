<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Dashboard</title>
    <link rel="stylesheet" href="../../hc.css">
    <link rel="stylesheet" href="u4.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 

    <!-- <style>
    .records table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .thead {
        background-color: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .records table th,
    .records table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #dee2e6;
    }

    .records table tbody tr {
        border-bottom: 1px solid #dee2e8;
    }

    .records table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    /* Add this style to fix the scrolling issue */
    .main-content {
        overflow: hidden;
    }
</style> -->

<style>

body {
    color: #797979;
    background: #f1f2f7;
    font-family: 'Open Sans', sans-serif;
    padding: 0px !important;
    margin: 0px !important;
    font-size: 19px;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
    overflow-x: hidden; 
    }

    #noResults {
        display: none;
        text-align: center;
        margin-top: 20px;
        color: red;
    }

    .card-progress small 
    {
    color: #777;
    font-size: 1.3rem;
    font-weight: 600;
    }

    .card-head h2 
    {
    color: #333;
    font-size: 2.3rem;
    font-weight: 500;
    }

    .value-box {
    left: 890px;
    top: -331px;
    width: 215px;
    height: 459px;
    position: relative;
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    





    .value-heading {
        background: #34425a;
    color: #fff;
    height: 102px;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    padding: 30px;
    text-align: center;
}

.btn {
          background-color: #8984e2;
          border-radius: 10px;
          color: black;
          text-align: center;
          font-size: 16px;
          transition: 0.3s;
          position: relative;
        }

        .btn:hover {
            background-color: #6e65cd;
            color: white;
        }
    </style>

</head>

<body>

<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Change login.php to your actual login page
    exit();
}

$userid = $_SESSION['userid'];

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user profile information
$sql = "SELECT * FROM userinfo WHERE userid = $userid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Fetching specific columns
    $row6 = ['username' => $row['username']];
    $row10 = ['job' => $row['job']];
    $row7 = ['pic' => $row['pic']];
} else {
    // If no rows are found, provide default values
    $row6 = ['username' => ''];
    $row10 = ['job' => ''];
    $row7 = ['pic' => ''];
}

$sql2 = "SELECT COUNT(*) AS notiNum FROM accepted WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row11 = ($result2) ? $result2->fetch_assoc() : ['notiNum' => 0];

$sql2 = "SELECT COUNT(*) AS rejNum FROM declined WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row12 = ($result2) ? $result2->fetch_assoc() : ['rejNum' => 0];


?>

<input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="side-header" style="top: -2px;width: 165px;left: -2px;position: relative;">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
            <div class="profile-img bg-img" style="background-image: url('../../trust/tsignup/upload/<?php echo $row7['pic']; ?>')"></div>
            <h4 style="margin-bottom: -5px;"><?php echo strtoupper($row6['username']); ?></h4>
            <small><?php echo strtoupper($row10['job']); ?></small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="../home.php" class="active">
                        <span class="las la-home" style="font-size: 27px;"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../../Profile/pro.php" class="btn">
                        <span class="las la-user" style="font-size: 27px;"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                <a href="../../notification/noti.php" class="btn">
                        <span class="las la-bell" style="font-size: 27px;"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <li>
                    <a href="../../cat/cc.php" class="btn">
                        <span class="las la-box" style="font-size: 27px;"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="../../feedback/feedback.php" class="btn">
                        <span class="las la-star" style="font-size: 27px;"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                <a href="../../donation/donate.php" class="btn">
                        <span class="las la-rupee-sign" style="font-size: 27px;"></span>
                        <small>Transaction</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars" style="font-size: 22px;"></span>
            </label>

            <div class="header-menu">

            <div class="notify-icon">
                <span class="las la-bell" style="font-size: 22px;"></span>
                    <span class="notify"><?php echo $row11['notiNum']; ?></span>
                </div>

                <div class="notify-icon">
                    
                    <span class="las la-bell" style=" background-color: red; border-radius: 50%; font-size: 22px; padding: 2px;"></span>
                    <span class="notify"><?php echo $row12['rejNum']; ?></span>
                </div>

                <div class="user">
                    <div class="bg-img" style="background-image: url('../../trust/tsignup/upload/<?php echo $row['pic']; ?>')"></div>
                    <span class="las la-sign-out-alt"></span>
                    <a href="../../start/start.php">
                    <span style="font-size: 13px;">Logout</span>
                </a>
                </div>
            </div>
        </div>
    

    <?php
    $sql = "SELECT * FROM trustinfo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql2 = "SELECT SUM(amount) AS totalDonate FROM donation WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row2 = ($result2) ? $result2->fetch_assoc() : ['totalDonate' => 0];

        $sql2 = "SELECT COUNT(*) AS trustNum FROM trustinfo";
        $result2 = $conn->query($sql2);
        $row3 = ($result2) ? $result2->fetch_assoc() : ['trustNum' => 0];

        $sql2 = "SELECT COUNT(*) AS donateNum FROM donation WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row4 = ($result2) ? $result2->fetch_assoc() : ['donateNum' => 0];

        $sql2 = "SELECT SUM(amount) AS allDonate FROM donation";
        $result2 = $conn->query($sql2);
        $row5 = ($result2) ? $result2->fetch_assoc() : ['allDonate' => 0];

        echo '
        <div class="page-header" style="margin: 8px 0 20px;">
            <h1>Dashboard</h1>
            <small>Donor / Dashboard</small>
        </div>

        <div class="page-content">
            <div class="analytics">
                <div class="card">
                    <div class="card-head">
                        <h2> ₹ ' . $row2['totalDonate'] . '</h2>
                        <span class="las la-hand-holding-heart"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Donations Done</small>
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>' . $row3['trustNum'] . '</h2>
                        <span class="las la-users"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Trusts</small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>₹ ' . $row5['allDonate'] . '</h2>
                        <span> &#8377</span>
                    </div>
                    <div class="card-progress">
                        <small>Donations done in our app</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>' . $row4['donateNum'] . '</h2>
                        <span class="las la-list"></span>
                    </div>
                    <div class="card-progress">
                        <small>Times you Have Donated</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            

            
                </header>

                
                
                    
                    <tbody>';

                    $servername = "localhost";
                    $trustname = "root";
                    $password = "";
                    $dbname = "orphan_care"; // Replace with your actual database name
                
                    // Create a database connection
                    $conn = new mysqli($servername, $trustname, $password, $dbname);
                
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                
                    if (isset($_GET['trustid'])) {
                        $trustid = intval($_GET['trustid']);
                        $_SESSION['trustid'] = $trustid;
                    }
                
                    $query = "SELECT * FROM trustinfo WHERE trustid = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $trustid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo'
                
                        
                <div class="container bootstrap snippets bootdey" style="
                top: 410px;
                position: relative;
            ">
            
                <div class="row" style="left: -135px;position: relative;">
                <div class="profile-nav col-md-3">
                <div class="panel">
                <div class="user-heading round">
                <a href="#">
                <img src="../../trust/tsignup/upload/' . $row['pic'] . '" alt>
                </a>
                <h1>' . $row['trustname'] . '</h1>
                <h1>' . $row['mail'] . '</h1>
                </div>
                <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>
                <li><a href="javascript:void(0);" id="donateLink"> <i class="fa fa-inr"></i> Donate </a></li>
                
                <div id="donationPopup" style="display: none;">
                
                    <form id="donationForm" onsubmit="return submitDonation()">
                        <div class="wrapper">
                            <div class="input-data">
                                <input type="text" name="amount" id="amountInput" required>
                                <div class="underline"></div>
                                <label>Donate</label>
                            </div>
                            <br>
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right buy_now" data-img="//www.tutsmake.com/wp-content/uploads/2019/03/c05917807.png" data-amount="10000"  data-id="' . $row['trustid'] . '">
                            Submit
                            </a>
                       
                        </div>
                    </form>
                    </div>
                 
                
                <li><a href="../../form/latest.php?trustid=' . $row['trustid'] . '"> <i class="fa fa-edit"></i> Adopt</a></li>
                </ul>
                </div>
                </div>
                <div class="profile-info col-md-9">
                
                <div class="panel1">
                <div class="bio-graph-heading">
               Begin The Change from You to All
                </div>
                <div class="panel1-body bio-graph-info" style="height: 349px;">
                
                <div class="row">
                <div class="bio-row">
                <p><span>Trust Name </span>: ' . $row['trustname'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>Category </span>: ' . $row['category'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>For </span>: ' . $row['for1'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>Members</span>: ' . $row['members'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>Care Taker </span>: ' . $row['ct'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>Email </span>: ' . $row['mail'] . '</p>
                </div>
                <div class="bio-row">
                <p><span>Mobile </span>: ' . $row['phone'] . '</p>
                </div>
                
            
                
                </div>
                
                

                <div class="value-box">
                <div class="value-heading">Needs</div>

        <p style="text-align: center;">' . $row['need1'] . '</p>
        <p style="text-align: center;">' . $row['need2'] . '</p>
        <p style="text-align: center;">' . $row['need3'] . '</p>
        <p style="text-align: center;">' . $row['need4'] . '</p>
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
                
                
                

                </div>


                
                ';
                    }
                
                } else {
                    echo 'User not found.';
                }
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                
                $conn->close();
                ?>
                
                
                <script>
                    function submitDonation() {
                        // Get the entered amount
                        var amount = document.getElementById('amountInput').value;
                
                        // Perform your operations here with the entered amount
                        var trustId = <?php echo $_SESSION['trustid']; ?>;
                
                        // Add your logic to handle the donation, e.g., send data to server using AJAX
                
                        // For demonstration purposes, just log the values
                        console.log('Donation Amount:', amount);
                        console.log('Trust ID:', trustId);
                
                        // You can redirect the user to another page after processing the donation if needed
                        // window.location.href = 'success.php';
                
                        // Close the popup (you may want to replace this with your own logic)
                        $('.navbar-collapse').removeClass('show');
                        document.getElementById('donationPopup').style.display = 'none';
                
                        // Prevent the form from actually submitting
                        return false;
                    }
                
                    // Show the donation popup when the "Donate" link is clicked
                    document.getElementById('donateLink').addEventListener('click', function () {
                        document.getElementById('donationPopup').style.display = 'block';
                    });
                </script>
                 <script>
      // Get a reference to the input field and the "Submit" button anchor
      var amountInput = document.getElementById('amountInput');
      var submitButton = document.querySelector('.buy_now');
      
      // Add an event listener to the input field to update data-amount attribute
      amountInput.addEventListener('input', function() {
         // Get the current input value and set it as data-amount
         var inputValue = amountInput.value;
         submitButton.setAttribute('data-amount', inputValue);
      });
   </script>
      <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

  $('body').on('click', '.buy_now', function(e){
    var prodimg = $(this).attr("data-img");
    var totalAmount = $(this).attr("data-amount");
    var product_id =  $(this).attr("data-id");

    var options = {
    "key": "rzp_test_CwBZ333czRZrTp",
    "amount": (totalAmount*100), // 2000 paise = INR 20
    "name": "Pay Trust",
    "description": "Payment",
 
    "handler": function (response){
          $.ajax({
            url: 'payment-proccess.php',
            type: 'post',
            dataType: 'json',
            data: {
                razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
            }, 
            success: function (msg) {

               window.location.href = 'https://www.tutsmake.com/Demos/php/razorpay/success.php';
            }
        });
     
    },

    "theme": {
        "color": "#528FF0"
    }
  };
  var rzp1 = new Razorpay(options);
  rzp1.open();
  e.preventDefault();
  });

</script>

<script src=""></script>
<script>
 
  $('body').on('click', '.buy_now', function(e){
    var prodimg = $(this).attr("data-img");
    var totalAmount = $(this).attr("data-amount");
    var product_id =  $(this).attr("data-id");
    var options = {
    "key": "rzp_test_CwBZ333czRZrTp", // secret key id
    "amount": (totalAmount*100), // 2000 paise = INR 20
    "name": "Tutsmake",
    "description": "Payment",
 
    "handler": function (response){
          $.ajax({
            url: 'payment-proccess.php',
            type: 'post',
            dataType: 'json',
            data: {
                razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
            }, 
            success: function (msg) {
 
               window.location.href = 'payment-success.php';
            }
        });
      
    },
 
    "theme": {
        "color": "#528FF0"
    }
  };
  var rzp1 = new Razorpay(options);
  rzp1.open();
  e.preventDefault();
  });
 
</script>

<script>
    // Function to filter the table data
    function filterTable() {
        const filterText = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.querySelectorAll('.client');

        tableRows.forEach((row) => {
            const cardTitle = row.querySelector('h4').textContent.toLowerCase();

            if (cardTitle.includes(filterText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        const noResults = document.getElementById('noResults');
        const table = document.querySelector('.records table');

        // Show or hide "No results" message
        if ([...tableRows].every(row => row.style.display === 'none')) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }


    


</script>


</body>

</html>

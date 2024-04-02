<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Truste Feedback</title>
    <link rel="stylesheet" href="hc.css">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="u4.css"/>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        body{
            overflow-x:hidden;
            overflow-y:hidden;
            color: #797979;
    background: #f1f2f7;
    font-family: 'Open Sans', sans-serif;
    padding: 0px !important;
    margin: 0px !important;
    font-size: 19px;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
        }
        </style>
</head>
<body>

<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['userid'])) {
    header("Location: ../Login/login.php"); // Change login.php to your actual login page
    exit();
}

$userid = $_SESSION['userid'];

// Database connectionf
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
    <div class="side-header">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
        <div class="profile-img bg-img" style="background-image: url('../trust/tsignup/upload/<?php echo $row7['pic']; ?>')"></div>

            <h4><?php echo $row6['username']; ?></h4>
            <small><?php echo $row10['job']; ?></small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="../Home/home.php" >
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../Profile/pro.php">
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                <a href="../notification/noti.php" >
                        <span class="las la-bell"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <li>
                    <a href="../cat/cc.php">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="../feedback/feedback.php" class="active">
                        <span class="las la-star"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                    <a href="../donation/donate.php">
                        <span class="las la-rupee-sign"></span>
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
                <span class="las la-bars"></span>
            </label>

            <div class="header-menu">

                <div class="notify-icon">
                <span class="las la-bell"></span>
                    <span class="notify"><?php echo $row11['notiNum']; ?></span>
                </div>

                <div class="notify-icon">
                    
                    <span class="las la-bell" style=" background-color: red; border-radius: 50%; padding: 2px;"></span>
                    <span class="notify"><?php echo $row12['rejNum']; ?></span>
                </div>

                <div class="user">
                <div class="bg-img" style="background-image: url('../trust/tsignup/upload/<?php echo $row['pic']; ?>')"></div>
                    <span class="las la-sign-out-alt"></span>
                    <a href="../../start/start.php">
                    <span>Logout</span>
</a>
                </div>
            </div>
        </div>
    

    <main>
            
            <div class="page-header" style="top: -47px;position: relative;">
                <h1>Feedback</h1>
                <small>Trust / Feedback</small>
            </div>
            </header>

            
            
            <?php

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

        
<div class="container bootstrap snippets bootdey">
<div class="row">
<div class="profile-nav col-md-3">
<div class="panel">
<div class="user-heading round">
<a href="#">
<img src="../../trust/tsignup/upload/' . $row['pic'] . '" alt>
</a>
<h1>' . $row['trustname'] . '</h1>
<p>' . $row['mail'] . '</p>
</div>
<ul class="nav nav-pills nav-stacked">
<li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>
<li><a href="donate.php"> <i class="fa fa-inr"></i> Donate </a></li>  

<li><a href="../../form/latest.php?trustid=' . $row['trustid'] . '"> <i class="fa fa-edit"></i> Adopt</a></li>
</ul>
</div>
</div>
<div class="profile-info col-md-9">

<div class="panel">
<div class="bio-graph-heading">
Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ispum. Aliquam ac magna metus.
</div>
<div class="panel-body bio-graph-info">

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
<p><span>Care Takers </span>: ' . $row['ct'] . '</p>
</div>
<div class="bio-row">
<p><span>Email </span>: ' . $row['mail'] . '</p>
</div>
<div class="bio-row">
<p><span>Mobile </span>: ' . $row['phone'] . '</p>
</div>
<div class="bio-row">
<div class="overlap-group-2">
            <div class="text-wrapper-4" id="needs">Needs</div>
            <div class="dropdown-box" id="dropdown-options">
            <div class="needinfo1">
            <div >' . $row['need1'] . '</div>
            <div >' . $row['need2'] . '</div>
            <div >' . $row['need3'] . '</div>
            <div >' . $row['need4'] . '</div>
            </div>
            </div>
            </div>
</div>
</div>
</div>
</div>
<div>
<div class="row">



</div>
</div>
</div>
</div>
</div>';

} else {
    echo 'User not found.';
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->close();
?>

</tbody>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script>
    document.getElementById("needs").addEventListener("click", function (event) {
    event.stopPropagation();
    var dropdown = document.getElementById("dropdown-options");
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
});

document.addEventListener("click", function (event) {
    var dropdown = document.getElementById("dropdown-options");
    if (event.target !== dropdown && event.target !== document.getElementById("needs")) {
        dropdown.style.display = "none";
    }
});

</script>
	
</script>

</body>
</html>
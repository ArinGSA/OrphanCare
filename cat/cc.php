<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Category</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
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

        .btn1 {

            background-color: #fff;
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 / 10%);
            background: #fff;
            padding: 1rem;
            border-radius: 25px;
            border: outset;
            /* transition: 0.3s; */
            position: relative;
            transition: transform 0.3s ease-in-out; 
        }

        .btn1:hover {
            transform: scale(1.2);
            /* background-color: #74767d; */
            color: white;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .row-container {
            display: flex;
            gap: 20px;
            flex-direction: column; /* Change here */
            padding-right: 120px;
        }

        .profile-card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 300px;
            margin-bottom: 15px;
        }

        .profile-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .profile-content {
            padding: 20px;
            text-align: center;
        }

        .profile-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .profile-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .profile-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .profile-button:hover {
            background-color: #2980b9;
        }
        </style>

</head>

<body style="background-color: #f1f4f9;">

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
    <div class="side-header">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
            <div class="profile-img bg-img" style="background-image: url('../trust/tsignup/upload/<?php echo $row7['pic']; ?>')"></div>
            <h4><?php echo strtoupper($row6['username']); ?></h4>
            <small><?php echo strtoupper($row10['job']); ?></small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="../Home/home.php" class="btn">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../Profile/pro.php" class="btn">
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="../notification/noti.php" class="btn">
                        <span class="las la-bell"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <li>
                    <a href="../cat/cc.php" class="active">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="../feedback/feedback.php" class="btn">
                        <span class="las la-star"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                    <a href="../donation/donate.php" class="btn">
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
    <div class="header-content" style="height: 61px;">
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
                    <a href="../start/start.php">
                    <span class="las la-sign-out-alt"></span>
                    <span>Logout</span>
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
                <div class="page-header">
                    <h1>Category</h1>
                    <small>Donor / Category</small>
                </div>

                <div class="page-content">

                    <div class="analytics" style="left: 5%;position: relative;">
                    <div class="row-container">
                    <div class="profile-card">
                        <img class="profile-image" src="img/co.jpg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Child Care</div>
                            <div class="profile-description">Caring for Children with compassion to support their growth and ensure a better future</div>
                            <a href="child.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                    <div class="profile-card">
                        <img class="profile-image" src="img/mental.jpg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Mental Care</div>
                            <div class="profile-description">Nurturing orphans with compassionate mental care, fostering emotional well-being.</div>
                            <a href="mental.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                
                </div>
                
                <!-- Row 2 -->
                <div class="row-container">
                    <div class="profile-card">
                        <img class="profile-image" src="img/women.jpg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Women Care</div>
                            <div class="profile-description">Empowering orphaned girls, the Women Care Orphanage provides a nurturing environment for their holistic development</div>
                            <a href="women.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                    <div class="profile-card">
                        <img class="profile-image" src="img/handicap.jpg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Handicap</div>
                            <div class="profile-description">A facility devoted to nurturing and empowering orphaned children with disabilities for their overall well-being</div>
                            <a href="handicap.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                
                </div>
                
                <!-- row3 -->
                <div class="row-container">
                    <div class="profile-card">
                        <img class="profile-image" src="img/old.jpeg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Old Age</div>
                            <div class="profile-description">Offering compassionate care, our old-age orphanage supports and enhances the quality of life for elderly individuals in need</div>
                            <a href="old.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                    <div class="profile-card">
                        <img class="profile-image" src="img/private.jpg" alt="Profile Image">
                        <div class="profile-content">
                            <div class="profile-name">Private Care</div>
                            <div class="profile-description">A private orphanage is a privately-funded institution that offers care and support to orphaned beings
                            </div>
                            <a href="private.php" class="profile-button">View Profile</a>
                        </div>
                    </div>
                
                
                </div>
                
                <img class="profile-image" src="img/logo.png" alt="Profile Image" style="right: 90px;top: 207px;height: 35%;position: relative;opacity: 0.5;">
                    

                        

                    </div>

                </div>';
        } else {
            echo 'No data found in the table.';
        }

        $conn->close();
        ?>

    </main>

</div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Trust Donation</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
        .btn {
          background-color: #918ae5;
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

        table thead th {
            padding: 1rem 0rem;
            text-align: left;
            color: #444;
            font-size: .9rem;
        }
    </style>
</head>
<body>

<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['trustid'])) {
    header("Location: login.php"); // Change login.php to your actual login page
    exit();
}

$trustid = $_SESSION['trustid'];

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
$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $conn->query($sql2);

$row6 = ($result2) ? $result2->fetch_assoc() : ['trustname' => '']; // Corrected assignment

$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $conn->query($sql2);

$row7 = ($result2) ? $result2->fetch_assoc() : ['pic' => '']; // Corrected assignment

$sql2 = "SELECT COUNT(*) AS reqNum FROM form WHERE trustid = $trustid";
        $result2 = $conn->query($sql2);
        $row12 = ($result2) ? $result2->fetch_assoc() : ['reqNum' => 0];

?>
   <input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="side-header">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
        <div class="profile-img bg-img" style="background-image: url('../tsignup/upload/<?php echo $row7['pic']; ?>')"></div>

        <h4><?php echo strtoupper($row6['trustname']); ?></h4>
            <small>Care Taker</small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="../thome/thome.php" class="btn">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../tprofile/tpro.php" class="btn">
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="../tnotification/noti.php" class="btn">
                        <span class="las la-bell"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <!-- <li>
                    <a href="../tcat/cc.php">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li> -->
                <li>
                    <a href="../tfeedback/tfeedback.php" class="btn">
                        <span class="las la-star"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                    <a href="../tdonation/tdonate.php" class="active">
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
                    <span class="notify"><?php echo $row12['reqNum']; ?></span>
            </div>

                <div class="user">
                <div class="bg-img" style="background-image: url('../tsignup/upload/<?php echo $row7['pic']; ?>')"></div>
                    <span class="las la-sign-out-alt"></span>
                    <a href="../../start/start.php">
                    <span>Logout</span>
</a>
                </div>
            </div>
        </div>
    </header>

    <main>

        <?php

        $sql = "SELECT * FROM trustinfo";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $sql2 = "SELECT SUM(amount) AS totalDonate FROM donation WHERE trustid = $trustid";
            $result2 = $conn->query($sql2);

            $row2 = ($result2) ? $result2->fetch_assoc() : ['totalDonate' => 0];

            $sql2 = "SELECT COUNT(*) AS trustNum FROM trustinfo";
            $result2 = $conn->query($sql2);

            $row3 = ($result2) ? $result2->fetch_assoc() : ['trustNum' => 0];

            $sql2 = "SELECT COUNT(*) AS donateNum FROM donation WHERE trustid = $trustid";
            $result2 = $conn->query($sql2);

            $row4 = ($result2) ? $result2->fetch_assoc() : ['donateNum' => 0];

            $sql2 = "SELECT SUM(amount) AS allDonate FROM donation";
            $result2 = $conn->query($sql2);

            $row5 = ($result2) ? $result2->fetch_assoc() : ['allDonate' => 0];

            echo '
                <div class="page-header">
                    <h1>Transaction</h1>
                    <small>Trust / Donation</small>
                </div>

                <div class="page-content">

                    <div class="analytics">

                        <div class="card">
                            <div class="card-head">
                                <h2> ₹ ' . $row2['totalDonate'] . '</h2>
                                <span class="las la-hand-holding-heart"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Donations Recived</small>
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
                                <small>Times you Have Recived</small>
                                <div class="card-indicator">
                                    <div class="indicator four" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="records table-responsive">

                        <div>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><span class="las la-sort"></span> Donor</th>
                                        <th><span class="las la-sort"></span> Donation</th>
                                        <th><span class="las la-sort"></span> Amount</th>
                                        <th><span class="las la-sort"></span> DATE</th>
                                        <th><span class="las la-sort"></span> Payment_ID</th>
                                        <th><span class="las la-sort"></span> Recipt</th>
                                    </tr>
                                </thead>
                                <tbody>';


        // session_start();
        if (!isset($_SESSION['trustid'])) {
          header("Location: ../tlogin/tlogin.php");
          exit();

}

$trustid = $_SESSION['trustid'];

        

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to select all images from the table
        $sql = "SELECT * FROM donation where trustid=$trustid";
        $result = $conn->query($sql);
        // echo ("<script>alert($trustid)</script>");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Retrieve the data from the database
                $name22 = $row['username']; // Corrected column name
                $reason = $row['amount']; // Corrected column name
                $for = $row['date'];
                $userid = $row['userid'];
                $id = $row['id'];
                

                $sql2 = "SELECT * FROM userinfo WHERE userid = $userid";
                $result2 = $conn->query($sql2);
                $row8 = ($result2) ? $result2->fetch_assoc() : ['pic' => '']; // Corrected assignment
                
                $capitalizedUsername = ucfirst($row['username']);

                echo '<a href="../tform/f2.php?trustid=' . $_SESSION['trustid'] . '" class="user-link">';
                                
                                
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td style="width: 22%;">';
                echo '<div class="client">';
                echo '<div class="client-img bg-img" style="background-image: url(\'../tsignup/upload/' . $row8['pic'] . '\')"></div>';
                echo '<div class="client-info">';
            
                echo '<td >';
                echo '<h4 style="padding: 1rem 2rem;">' . $capitalizedUsername . '</h4>';
                echo '</td>';
                // echo '<small>' . $row['userid'] . '</small>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
            
                echo '<td>Rs.' . $row['amount'] . '</td>';
                echo '<td style="padding: 1rem 1rem;">' . $row['date'] . '</td>';
                // echo '<td><span class="paid">' . $row['payment_id'] . '</span></td>';
                echo '<td>' . $row['payment_id'] . '</td>';
                echo '<td>' ;
                echo '<form action="download.php" method="post">';
                echo '<input type="hidden" name="userid" value="' . $userid . '">';
                echo '<input type="hidden" name="donation_id" value="' . $row['id'] . '">';
                echo '<button type="submit" class="paid" style="right: 36px;position: relative;" name="download">Download Recipt</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';

                                }
                            }
            
                            } else {
                                echo 'No images found in the table.';
                            }
                    
                            $conn->close();
                            ?> 
                                
                                
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>
</body>
</html>
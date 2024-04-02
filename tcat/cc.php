<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Category</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body style="background-color: #f1f4f9;">

<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['trustid'])) {
    header("Location: login.php"); // Change login.php to your actual login page
    exit();
}

$trustid = $_SESSION['trustid'];

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
$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $conn->query($sql2);

$row6 = ($result2) ? $result2->fetch_assoc() : ['trustname' => '']; // Corrected assignment

$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $conn->query($sql2);

$row7 = ($result2) ? $result2->fetch_assoc() : ['pic' => '']; // Corrected assignment

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
                    <a href="../thome/thome.php" >
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../tprofile/tpro.php" >
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="las la-bell"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <li>
                    <a href="" class="active">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="../tfeedback/tfeedback.php">
                        <span class="las la-star"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                    <a href="">
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
                    <span class="las la-envelope"></span>
                    <span class="notify">4</span>
                </div>

                <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify">3</span>
                </div>

                <div class="user">
                    <div class="bg-img" style="background-image: url(\'../tsignup/upload/' . $row['pic'] . '\')"></div>
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
                    <h1>Categories</h1>
                    <small>Trust / Categories</small>
                </div>

                <div class="page-content">

                    <div class="analytics">

                        <div class="card" style="left:200px; position: relative;">
                            <div class="card-head">
                            <a href="child.php" >
                                <h2> Child Care</h2>
                                </a>
                                <span class="las la-hand-holding-heart"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Donations Done</small>
                                <div class="card-indicator">
                                    <div class="indicator one" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="top: 362px; left: -234px; position: relative;">
                            <div class="card-head">
                            <a href="women.php" >
                                <h2>Women Care</h2>
                            </a>
                                <span class="las la-users"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Trusts</small>
                                <div class="card-indicator">
                                    <div class="indicator two" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="top: 362px; left:200px; position: relative;">
                            <div class="card-head">
                            <a href="old.php" >
                                <h2>Old Age</h2>
                                </a>
                                <span class="las la-users"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Trusts</small>
                                <div class="card-indicator">
                                    <div class="indicator two" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="left:-231px; position: relative;">
                            <div class="card-head">
                            <a href="handicap.php" >
                                <h2>Handicap Care</h2>
                                </a>
                                <span> &#8377</span>
                            </div>
                            <div class="card-progress">
                                <small>Donations done in our app</small>
                                <div class="card-indicator">
                                    <div class="indicator three" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="top: 481px; left:200px; position: relative;">
                            
                            <div class="card-head">
                            <a href="mental.php" >
                                <h2>Mental care</h2>
                                </a>
                                <span class="las la-list"></span>
                            </div>
                            <div class="card-progress">
                                <small>Times you Have Donated</small>
                                <div class="card-indicator">
                                    <div class="indicator five" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="top: 483px;left: 637px;position: relative;">
                            
                        <div class="card-head">
                        <a href="private.php" >
                            <h2>Private Care</h2>
                            </a>
                            <span class="las la-list"></span>
                        </div>
                        <div class="card-progress">
                            <small>Times you Have Donated</small>
                            <div class="card-indicator">
                                <div class="indicator six" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    </div>

                    

                        

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

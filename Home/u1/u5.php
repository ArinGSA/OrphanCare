<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

$db_host = 'localhost';
$db_trust = 'root';
$db_pass = '';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_trust, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$userid = $_SESSION['userid']; // Replace with the actual ID
$sqlFetch = "SELECT * FROM userinfo WHERE userid= $userid";
$resultFetch = $conn->query($sqlFetch);

$row = $resultFetch->fetch_assoc();
$existingData = !empty($row['need5']) ? explode(',', $row['need5']) : [];



$sql = "SELECT * FROM userinfo WHERE userid = $userid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $row6 = ['username' => $row['username']];
    $row10 = ['job' => $row['job']];
    $row7 = ['pic' => $row['pic']];
} else {
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

$sql2 = "SELECT AVG(rating1) AS review FROM review WHERE userid = $userid";
$result2 = $conn->query($sql2);
$row66 = ($result2) ? $result2->fetch_assoc() : ['review' => 0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Dashboard</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="th2.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 

    <style>
        body {
          overflow-x: hidden;
          background: beige;
        }

        #noResults {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: red;
        }

        .slider-container {
            position: relative;
            width: 100vw;
            height: 60vh; /* Set a fixed height for the slider container */
            overflow-y: hidden; /* Add a vertical scrollbar when content exceeds the height */
            overflow-x: hidden; /* Hide horizontal scrollbar */
            position: relative;
        }

        .slider-content {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            flex: 0 0 100%;
        }

        h2 {
            color: #4caf50;
            margin: 7px;
            margin-top: -13px;
        }

        .columns {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .column {
                    width: 48%;
                    margin-bottom: 10px;
                    padding: 6px 5px;
                    /* border: 1px solid #ddd; */
                    text-align: left;
                }

        p {
            margin-bottom: 5px;
        }

        /* .slide img {
    width: 91%;
    height: 52%;
    object-fit: cover;
} */
.slide img.slide-image1 {
    width: 96%;
    height: 52%;
    object-fit: cover;
}

.slide img.slide-image2 {
    width: 96%;
    height: 52%;
    object-fit: cover;
}

.slide img.slide-image3 {
    width: 100%;
    height: 52%;
    object-fit: cover;
}

        /* button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            padding: 10px;
            cursor: pointer;
            border: none;
            background: none;
        } */

        #prevBtn{
                    position: absolute;
                    bottom: 10px; /* Adjust the distance from the bottom as needed */
                    font-size: 20px;
                    /* padding: 40px; */
                    cursor: pointer;
                    border: none;
                    background: none;
                    transform: translateY(-50%);
                    top: 462px;

                    left: 47%;
                    transform: translateX(-50%) translateY(-50%);
                    margin-right: 10px; /* Add space between buttons */
                                }

        #nextBtn {
                    position: absolute;
                    bottom: 10px; /* Adjust the distance from the bottom as needed */
                    font-size: 20px;
                    /* padding: 40px; */
                    cursor: pointer;
                    border: none;
                    background: none;
                    transform: translateY(-50%);
                    top: 461px;

                    right: 47%;
                    transform: translateX(50%) translateY(-50%);
                    z-index: 111111;
                    margin-left: 10px; /* Add space between buttons */
                }


        .combined-content {
            display: flex;
            flex-direction: column;
            /* top: -21px; */
            /* left: 4%; */
            position: relative;
        }

        .page-content,
        .records.table-responsive {
            margin-top: 20px;
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

        .btn1 {

            background-color: #fff;
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 / 10%);
            background: #fff;
            padding: 0.8rem;
            border-radius: 25px;
            border: outset;
            border-color: #8829e0;
            /* transition: 0.3s; */
            position: relative;
            transition: transform 0.3s ease-in-out; 
        }

        .btn1:hover {
            transform: scale(1.2);
            /* background-color: #74767d; */
            color: white;
        }

        .needs-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.need-box {
    flex: 1 0 calc(50% - 10px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    text-align: center;
    background-color: #f5f5f5;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-control-label{
    margin:8px;
}

.flipping-star {
      display: inline-block;
      animation: flipStar 0.5s linear infinite alternate;
    }

    @keyframes flipStar {
      0% {
        transform: rotateY(0deg);
      }
      100% {
        transform: rotateY(180deg);
      }
    }

    .notify-icon {
      display: inline-block;
    }

    .shake {
      animation: shakeIcon 1s ease infinite;
    }

    @keyframes shakeIcon {
      0%, 100% {
        transform: translateX(0);
      }
      25%, 75% {
        transform: translateX(-2px);
      }
      50% {
        transform: translateX(2px);
      }
    }

    /* Additional styling for the notification count */
    .notify {
      background-color: red;
      color: white;
      padding: 2px 6px;
      border-radius: 50%;
      margin-left: 4px;
    }



    #donationPopup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #c8c6ff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 999;
    }

    #donationPopup label {
        display: block;
        margin-bottom: 10px;
    }

    #donationPopup input {
        width: 83%;
        padding: 8px 1rem;
        margin-bottom: 15px;
    }

    #donationPopup button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #donationPopup .button-container {
        text-align: center;
        right: 37%;
        position: relative;
    }

    .rupee-input {
      position: relative;
    }

    .rupee-input::before {
      content: '\20B9'; /* Unicode for the rupee symbol */
      position: absolute;
      left: 25px; /* Adjust the left position as needed */
      top: 39%;
      transform: translateY(-50%);
      font-size: 1.2em;
    }

    #amountInput {
      padding-left: 30px; /* Adjust the padding to make room for the symbol */
    }

    #catchyLine {
        color: black;
        margin-bottom: 15px;
    }


    .scrollable-container {
        max-height: 323px;
        overflow-y: scroll;
        background-color: #f5f5f5; /* Change the background color */
        border: 1px solid #ddd; /* Add a border */
        border-radius: 8px; /* Add border-radius for rounded corners */
        padding: 10px; /* Add some padding */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background-color: #737373; /* Color of the thumb */
        border: 2px solid #737373; /* Border to simulate height */
        border-radius: 4px; /* Adjust the border-radius for a rounded thumb */
        box-shadow: inset 0 0 0 4px #f0f0f0; /* Simulate height with box-shadow */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background-color: #f0f0f0; /* Color of the track */
    }

    .scrollable-container::-webkit-scrollbar {
        width: 6px; /* Adjust the width as needed */
        right: 11px; /* Move the scrollbar to the right edge */
    }

    .scrollable-container::-webkit-scrollbar-button {
        height: 48px; /* for vertical scrollbar */
    }


    body::-webkit-scrollbar {
        width: 10px; /* Adjust the width as needed */
        right: 11px; /* Move the scrollbar to the right edge */
    }
    body::-webkit-scrollbar-thumb {
        background-color: #737373; /* Color of the thumb */
        border: 2px solid #737373; /* Border to simulate height */
        border-radius: 4px; /* Adjust the border-radius for a rounded thumb */
        box-shadow: inset 0 0 0 4px #f0f0f0; /* Simulate height with box-shadow */
    }

    body::-webkit-scrollbar-track {
        background-color: #f0f0f0; /* Color of the track */
    }

    body::-webkit-scrollbar-button {
        height: 48px; /* for vertical scrollbar */
    }

    </style>

</head>

<body>



<input type="checkbox" id="menu-toggle">
<div class="sidebar" style="background-color: #918ae5;">
    <div class="side-header">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
            <div class="profile-img bg-img" style="background-image: url('../../trust/tsignup/upload/<?php echo $row7['pic']; ?>')"></div>
            <h4><?php echo strtoupper($row6['username']); ?></h4>
            <small><?php echo strtoupper($row10['job']); ?></small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="u5.php" class="active">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../../profile/pro.php" class="btn">
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="../../notification/noti.php" class="btn">
                        <span class="las la-bell"></span>
                        <small>Notification</small>
                    </a>
                </li>
                <li>
                    <a href="../../cat/cc.php" class="btn">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="../../feedback/feedback.php" class="btn">
                        <span class="las la-star"></span>
                        <small>Feedback</small>
                    </a>
                </li>
                <li>
                    <a href="../../donation/donate.php" class="btn">
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
                    <div class="bg-img" style="background-image: url('../../trust/tsignup/upload/<?php echo $row['pic']; ?>')"></div>
                    <span class="las la-sign-out-alt"></span>
                    <a href="../start/start.php">
                    <span>Logout</span>
                </a>
                </div>
            </div>
        </div>
</header>


<?php



$servername = "localhost";
$trustname = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $trustname, $password, $database);

if (!$connection) {
    die("Connection failed: " . $conn->connect_error);
}

$numInputTags = 0; // Declare the variable outside the conditional block

// Fetch all existing data before the form is submitted
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['trustid'])) {
    $trustid = intval($_GET['trustid']);
    $_SESSION['trustid'] = $trustid;
}
$trustid = $_SESSION['trustid'];
$sqlFetch = "SELECT * FROM trustinfo WHERE trustid= $trustid";
$resultFetch = $connection->query($sqlFetch);

if ($resultFetch->num_rows > 0) {
    $row = $resultFetch->fetch_assoc();
    $existingData = explode(',', $row['need5']);
    $numInputTags = count($existingData);
} else {
    $existingData = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process the submitted values
    for ($i = 1; $i <= $numInputTags; $i++) {
        $inputValue = isset($_POST['input_' . $i]) ? $_POST['input_' . $i] : '';

        if (!empty($inputValue) && !in_array($inputValue, $existingData)) {
            $existingData[] = $inputValue;
        }
    }

    // Convert array to comma-separated string
    $updatedneed5 = implode(',', $existingData);

    // Update the row with the new need5 values
    $sqlUpdate = "UPDATE trustinfo SET need5 = '$updatedneed5' WHERE trustid= $trustid";
    $connection->query($sqlUpdate);
    

    // Fetch the updated data to display after submission
    $resultFetch = $connection->query($sqlFetch);
    $row = $resultFetch->fetch_assoc();
    $existingData = explode(',', $row['need5']);
    $numInputTags = count($existingData);
}

$sql2 = "SELECT COUNT(*) AS reqNum FROM form WHERE trustid = $trustid";
        $result2 = $connection->query($sql2);
        $row12 = ($result2) ? $result2->fetch_assoc() : ['reqNum' => 0];
?>





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
                    $trustid = $_SESSION['trustid'];
$sqlFetch = "SELECT * FROM trustinfo WHERE trustid= $trustid";
$resultFetch = $conn->query($sqlFetch);

$row = $resultFetch->fetch_assoc();
$existingData = !empty($row['need5']) ? explode(',', $row['need5']) : [];



$sql = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $row6 = ['trustname' => $row['trustname']];
    
//     $row7 = ['pic' => $row['pic']];
// } else {
//     $row6 = ['trustname' => ''];
    
//     $row7 = ['pic' => ''];
// }

$sql2 = "SELECT COUNT(*) AS notiNum FROM accepted WHERE trustid = $trustid";
$result2 = $conn->query($sql2);
$row11 = ($result2) ? $result2->fetch_assoc() : ['notiNum' => 0];

$sql2 = "SELECT COUNT(*) AS rejNum FROM declined WHERE trustid = $trustid";
$result2 = $conn->query($sql2);
$row12 = ($result2) ? $result2->fetch_assoc() : ['rejNum' => 0];

$sql2 = "SELECT AVG(rating1) AS review FROM review WHERE trustid = $trustid";
$result2 = $conn->query($sql2);
$row66 = ($result2) ? $result2->fetch_assoc() : ['review' => 0];

$sql2 = "SELECT COUNT(*) AS reqNum FROM form WHERE trustid = $trustid";
        $result2 = $conn->query($sql2);
        $row12 = ($result2) ? $result2->fetch_assoc() : ['reqNum' => 0];

$trustid = $_SESSION['trustid'];

    $query = "SELECT trustname, phone, mail, pic, area, upi, for1, acc, ct, members, category, need1, need2, need3, states, status1 FROM trustinfo WHERE trustid = $trustid"; // Modify the query according to your database schema
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo '

        <div class="main-content">
        <!-- Top navbar -->
        
        <!-- Header -->
        <div class="slider-container">
          <div class="slider-content" id="slider">
          <div class="slide">
    <img class="slide-image1" src="image2.png" alt="Image 1">
    </div>
    <div class="slide">
    <img class="slide-image2" src="image1.jpeg" alt="Image 2">
    </div>
    <div class="slide">
    <img class="slide-image3" src="image20.jpg" alt="Image 3">
    </div>
              <!-- Add more slides as needed -->
          </div>
    
          <button id="prevBtn" onclick="prevSlide()">❮</button>
          <button id="nextBtn" onclick="nextSlide()">❯</button>
      </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
          <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0" style="
            left: 45px;
        ">
        <div class="card card-profile shadow" style="left: 1122px;">
                <div class="row justify-content-center">
                  <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                      <a href="../../profile/pro.php">
                        <img src=../../trust/tsignup/upload/' . $row['pic'] . ' >
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                  <!-- <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
                    <a href="#" class="btn btn-sm btn-default float-right">Message</a>
                  </div> -->
                </div>
                <div class="card-body pt-0 pt-md-4">
                  <div class="row">
                    <div class="col">
                      <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                        <div>
                          <span class="heading">' . $row['members'] . '</span>
                          <span class="description">members</span>
                        </div>
                        <div>
                          <span class="heading">' . $row['category'] . '</span>
                          <span class="description">Category</span>
                        </div>
                        <div>
                          <span class="heading">' . $row['for1'] . '</span>
                          <span class="description">For</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <h3>
                    ' . $row['ct'] . '
                    </h3>
                    <div class="h5 font-weight-300">
                      <i class="ni location_pin mr-2"></i>TrustName: ' . $row['trustname'] . '
                    </div>
                    <div class="h5 mt-4" style="top: -10px;position: relative;>
                      <i class="ni business_briefcase-24 mr-2"></i>Trust Manager/Caretaker - ' . $row['ct'] . '
                    </div>
                    <div>
                      <i class="ni education_hat mr-2" ></i>contact number : ' . $row['phone'] . '
                    </div>';
                    echo '
    <hr class="my-4">
    <div class="scrollable-container">
        <p style="line-height: 200%; top: -10px; position: relative; font-weight: bold; text-decoration: underline; color: blue;">Need</p>
        <h2><p>No of Needs: ' . count($existingData) . '</p></h2>
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <div style="top: 21px; position: relative;">
                <p>Total No of Rows: ' . max(0, $numInputTags - 1) . '</p>
                <div class="columns">';
                    for ($i = 2; $i <= $numInputTags; $i++) {
                        $value = isset($existingData[$i - 1]) ? htmlspecialchars($existingData[$i - 1]) : '';
                        echo '<div class="column"><input type="text" name="input_' . $i . '" placeholder="Input ' . $i . '" style="font-size: larger;border: groove;width: 194px;""" value="' . $value . '"><br></div>';
                    }
echo '          </div>
                <a href="needs.php?trustid=' . $_SESSION['trustid'] . '" class="active">
                    <span style="font-weight: 600; margin: 6px 0; border: double; max-width: 260px; height: 48px; width: 100%; position: fixed; left: 27%; color: #fff; font-size: larger; z-index: 1; background-color: #3f6eef; display: flex; align-items: center; justify-content: center;">
                        Needs
                    </span>
                </a>
            </div>
        </form>
    </div>';

   echo'     
<li>
    <a href="javascript:void(0);" id="donateLink" class="btn">
      <i class="fa fa-inr"></i> Donate
    </a>
</li>
                
                
                
                <div id="donationPopup">
                    <p id="catchyLine">Every contribution counts!</p>
                    <label for="amountInput">Your donation makes a difference</label>

                        <div class="rupee-input">
                            <input type="number" id="amountInput" required>
                        </div> 
                        <img src="logo1.png" alt="Donation Image" style="width: 65%; max-height: 200px; margin-bottom: 15px;">

                    <div class="button-container">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right buy_now" data-img="//www.tutsmake.com/wp-content/uploads/2019/03/c05917807.png" data-amount="10000"  data-id="' . $trustid . '">
                                pay
                            </a>
                    </div>
                </div>

<li style="top: 10px;position: relative;">
<a href="../../form/latest.php?trustid=' . $trustid . '"  class="btn" style="width: 94px;">
    <i class="fa fa-inr"></i> Adopt
</a>
</li>
</div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8 order-xl-1" style="left: 18px;height: 140px;">
        <div class="card bg-secondary shadow" style="top: -807px;">
                <div class="card-header bg-white border-0" style="top: 10px;position: relative;">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h3 class="mb-0">My account</h3>
                    </div>
                    
                  </div>
                </div>
                <div class="card-body">
                <form>
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-username">Username</label>
                                    <p class="form-control form-control-alternative" style="text-transform: uppercase; font-weight: bold;">';
                                        $trustname = $row['trustname'];
                                        echo '<span style="font-size: larger;">' . substr($trustname, 0, 1) . '</span>' . substr($trustname, 1);
                                        echo'
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">Email address</label>
                                    <p class="form-control form-control-alternative">
                                    ' . $row['mail'] . '
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-first-name">CareTaker Name</label>
                                    <p class="form-control form-control-alternative">
                                    ' . $row['ct'] . '
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-last-name">Category</label>
                                    <p class="form-control form-control-alternative">
                                    ' . $row['category'] . '
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Account information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-username">Acc Number</label>
                                    <p class="form-control form-control-alternative">
                                    ' . $row['acc'] . '
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">UPI</label>
                                    <p class="form-control form-control-alternative">
                                    ' . $row['upi'] . '
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    </div>



                    <hr class="my-4">
                    
                    
                    
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-address">Address</label>
                            <p id="input-address" class="form-control form-control-alternative">
                            ' . $row['area'] . '
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-city">Phone Number</label>
                            <p type="text" id="input-city" class="form-control form-control-alternative">
                            ' . $row['phone'] . '
                            </p>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-country">For</label>
                            <p type="text" id="input-country" class="form-control form-control-alternative">
                            ' . $row['for1'] . '
                            </p>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="form-control-label" for="input-country"> State </label>
                            <p type="number" id="input-postal-code" class="form-control form-control-alternative">
                            ' . $row['states'] . '
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr class="my-4">
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Status</h6>
                    <div class="pl-lg-4">
                      <div class="form-group focused">
                        <label>Present Status</label>
                        <p rows="4" class="form-control form-control-alternative" >' . $row['status1'] . '</p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        
      </div>';
        echo '
        </div>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
    
    </div>';
    } else {
        echo 'No data found in the table.';
    }
  
    ?>





<script>
    document.getElementById('donateLink').addEventListener('click', function () {
        document.getElementById('donationPopup').style.display = 'block';

        document.getElementById('amountInput').focus();//for slelct input tag
    });

    // Close the popup when clicking outside of it
    window.addEventListener('click', function (event) {
        var donationPopup = document.getElementById('donationPopup');
        var donateLink = document.getElementById('donateLink');

        if (event.target !== donateLink && !donationPopup.contains(event.target)) {
            donationPopup.style.display = 'none';
        }
    });

    function submitDonation() {
        // Get the entered amount
        var amount = document.getElementById('amountInput').value;

        // Perform your operations here with the entered amount
        var trustId = <?php echo $_SESSION['trustid']; ?>;
        console.log('Donation Amount:', amount);
        console.log('Trust ID:', trustId);

        // Close the popup
        document.getElementById('donationPopup').style.display = 'none';

        // Prevent the form from actually submitting
        return false;
    }
</script>





<script>
  // Add a click event listener to toggle the 'flipped' class
  document.querySelector('.flip-star').addEventListener('click', function() {
    this.classList.toggle('flipped');
  });
</script>
<script>
        // Function to filter the table data
        function filterTable() {
            const filterText = document.getElementById('searchInput').value.toLowerCase();
            const tableRows = document.querySelectorAll('.records table tbody tr');

            tableRows.forEach((row) => {
                const cardTitle = row.querySelector('h4').textContent.toLowerCase();

                if (cardTitle.includes(filterText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');

            // Show or hide "No results" message
            if ([...tableRows].every(row => row.style.display === 'none')) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }

        let currentSlide = 0;

        function showSlide() {
            const slider = document.getElementById('slider');
            const slides = document.getElementsByClassName('slide');
            if (currentSlide >= slides.length - 1) {
                currentSlide = 0;
            } else {
                currentSlide++;
            }
            slider.style.transform = `translateX(${-currentSlide * 100}%)`;
        }

        function prevSlide() {
            const slider = document.getElementById('slider');
            if (currentSlide <= 0) {
                currentSlide = slider.children.length - 1;
            } else {
                currentSlide--;
            }
            slider.style.transform = `translateX(${-currentSlide * 100}%)`;
        }

        function nextSlide() {
            showSlide();
        }

        // Auto slide every 3 seconds
        setInterval(showSlide, 300000);
    </script>

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

</body>

</html>

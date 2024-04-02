<?php
session_start();

if (!isset($_SESSION['trustid'])) {
    header("Location: login.php");
    exit();
}

$trustid = $_SESSION['trustid'];

$db_host = 'localhost';
$db_trust = 'root';
$db_pass = '';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_trust, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $updatedData = array(
        'trustname' => $_POST['trustname'],
        'mail' => $_POST['mail'],
        'ct' => $_POST['ct'],
        'category' => $_POST['category'],
        'acc' => $_POST['acc'],
        'upi' => $_POST['upi'],
        'area' => $_POST['area'],
        'phone' => $_POST['phone'],
        'for1' => $_POST['for1'],
        'states' => $_POST['states'],
        'status1' => $_POST['status1'],
    );

    $updateQuery = "UPDATE trustinfo SET ";
    foreach ($updatedData as $key => $value) {
        $updateQuery .= "$key = '" . mysqli_real_escape_string($conn, $value) . "', ";
    }
    $updateQuery = rtrim($updateQuery, ', ');
    $updateQuery .= " WHERE trustid = $trustid";

    $conn->query($updateQuery);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$query = "SELECT trustname, mail, ct, category, acc, upi, area, phone, for1, states, status1 FROM trustinfo WHERE trustid = $trustid";
$result = mysqli_query($conn, $query);

$trustid = $_SESSION['trustid'];
$sqlFetch = "SELECT * FROM trustinfo WHERE trustid= $trustid";
$resultFetch = $conn->query($sqlFetch);

$row = $resultFetch->fetch_assoc();
$existingData = !empty($row['need5']) ? explode(',', $row['need5']) : [];

$sql = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $row6 = ['trustname' => $row['trustname']];
    $row7 = ['pic' => $row['pic']];
} else {
    $row6 = ['trustname' => ''];
    $row7 = ['pic' => ''];
}

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

.slide img.slide-image1 {
    width: 100%;
    height: 52%;
    object-fit: cover;
}

.slide img.slide-image2 {
    width: 100%;
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

        
        #nextBtn {
            position: absolute;
            /* bottom: 10px; */
            /* padding: 40px; */
            font-size: 20px;
            cursor: pointer;
            border: none;
            background: none;
            transform: translateY(-50%);
            top: 300px;
            right: 0%;
            transform: translateX(-50%) translateY(-50%);
            margin-right: 10px;
                                }

            #prevBtn{
                position: absolute;
                /* bottom: 10px; */
                /* padding: 40px; */
                /* z-index: 111111; */
                font-size: 20px;
                cursor: pointer;
                border: none;
                background: none;
                transform: translateY(-50%);
                top: 300px;
                left: 1%;
                transform: translateX(50%) translateY(-50%);
                margin-left: 10px;
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


    .hidden-header, .hidden-sidebar {
    opacity: 0;
    pointer-events: none; /* To prevent interaction when hidden */
    transition: opacity 0.3s ease; /* You can adjust the duration and timing function as needed */
}

/* Visible state with full opacity */
header, .sidebar {
    opacity: 1;
    pointer-events: auto; /* Enable interaction when visible */
}



    </style>

</head>

<body>

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
</div>


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
$trustid = $_SESSION['trustid']; // Replace with the actual ID
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


<input type="checkbox" id="menu-toggle">
<div class="sidebar" style="background-color: #918ae5;">
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
                    <a href="../thome/te.php" class="active">
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
                    <a href="../tcat/cc.php" class="btn">
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
                    <a href="../tdonation/tdonate.php" class="btn">
                        <span class="las la-rupee-sign"></span>
                        <small>Transaction</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main-content">
<header class="header">
    <div class="header-content" style="height: 61px;padding: 0rem 0rem;">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>

            <div class="header-menu">

            <div class="notify-icon shake">
    <span class="las la-bell"></span>
    <span class="notify"><?php echo $row12['reqNum']; ?></span>
  </div>

                <div class="notify-icon">
                <a href="../tnotification/rev.php">
                <td><div class="flipping-star" id="flippingStar">⭐</div> <?php echo intval($row66['review']); ?></td>
            </a>
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
        ?>

        <?php
    // session_start();

    if (!isset($_SESSION['trustid'])) {
        header("Location: ../tlogin/tlogin.php");
        exit();
    }

    $trustid = $_SESSION['trustid'];

    $servername = "localhost";
    $trustname = "root";
    $password = "";
    $database = "orphan_care"; 

    $connection = mysqli_connect($servername, $trustname, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT trustname, phone, mail, pic, area, upi, for1, acc, ct, members, category, need1, need2, need3, states, status1 FROM trustinfo WHERE trustid = $trustid"; // Modify the query according to your database schema
    $result = mysqli_query($connection, $query);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
        // Process the submitted values
        $trustname = mysqli_real_escape_string($connection, $_POST['trustname']);
        // Update other variables similarly
    
        $updateQuery = "UPDATE trustinfo SET trustname = '$trustname', mail = '$mail', ct = '$ct', category = '$category', acc = '$acc', upi = '$upi', area = '$area', phone = '$phone', for1 = '$for1', states = '$states', status1 = '$status1' WHERE trustid = $trustid";
    
        // Execute the update query
        $connection->query($updateQuery);
    
        // Redirect to the same page to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    echo '
    <div class="main-content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-8 order-xl-1" style="left: 18px;height: 140px;">
                <div class="card card-profile shadow" style="left: 1060px;width: 524px;top: 139px;">
                <div class="row justify-content-center">
                  <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                      <a href="../tprofile/tpro.php">';
                      echo '<img src="../tsignup/upload/' . htmlspecialchars($row['pic']) . '" alt="Image">';
                      echo'
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
            <div style="top: 5px; position: relative;">
                <p>Total No of Rows: ' . max(0, $numInputTags - 1) . '</p>
                <div class="columns">';
                    for ($i = 2; $i <= $numInputTags; $i++) {
                        $value = isset($existingData[$i - 1]) ? htmlspecialchars($existingData[$i - 1]) : '';
                        echo '<div class="column"><input type="text" name="input_' . $i . '" placeholder="Input ' . $i . '" style="font-size: larger;border: groove;width: 194px;""" value="' . $value . '"><br></div>';
                    }
echo '          </div>
                
            </div>
        </form>
    </div>';
                  echo'
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8 order-xl-1" style="left: 18px;height: 140px;">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0" style="top: 10px;position: relative;">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="pl-lg-4">
                                <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-username">Username</label>';
echo '<input class="form-control form-control-alternative" name="trustname" style="text-transform: uppercase; font-weight: bold;" value="' . strtoupper($row['trustname']) . '" />';
echo '</div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>';
echo '<input class="form-control form-control-alternative" type="text" name="mail" value="' . $row['mail'] . '" />';
echo '</div>
                                        </div>
                                    </div>
                                    <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-first-name">CareTaker Name</label>';
                                    echo '<input class="form-control form-control-alternative" name="ct" type="text" value="' . $row['ct'] . '" />';
                                    echo'
                                </div>
                            </div>
                            <div class="col-lg-6">
    <div class="form-group focused">
        <label class="form-control-label" for="input-last-name">Category</label>
        <select class="form-control form-control-alternative" name="category" style="position: relative; text-align: center;" required>';
        $categories = ['old', 'women', 'mental', 'handicap', 'private', 'child'];
        foreach ($categories as $category) {
            $selected = ($row['category'] === $category) ? 'selected' : '';
            echo "<option value=\"$category\" $selected>" . ucfirst($category) . " Care</option>";
        }
        echo '</select>';
        echo'
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
                                    <label class="form-control-label" for="input-username">Acc Number</label>';
                                    echo '<input class="form-control form-control-alternative" name="acc" type="text" value="' . $row['acc'] . '" />';
                                    echo'
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">UPI</label>';
                                    echo '<input class="form-control form-control-alternative" name="upi" type="text" value="' . $row['upi'] . '" />';
                                    echo'
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <hr class="my-4">

                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-address">Address</label>';
                            echo '<input class="form-control form-control-alternative" name="area" type="text" value="' . $row['area'] . '" />';
                            echo'
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-city">Phone Number</label>';
                            echo '<input class="form-control form-control-alternative" name="phone" type="text" value="' . $row['phone'] . '" />';
                            echo'
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group focused">
                            <label class="form-control-label" for="input-country">For</label>';
                            echo '<input class="form-control form-control-alternative" name="for1" type="text" value="' . $row['for1'] . '" />';
                            echo'
                          </div>
                        </div>';
                        echo '
<div class="col-lg-4">
    <div class="form-group">
        <label class="form-control-label" for="input-country">State</label>
        <select class="form-control form-control-alternative" name="states" required>
            ';

$indianStates = array(
    'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh',
    'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland',
    'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal',
    'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Lakshadweep', 'Delhi', 'Puducherry'
);

foreach ($indianStates as $state) {
    $selected = ($row['states'] === $state) ? 'selected' : '';
    echo "<option value=\"$state\" $selected>$state</option>";
}

echo '
        </select>
    </div>
</div>';
echo'
                      </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Status</h6>
                    <div class="pl-lg-4">
                      <div class="form-group focused">
                        <label>Present Status</label>';
                        echo '<input class="form-control form-control-alternative" name="status1" type="text" value="' . $row['status1'] . '" />';
                        echo'
                      </div>
                    </div>
                </div>

                                    <hr class="my-4">
                                    <button type="submit" name="update_profile">Update Profile</button>
                                </form>
                            </div>
                            <!-- Include other HTML content... -->
                        </div>
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
  // Add a click event listener to toggle the 'flipped' class
  document.querySelector('.flip-star').addEventListener('click', function() {
    this.classList.toggle('flipped');
  });
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector(".header");
    const sidebar = document.querySelector(".sidebar");
    const combinedContent = document.querySelector(".combined-content");
    const barsIcon = document.querySelector(".las.la-bars");
    const scrollThreshold = 150; // Adjust this value based on your preference
    const fadeInDistance = 50; // Adjust this value based on how far you want to scroll before elements start fading in

    // Initial styles
    header.style.opacity = 0;
    sidebar.style.opacity = 0;
    sidebar.style.pointerEvents = "none";

    window.onscroll = function () {
        let currentScrollPos = window.pageYOffset;

        // Toggle the styles based on the scroll position for buttons
        if (currentScrollPos < fadeInDistance) {
            header.style.pointerEvents = "none";
            sidebar.style.pointerEvents = "none";
        } else {
            header.style.pointerEvents = "auto";
            sidebar.style.pointerEvents = "auto";
        }

        // Apply the fading effect only when scrolling down
        if (currentScrollPos > fadeInDistance) {
            let opacity = (currentScrollPos - fadeInDistance) / (scrollThreshold - fadeInDistance);
            opacity = Math.min(1, Math.max(0, opacity));
            header.style.opacity = opacity;
            sidebar.style.opacity = opacity;
        } else {
            // Reset opacity if scrolling up
            header.style.opacity = 0;
            sidebar.style.opacity = 0;

            // Simulate click on bars-icon when scrolling up
            if (currentScrollPos === 0 && barsIcon) {
                barsIcon.click();
            }
        }

        // Move the combined-content to the right when scrolling up
        if (currentScrollPos < fadeInDistance) {
            combinedContent.style.right = "2.5%";
        } else {
            combinedContent.style.right = "-1%";
        }
    };

    // Trigger the scroll event once to apply initial styles
    window.dispatchEvent(new Event("scroll"));
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
        setInterval(showSlide, 3000);
    </script>

<script>
    // Your PHP variable
    var reviewValue = <?php echo intval($row66['review']); ?>;

    // Get the div element
    var flippingStar = document.getElementById('flippingStar');

    // Check the condition and apply the animation
    if (reviewValue > 0) {
      flippingStar.style.animation = 'flipStar 0.5s linear infinite alternate';
    } else {
      // If the condition is not met, remove the animation
      flippingStar.style.animation = 'none';
    }
  </script>

<script>
    // Your PHP variable
    var reqNumValue = <?php echo intval($row12['reqNum']); ?>;

    // Get the div element
    var notifyIcon = document.querySelector('.notify-icon');

    // Check the condition and apply the shaking animation
    if (reqNumValue > 0) {
      notifyIcon.classList.add('shake');
    } else {
      // If the condition is not met, remove the shaking animation class
      notifyIcon.classList.remove('shake');
    }
  </script>

</body>

</html>

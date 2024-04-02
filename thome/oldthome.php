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

$sql2 = "SELECT AVG(rating1) AS review FROM review WHERE trustid = $trustid";
$result2 = $conn->query($sql2);
$row66 = ($result2) ? $result2->fetch_assoc() : ['review' => 0];

// if ($result2) {
//     $row2 = $result2->fetch_assoc();
//     $reviewDisplay = isset($row2['review']) ? ' ' . $row2['review'] : '';
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Home</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

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
    body{
        overflow-x:hidden;
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
    width: 91%;
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
                    top: 564px;

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
                    top: 564px;

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
    </style>

</head>

<body>



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
                    <a href="../thome/thome.php" class="active">
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
    <header>
        <div class="header-content" style="height: 61px;">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>

            <div class="header-menu">

                <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify">3</span>
                </div>

                <div class="notify-icon">
                <a href="../tnotification/rev.php">
                <td style="left: 29px;position: relative;"> ⭐ <?php echo intval($row66['review']); ?></td>
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

        <div class="slider-container">
            <div class="slider-content" id="slider">
            <div class="slide">
    <img class="slide-image1" src="image2.png" alt="Image 1">
</div>
<div class="slide">
    <img class="slide-image2" src="image1.jpeg" alt="Image 2">
</div>
<div class="slide">
    <img class="slide-image3" src="image30.jpg" alt="Image 3">
</div>
                <!-- Add more slides as needed -->
            </div>

            <button id="prevBtn" onclick="prevSlide()">❮</button>
            <button id="nextBtn" onclick="nextSlide()">❯</button>
        </div>

        <div class="combined-content">
            

            <div class="page-content" style="background-color: white;padding: 1.3rem 0rem;">
                <div class="analytics">
                    <div class="card">
                        <div class="card-head">
                            <h2> ₹ ' . $row2['totalDonate'] . '</h2>
                            <span class="las la-hand-holding-heart"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Donations Got</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>' . $row3['trustNum'] . '</h2>
                            <span class="las la-trusts"></span>
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
                            <small>Times you Have Been Donated</small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="records table-responsive" style="overflow-x: hidden;">
                    <div class="record-header">
                        <div class="browse">
                            <input class="record-search" type="text" id="searchInput" oninput="filterTable()" placeholder="Search by trustname">
                            <div id="noResults">No matching results found.</div>
                        </div>
                    </div>

                    <table width="100%" >
                        <thead style="overflow: hidden;">
                            <tr>
                                <th>trust ID</th>
                                <th style="padding: 1rem 5rem;"> TRUST</th>
                                <th style="padding: 1rem 0rem;"> TrustName</th>
                                <th> MAIL</th>
                                <th> Review</th>
                                <th> DONATIONS</th>
                                <th> NUMBER</th>
                                <th> CATEGORY</th>
                            </tr>
                        </thead>
                        <tbody>';

        while ($row = $result->fetch_assoc()) {
            $trustId = $row['trustid'];

            $sql2 = "SELECT AVG(rating1) AS review FROM review WHERE trustid = $trustId";
            $result2 = $conn->query($sql2);

            if ($result2) {
                $row2 = $result2->fetch_assoc();
                $reviewDisplay = isset($row2['review']) ? ' ' . $row2['review'] : '';
            }

            $sql1 = "SELECT SUM(amount) AS totalAmount FROM donation WHERE trustid = $trustId";
            $result1 = $conn->query($sql1);

            if ($result1) {
                $row1 = $result1->fetch_assoc();
                $totalAmountDisplay = isset($row1['totalAmount']) ? '₹ ' . $row1['totalAmount'] : '';

                echo '
                <tr style="border-bottom: 1px solid #dee2e8;">
                    <td>Tru' . $row['trustid'] . '</td>
                    <td style="width: 22%;">
                        <div class="client">

                        <a href="u1/u5.php?trustid=' . $row['trustid'] . '">
                            <div class="client-img bg-img" style="background-image: url(\'../tsignup/upload/' . $row['pic'] . '\')"></div>
                            <div class="client-info">
                            <td>
                                    <h4>' . $row['trustname'] . '</h4>
                            </td>
                        </a>
                                <td>
                                    <a href="mailto:' . $row['mail'] . '">
                                        <h4><small>' . $row['mail'] . '</small></h4>
                                    </a>
                                </td>
                            </div>
                        </div>
                    </td>
                    <td style="left: 29px;position: relative;"> <a href="../review/review.php?trustid=' . $row['trustid'] . '"" style="left: -14px;position: relative;">⭐ ' . (int)$reviewDisplay . '</td>
                    <td style="left: 29px;position: relative;">' . $totalAmountDisplay . '</td>


                    <td >' . $row['phone'] . '</td>
                    <td style="left: 26px;position: relative;">' . $row['category'] . '</td>
                </tr>';
            }
         }

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
        // Function to filter the table data
        function filterTable() {
            const filterText = document.getElementById('searchInput').value.toLowerCase();
            const tableRows = document.querySelectorAll('.client');

            tableRows.forEach((row) => {
                const cardTitle = row.querySelector('h4').textContent.toLowerCase();

                if (cardTitle.includes(filterText)) {
                    row.parentNode.parentNode.style.display = '';
                } else {
                    row.parentNode.parentNode.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            const table = document.querySelector('.records table');

            // Show or hide "No results" message
            if ([...tableRows].every(row => row.parentNode.parentNode.style.display === 'none')) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    </script>
</body>

</html>

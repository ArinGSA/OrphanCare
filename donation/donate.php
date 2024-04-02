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


        .paid {
            display: inline-block;
            text-align: center;
            font-weight: 600;
            color: var(--main-color);
            background: #e5f8ed;
            padding: .5rem 1rem;
            border-radius: 20px;
            font-size: .8rem;
            transition: 0.3s;
            position: relative;
        }

        .btn2 {
            color: black;
            text-align: center;
            font-size: 16px;
            transition: 0.3s;
            position: relative;
        }

        .paid:hover {
            background-color: green;
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
                    <a href="../cat/cc.php" class="btn">
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
                    <a href="../donation/donate.php" class="active">
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
                    <span class="las la-sign-out-alt"></span>
                    <a href="../start/start.php">
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
            <h1>Donation History</h1>
            <small>Donor / Transaction</small>
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
                <table width="100%" style="top: 435px;position: relative;">
                               
                                <tbody>';


        // session_start();
        if (!isset($_SESSION['userid'])) {
          header("Location: ../tlogin/tlogin.php");
          exit();

}

$userid = $_SESSION['userid'];

        


// ... Your existing PHP code ...

// Assuming $conn is your database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM donation where userid=$userid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {


    echo '<div class="records table-responsive">';
    echo '<div class="record-header">';
    echo '<div class="browse">';
    echo '<input class="record-search" type="text" id="searchInput" oninput="filterTable()" placeholder="Search by trustname">';
    echo '<div id="noResults">No matching results found.</div>';
    echo '</div>';
    echo '</div>';
    echo '<table width="100%" style="top: 321px;position: relative;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>User ID</th>';
    echo '<th style="padding: 1rem 5rem;"> Donor</th>';
    echo '<th style="padding: 1rem 0rem;"> TrustName</th>';
    echo '<th> Donation</th>';
    echo '<th> Date</th>';
    echo '<th> Payment_Id</th>';
    // echo '<th> RECIPT</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $sql3 = "SELECT * FROM trustinfo WHERE trustid = {$row['trustid']}";
                $result22 = $conn->query($sql3);
                $row22 = ($result22) ? $result22->fetch_assoc() : ['trustname' => '']; // Corrected assignment

                $sql4 = "SELECT * FROM trustinfo WHERE trustid = {$row['trustid']}";
                $result33 = $conn->query($sql4);
                $row33 = ($result33) ? $result33->fetch_assoc() : ['pic' => '']; // Corrected assignment
                
                $capitalizedUsername = ucfirst($row['username']);

                echo '<a href="../tform/f2.php?userid=' . $_SESSION['userid'] . '" class="user-link">';


            $sql2 = "SELECT SUM(amount) AS allDonate FROM donation";
            $result2 = $conn->query($sql2);

            $row5 = ($result2) ? $result2->fetch_assoc() : ['allDonate' => 0];
        // ... Your existing PHP code for processing each row ...

        echo '<tr>';
    echo '<td>Don' . $row['id'] . '</td>';
    echo '<td style="width: 22%;">';
    echo '<div class="client">';
    echo '<div class="client-img bg-img" style="background-image: url(\'../trust/tsignup/upload/' . $row33['pic'] . '\')"></div>';
    echo '<div class="client-info">';

    echo '<td >';
    echo '<h4>' . $row22['trustname'] . '</h4>';
    echo '</td>';
    // echo '<small>' . $row['userid'] . '</small>';
    echo '</div>';
    echo '</div>';
    echo '</td>';

    echo '<td>Rs.' . $row['amount'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    // echo '<td><span class="paid">' . $row['payment_id'] . '</span></td>';
    echo '<td>' . $row['payment_id'] . '</td>';
    echo '<td>' ;
    echo '<form action="recipt.php" method="post">';
    echo '<input type="hidden" name="userid" value="' . $userid . '">';
    echo '<input type="hidden" name="donation_id" value="' . $row['id'] . '">';
    // echo '<button type="submit" class="paid" style="right: 36px;position: relative;" name="download">Download Recipt</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    }
}

    echo '</tbody>';
    echo '</table>';
    echo '</div>'; // End of records div


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
            

        
    </div>


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
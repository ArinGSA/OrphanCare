<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Dashboard</title>
    <link rel="stylesheet" href="hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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

?>

<input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="side-header">
        <h3><span>Orphan Care</span></h3>
    </div>

    <div class="side-content">
        <div class="profile">
        <div class="profile-img bg-img" style="background-image: url('../tsignup/upload/<?php echo $row7['pic']; ?>')"></div>

            <h4><?php echo $row6['trustname']; ?></h4>
            <small>Art Director</small>
        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="" class="active">
                        <span class="las la-home"></span>
                        <small>Dashboard</small>
                    </a>
                </li>
                <li>
                    <a href="../tprofile/tpro.php">
                        <span class="las la-user"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="las la-bell"></span>
                        <small>Mailbox</small>
                    </a>
                </li>
                <li>
                    <a href="../tcat/cc.php">
                        <span class="las la-box"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="">
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
                <label for="">
                    <span class="las la-search"></span>
                </label>

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
        
        $selectedCategory = 'mental';
        $sql = "SELECT * FROM trustinfo WHERE category = '$selectedCategory'";
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

                        <div class="record-header">
                            

                            <div class="browse">
                                <input type="search" placeholder="Search" class="record-search">
                                
                            </div>
                        </div>

                        <div>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><span class="las la-sort"></span> TRUST</th>
                                        <th><span class="las la-sort"></span> TOTAL</th>
                                        <th><span class="las la-sort"></span> NUMBER</th>
                                        <th><span class="las la-sort"></span> CATEGORY</th>
                                        <th><span class="las la-sort"></span> ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>';

            while ($row = $result->fetch_assoc()) {
                $trustId = $row['trustid'];

                // Query to select sum of amount from the donation table for each trustid
                $sql1 = "SELECT SUM(amount) AS totalAmount FROM donation WHERE trustid = $trustId";
                $result1 = $conn->query($sql1);

                if ($result1) {
                    $row1 = $result1->fetch_assoc();

                    echo '
                                    <tr>
                                        <td>#5033</td>
                                        <td>
                                            <div class="client">
                                            <div class="client-img bg-img" style="background-image: url(\'../tsignup/upload/' . $row['pic'] . '\')"></div>



                                               
                                                <div class="client-info">
                                                    <a href="u1/u1.php?trustid=' . $row['trustid'] . '">
                                                        <h4>' . $row['trustname'] . '</h4>
                                                        <small>' . $row['mail'] . '</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>' . $row1['totalAmount'] . '</td>
                                        <td>' . $row['phone'] . '</td>
                                        <td>' . $row['category'] . '</td>
                                        <td>
                                            <div class="actions">
                                                <span class="las la-telegram-plane"></span>
                                                <a href="u1/u1.php?trustid=' . $row['trustid'] . '">
                                                <span class="las la-eye"></span>
                                                </a>
                                                <span class="las la-ellipsis-v"></span>
                                            </div>
                                        </td>
                                    </tr>';
                }
            }

            echo '
                                </tbody>
                            </table>
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

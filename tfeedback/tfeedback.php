<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Truste Feedback</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        body{
            overflow-x:hidden;
            overflow-y:hidden;
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

<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['trustid'])) {
    header("Location: ../tlogin/tlogin.php"); // Change login.php to your actual login page
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
                    <a href="../tfeedback/tfeedback.php" class="active">
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
    

    <main>
            
            <div class="page-header" style="top: -47px;position: relative;">
                <h1>Feedback</h1>
                <small>Trust / Feedback</small>
            </div>
            </header>

            
            
            <?php
// session_start();

if (!isset($_SESSION['trustid'])) {
  header("Location: ../tlogin/tlogin.php");
  exit();
}

$trustid = $_SESSION['trustid'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Error in DB connection: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get feedback data from the form
    $rating1 = mysqli_real_escape_string($connection, $_POST['rating1']);
    $rating2 = mysqli_real_escape_string($connection, $_POST['rating2']);
    $commentText = mysqli_real_escape_string($connection, $_POST['commentText']);

    // Prepare and execute the SQL query to insert data into the database
    $insertQuery = "INSERT INTO feedback (type, trustid, rating1, rating2, commentText) VALUES ('trust', '$trustid', '$rating1', '$rating2', '$commentText')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if ($insertResult) {
        echo "Feedback submitted successfully!";
        header("Location: ../thome/thome.php");
    } else {
        echo "Error submitting feedback: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <!--Only for demo purpose - no need to add.-->
    <!-- <link rel="stylesheet" href="css/demo.css" /> -->
</head>
<body>
  
<div class="f">
    <div class="div">
      <!-- <div class="rectangle"></div>	 -->



<section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
       
<div class="feedback">
    <h4>Please rate your service experience for the following parameters</h4>
    <form method="post" action="#action-url">
        <label>1. Your overall experience with us ?</label><br>
        <span class="star-rating">
            <input type="radio" name="rating1" value="1"><i></i>
            <input type="radio" name="rating1" value="2"><i></i>
            <input type="radio" name="rating1" value="3"><i></i>
            <input type="radio" name="rating1" value="4"><i></i>
            <input type="radio" name="rating1" value="5"><i></i>
        </span>
        <div class="clear"></div> 
        <hr class="survey-hr">
        <label>2. Friendliness and courtesy of our app</label><br>
        <span class="star-rating">
            <input type="radio" name="rating2" value="1"><i></i>
            <input type="radio" name="rating2" value="2"><i></i>
            <input type="radio" name="rating2" value="3"><i></i>
            <input type="radio" name="rating2" value="4"><i></i>
            <input type="radio" name="rating2" value="5"><i></i>
        </span>
        <div class="clear"></div> 
        <hr class="survey-hr">
        <label>3. Friendliness and courtesy of our app</label><br><br/>
        <div style="color:grey">
            <span style="float:left">POOR</span>
            <span style="float:right">BEST</span>
        </div>
        <span class="scale-rating">
            <label value="1">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="2">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="3">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="4">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="5">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="6">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="7">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="8">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="9">
                <input type="radio" name="rating">
                <label style="width:100%;"></label>
            </label>
            <label value="10">
                <input type="radio" name="rating" value="10">
                <label style="width:100%;"></label>
            </label>
        </span>
        <div class="clear"></div> 
        <hr class="survey-hr"> 
        <label for="m_3189847521540640526commentText">4. Any Other suggestions:</label><br/><br/>
        <textarea cols="75" name="commentText" style="width: 900px;height: 176px; font-size:25px;" ></textarea><br>
        <br>
        <div class="clear"></div> 
        <input style="background:#43a7d5;color:#fff;padding:12px;border:0" type="submit" value="Submit your review">
        

    </form>
</div>
           
    		</div>
		</div>
    </div>
</section>
     



    <!-- <div class="rectangle-2"></div> -->
  </div>
</div>
                                
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        </main>
        
    </div>



</body>
</html>
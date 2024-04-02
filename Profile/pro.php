<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Donor Profile</title>
    <link rel="stylesheet" href="../hc.css">
    <!-- <link rel="stylesheet" href="tprog.css" /> -->
    <link rel="stylesheet" href="tp1.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
      body
      {
        overflow-x:hidden;
        overflow-y:hidden;
      }

      .placeholder-text 
      {
        color: #888;
      }

      .file-input-container {
    position: relative;
    width: 100%;
    height: 100%;
}

.file-input {
    display: none;
}

.choose-image-btn {
    padding-top: 14px;
    border: none;
    font-size: 15px;
    background-color: #fff;
    position: absolute;
    width: 100%;
    height: 100%;
    cursor: pointer;
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
<body onload="previewImage()">
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

    <div class="side-content" style="background-color: #918ae5;">
        <div class="profile">
        <div class="profile-img bg-img" style="background-image: url('../trust/tsignup/upload/<?php echo $row7['pic']; ?>')"></div>



            <h4><?php echo strtoupper($row6['username']); ?></h4>
            <small><?php echo strtoupper($row10['job']); ?></small>

        </div>

        <div class="side-menu">
            <ul>
                <li>
                    <a href="../home/home.php" class="btn">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../profile/pro.php" class="active">
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
                    <a href="../start/start.php">
                    <span>Logout</span>
                    </a>
                </div>
            </div>
                </div>
            
        </header>
        
        
           
            <div class="page-header" style="padding: 2.5rem 1rem;">
                <h1>Profile</h1>
                <small>Donor / Profile</small>
            </div>
            
            

            <?php
// session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: tpro.php");
    exit();
}

$userid = $_SESSION['userid'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Error in DB connection: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission here
    // Get and sanitize form inputs
    $newusername = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
        $newMail = isset($_POST['mail']) ? mysqli_real_escape_string($conn, $_POST['mail']) : '';
        $newPhone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
        $newArea = isset($_POST['area']) ? mysqli_real_escape_string($conn, $_POST['area']) : '';
        $newgender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : '';
        $newjob = isset($_POST['job']) ? mysqli_real_escape_string($conn, $_POST['job']) : '';
        $newdob = isset($_POST['dob']) ? mysqli_real_escape_string($conn, $_POST['dob']) : '';
        $newage = isset($_POST['age']) ? mysqli_real_escape_string($conn, $_POST['age']) : '';
        $newstates = isset($_POST['states']) ? mysqli_real_escape_string($conn, $_POST['states']) : '';
        $newlives = isset($_POST['lives']) ? mysqli_real_escape_string($conn, $_POST['lives']) : '';

    // Update user data with the new information
    $updateQuery = "UPDATE userinfo SET username='$newusername', mail='$newMail', states='$newstates', lives='$newlives', phone='$newPhone', age='$newage', area='$newArea', gender='$newgender', dob='$newdob', job='$newjob' WHERE userid=$userid";
    $updateResult = mysqli_query($connection, $updateQuery);

   
}

// Fetch the user's current details
$query = "SELECT username, mail, phone, pic, area, age, dob, lives, gender, states, job FROM userinfo WHERE userid = $userid";
$result = mysqli_query($connection, $query);



if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>
    


                            
                        
    <div class="container">






    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signin-form" enctype="multipart/form-data">

            <div class="form first">
                <div class="details personal">
                    <span class="title">Care Details</span>

                    <div class="fields">
                    <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" name="username" style="position: relative; text-align: center;" value="<?php echo $row['username']; ?>" placeholder="Enter Your username" required>
                            <img class="screenshot" id="preview-pic" src="../trust/tsignup/upload/<?php echo $row7['pic']; ?>">

                            <img class="screenshot" id="preview-pic" src="<?php echo $imageSource; ?>">
                        </div>

                        <div class="input-field">
                            <label>Lives in</label>
                            <input type="text" name="lives" style="position: relative; text-align: center;" value="<?php echo !empty($row['lives']) ? $row['lives'] : ''; ?>" placeholder="Enter Living area" required>
                        </div>


                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="mail" style="position: relative; text-align: center;" value="<?php echo $row['mail']; ?>" placeholder="Enter Your Mail" required>
                        </div>

                        <div class="input-field">
                            <label>Occupation</label>
                            <input type="text" name="job" style="position: relative; text-align: center;" value="<?php echo $row['job']; ?>" placeholder="Enter Your Number" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="tel" name="phone" style="position: relative; text-align: center;" value="<?php echo $row['phone']; ?>" placeholder="Enter Your Phone" pattern="[0-9]{10}" title="Please enter a 10-digit number" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Personal Details</span>
                    

                    <div class="fields">
                        <div class="input-field">
                            <label>Relation</label>
                            <select name="age" required>
                                <option value="maried" style="position: relative; text-align: center;" <?php echo ($row['age'] === 'maried') ? 'selected' : ''; ?>>maried</option>
                                <option value="single" style="position: relative; text-align: center;" <?php echo ($row['age'] === 'single') ? 'selected' : ''; ?>>single</option>
                                <option value="divoresd" style="position: relative; text-align: center;" <?php echo ($row['age'] === 'divoresd') ? 'selected' : ''; ?>>divoresd </option>
                            </select>

                        </div>

                        <div class="input-field">
                            <label>dob</label>
                            <input type="date" style="position: relative; text-align: center;" name="dob" value="<?php echo $row['dob']; ?>" placeholder="Enter Your dob" required>
                        </div>

                        <div class="input-field">
                                <label>Gender</label>
                                <select name="gender" required>
                                    <option value="male" style="position: relative; text-align: center;" <?php echo ($row['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" style="position: relative; text-align: center;" <?php echo ($row['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="others" style="position: relative; text-align: center;" <?php echo ($row['gender'] === 'others') ? 'selected' : ''; ?>>Others </option>
                                </select>
                        </div>
                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="area" style="position: relative; text-align: center;" value="<?php echo $row['area']; ?>" placeholder="Enter Your Location" required>
                        </div>

                        <div class="input-field">
                        <label>State</label>
    <select name="states" required>
        <?php
        $states = array(
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
            "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan",
            "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh",
            "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands",
            "Chandigarh", "Dadra and Nagar Haveli", "Daman and Diu", "Lakshadweep",
            "Delhi", "Puducherry"
        );

        foreach ($states as $state) {
            $selected = ($row['states'] === $state) ? 'selected' : '';
            echo "<option value=\"$state\" $selected>$state</option>";
        }
        ?>
    </select>
                        </div>

                    </div>

                    <img
              >
              <div class="profile-img-container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $updateQuery = "UPDATE userinfo SET username='$newusername', mail='$newMail', phone='$newPhone', age='$newage', area='$newArea', gender='$newgender',job='$newjob', dob='$newdob' WHERE userid=$userid";

        $updateResult = mysqli_query($connection, $updateQuery);

    // Handle file upload
    if ($_FILES['pic']['error'] == 0) {
        $targetDir = '../trust/tsignup/upload/';
        $targetFile = $targetDir . basename($_FILES['pic']['name']);
        move_uploaded_file($_FILES['pic']['tmp_name'], $targetFile);

        // Update the 'pic' column in the database
        $updatePicQuery = "UPDATE userinfo SET pic='" . basename($_FILES['pic']['name']) . "' WHERE userid=$userid";
        $updatePicResult = mysqli_query($connection, $updatePicQuery);

        
    }
}
    ?>
    <div class="file-input-container">
    <input class="file-input" type="file" name="pic" id="pic" >
    <button class="nextBtn" style="left: 40%;position: relative;top: -97px;background-color: #797979;" type="button" onclick="document.getElementById('pic').click()">Choose Image</button>
</div>


</div>

                    <button class="nextBtn" style="left: 40%;top: -71px;position: relative;" type="submit" name="submit">
    <span class="btnText1">Complete</span>
    <i class="uil uil-navigator"></i>
</button>
                </div> 
            </div>
            
            <?php
    } else {
        echo "Data not found";
    }

    mysqli_close($connection);
    ?>



            
</tbody>
                        </table>
                    </div>

                </div>
            
            </div>
            
        <!-- </main> -->
        
    </div>
    </div> <!-- Close the main-content div -->

    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active1");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

    // Prevent form submission when clicking "Needs" button
    var needsButton = document.querySelector(".accordion");
    needsButton.addEventListener("click", function(e) {
        e.preventDefault();
    });

    function previewImage() {
        var fileInput = document.getElementById('pic');
        var preview = document.getElementById('preview-pic');

        fileInput.addEventListener('change', function () {
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

</script>

</body> <!-- Close the body tag -->
</html>
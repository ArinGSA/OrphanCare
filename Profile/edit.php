<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="../hc.css">
    <!-- <link rel="stylesheet" href="tprog.css" /> -->
    <link rel="stylesheet" href="tpros.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- <link rel="stylesheet" href="tprog.css" /> -->
    <link rel="stylesheet" href="tpros.css" />
    <style>
      body{
        overflow:hidden;
      }

      .btn {
          background-color: #8984e2;
          border-radius: 10px;
          color: black;
          text-align: center;
          font-size: 16px;
          
          transition: 0.3s;
          position: relative;

          /* margin: 4px 2px; */
          /* padding: 22px 61px; */
          /* left: -24px; */
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
if (!isset($_SESSION['userid'])) {
    header("Location: ../login/login.php"); // Change login.php to your actual login page
    exit();
}

$userid = $_SESSION['userid'];

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
                    <a href="../Profile/pro.php" class="active">
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
                    <span>Logout</span>
                </div>
            </div>
            </div>
        </div>
        
        
        <main>
            
            <div class="page-header" style="
    left: 164px;
    position: relative;
">
                <h1>Profile</h1>
                <small>Donor / Profile</small>
            </div>
            
            

            <?php
// session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../Profile/pro.php");
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
    $newUsername = mysqli_real_escape_string($connection, $_POST['username']);
    $newMail = mysqli_real_escape_string($connection, $_POST['mail']);
    $newPhone = mysqli_real_escape_string($connection, $_POST['phone']);
    $newArea = mysqli_real_escape_string($connection, $_POST['area']);
    $newjob = mysqli_real_escape_string($connection, $_POST['job']);
    $newage = mysqli_real_escape_string($connection, $_POST['age']);
    $newdob = mysqli_real_escape_string($connection, $_POST['dob']);
    $newgender = mysqli_real_escape_string($connection, $_POST['gender']);
    $newstates = mysqli_real_escape_string($connection, $_POST['states']);
    
    

    // Update user data with the new information
    $updateQuery = "UPDATE userinfo SET username='$newUsername', mail='$newMail', phone='$newPhone', area='$newArea', job='$newjob', age='$newage', dob='$newdob', gender='$newgender'  WHERE userid=$userid";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Check if a new profile picture was uploaded
        if ($_FILES['pic']['error'] === 0) {
            $filename = mysqli_real_escape_string($connection, $_FILES['pic']['name']);
            move_uploaded_file($_FILES["pic"]["tmp_name"], '../trust/tsignup/upload/' . $filename);
            // Update the pic field in the database
            $updatePicQuery = "UPDATE userinfo SET pic='$filename' WHERE userid=$userid";
            mysqli_query($connection, $updatePicQuery);
        }

        

        header("Location: ../Profile/pro.php");
        exit();
    } else {
        echo 'Error updating data: ' . mysqli_error($connection);
    }
}

// Fetch the user's current details
$query = "SELECT username, mail, phone, pic, job, area, dob, age, gender FROM userinfo WHERE userid = $userid"; // Modify the query according to your database schema
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>




<div class="t-profile-edit">
          <div class="div">
          <div class="double-lined-rectangle"> </div>
            <img
              class="screenshot"
              src="https://c.animaapp.com/bjeG0MyZ/img/screenshot-2023-08-26-114804-removebg-preview-1@2x.png"
            />
            <img class="screenshot" id="preview-pic" src="<?php echo $imageSource; ?>">
            
            <form action="" method="post" class="signin-form" enctype="multipart/form-data">

            <div class="group">
              </div>
              <button class="overlap-group" type="submit" style=" margin-top: 800px; margin-right:796px; font-size:20px; position: relative; left: 905px; top: -164px" name="submit">Complete</button>
            </div>
            
            <div class="group-2">
            
              <div class="overlap-group-wrapper">
              </div>
              <div class="div-wrapper">
                <div class="overlap-group-2">
                  <div class="group-4">
                    <div class="group-5">
                    <div class="text-wrapper-3">
                    <input type="date" name="dob" style="padding-top: 14px; border:none; font-size: 30px; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['dob']; ?>" placeholder="Enter Your CT Info Here">
                        </div>

                    <div class="text-wrapper-2">
                      <input type="text" name="job" style="padding-top: 14px; border:none; font-size: 30px; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['job']; ?>" placeholder="Enter Your job Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                    <div class="group-6">
                    <div class="text-wrapper-2">
                    <input type="text" name="area" style="padding-top: 14px; font-size: 30px; border:none; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['area']; ?>" placeholder="Enter Your area Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-4@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                  </div>
                <div class="text-wrapper-4">
                  <input type="text" style="padding-top: 14px; border:none; font-size: 30px; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                  name="age" value="<?php echo $row['age']; ?>" placeholder="Enter Your age Info Here">
                        </div>
                </div>
              </div>
            </div>                    
                 
            


    <div class="group-7">
        <div class="group-3">
    <div class="text-wrapper-2">
    
            </div>

              </div>
            <div class="div-wrapper" style="top: 296px;">
                <div class="overlap-group-2">
                  <div class="group-4">
                    <div class="group-5">
                    <div class="text-wrapper-3">
                        <input type="text" name="gender" style="padding-top: 14px; font-size: 30px; border:none; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['gender']; ?>" placeholder="Enter Your gender Here">
                        </div>

                        <div class="text-wrapper-2">
                        <input type="text" name="phone" style="padding-top: 14px; border:none; font-size: 30px; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['phone']; ?>" placeholder="Enter Your Phone Here">
                        </div>
                            <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                            <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                    <div class="group-6">
                    <div class="text-wrapper-2">
                    <input type="text" name="username" style="padding-top: 14px; font-size: 30px; border:none; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                            value="<?php echo $row['username']; ?>" placeholder="Enter Your Name Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-4@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                  </div>
                  <div class="text-wrapper-4">
                  <input type="text" name="mail" style="padding-top: 14px; border:none; font-size: 30px; background-color: #fff; margin-top: -31px; width: 300px; height: 60px;"
                    value="<?php echo $row['mail']; ?>" placeholder="Enter Your Mail Here">
                </div>
                </div>
                </div>
            </div>
            <img class="category" src="https://c.animaapp.com/bjeG0MyZ/img/icons8-category-50-3@2x.png" />

            <div class="user-wrapper">
            <?php
              if (!empty($row['pic'])) {
                echo '<img id="preview-pic" width="150px" height="145"  src="../trust/tsignup/upload/' . $row['pic'] . '" alt="Profile Picture" style="
                border-radius: 30px;
                border-style: double;
                border-width: 4px;">';
              } else {
                echo '<img id="preview-pic" width="150px" height="145" radius="40px" src="../trust/tsignup/upload/default_profile.jpg" alt="Default Profile Picture">';
              }
              ?>  
                        <input type="file" name="pic" id="pic" style="padding-top: 14px; border:none; font-size: 15px; background-color: #fff; left: 25px; margin-top: -31px; width: 100px; height: 60px; top:17px; position:relative;">
                    
                            </div>
                            <!-- <div class="text-wrapper-5">Profile</div> -->
                    </div>
                </form>
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
            
        </main>
        
    </div>
    <script>

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
</body>
</html>
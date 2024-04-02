<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="hc.css">
    <!-- <link rel="stylesheet" href="tprog.css" /> -->
    <link rel="stylesheet" href="tpros.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
        body{
            overflow-y:hidden;
            overflow-x:hidden;
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
                    <a href="../thome/thome.php">
                            <span class="las la-home"></span>
                            <small>Home</small>
                        </a>
                    </li>
                    <li>
                       
                       <a href="" class="active">
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
        
        
        
        
        <main>
            
            <div class="page-header">
                <h1>Profile</h1>
                <small>Donor / Profile</small>
            </div>
            
            

            <?php
// session_start();

if (!isset($_SESSION['trustid'])) {
    header("Location: tprofile.php");
    exit();
}

$trustid = $_SESSION['trustid'];

$servername = "localhost";
$trustname = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $trustname, $password, $database);

if (!$connection) {
    die("Error in DB connection: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission here
    // Get and sanitize form inputs
    $newtrustname = mysqli_real_escape_string($connection, $_POST['trustname']);
    $newMail = mysqli_real_escape_string($connection, $_POST['mail']);
    $newPhone = mysqli_real_escape_string($connection, $_POST['phone']);
    $newArea = mysqli_real_escape_string($connection, $_POST['area']);
    $newUpi = mysqli_real_escape_string($connection, $_POST['upi']);
    $newAcc = mysqli_real_escape_string($connection, $_POST['acc']);
    $newCt = mysqli_real_escape_string($connection, $_POST['ct']);
    $newMembers = mysqli_real_escape_string($connection, $_POST['members']);
    $newCategory = mysqli_real_escape_string($connection, $_POST['category']);
    $newNeed1 = mysqli_real_escape_string($connection, $_POST['need1']);
    $newNeed2 = mysqli_real_escape_string($connection, $_POST['need2']);
    $newNeed3 = mysqli_real_escape_string($connection, $_POST['need3']);
    $newNeed4 = mysqli_real_escape_string($connection, $_POST['need4']);

    // Update user data with the new information
    $updateQuery = "UPDATE trustinfo SET trustname='$newtrustname', mail='$newMail', phone='$newPhone', category='$newCategory', area='$newArea', upi='$newUpi', acc='$newAcc', ct='$newCt', members='$newMembers', need1='$newNeed1',need2='$newNeed2',need3='$newNeed3',need4='$newNeed4' WHERE trustid=$trustid";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Check if a new profile picture was uploaded
        if ($_FILES['pic']['error'] === 0) {
            $filename = mysqli_real_escape_string($connection, $_FILES['pic']['name']);
            move_uploaded_file($_FILES["pic"]["tmp_name"], '../tsignup/upload/' . $filename);
            // Update the pic field in the database
            $updatePicQuery = "UPDATE trustinfo SET pic='$filename' WHERE trustid=$trustid";
            mysqli_query($connection, $updatePicQuery);
        }

        header("Location: tpro.php");
        exit();
    } else {
        echo 'Error updating data: ' . mysqli_error($connection);
    }
}

// Fetch the user's current details
$query = "SELECT trustname, mail, phone, pic, upi, area, ct, acc, members, category, need1, need2, need3, need4 FROM trustinfo WHERE trustid = $trustid"; // Modify the query according to your database schema
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
        <form action="" method="post" class="signin-form" enctype="multipart/form-data">
            <div class="group">
              </div>
              <button class="btn" style="background-color: #4d3ed9;color: white;margin-top: 800px;margin-right:796px;font-size:20px;width: 122px;height: 48px;position: relative;left: 745px;top: -117px;border-radius: 10px;" name="submit">Complete</button>
            </div>
            
            <div class="group-2">
            
              <!-- <div class="overlap-group-wrapper"> -->
              <div class="group-3">
              <button class="accordion" style="border: double;width: 351px;">Needs</button>
              <div class="panel">
              <p><input type="text" name="need1" value="<?php echo $row['need1']; ?>" placeholder="Enter Your UPI Here"></p>
              <p><input type="text" name="need2"  value="<?php echo $row['need2']; ?>" placeholder="Enter Your UPI Here"></p>
              <p><input type="text" name="need3" value="<?php echo $row['need3']; ?>" placeholder="Enter Your UPI Here"></p>
              <p><input type="text" name="need4" value="<?php echo $row['need4']; ?>" placeholder="Enter Your UPI Here"></p>
              </div>
              </div>
              <div class="div-wrapper">
                <div class="overlap-group-2">
                  <div class="group-4">
                    <div class="group-5">
                    <div class="text-wrapper-3">
                    <input type="text" name="ct" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 340px; height: 60px;"
                            value="<?php echo $row['ct']; ?>" placeholder="Enter Your CT Info Here">
                        </div>

                    <div class="text-wrapper-2">
                      <input type="text" name="upi" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['upi']; ?>" placeholder="Enter Your UPI Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                    <div class="group-6">
                    <div class="text-wrapper-2">
                    <input type="text" name="area" style="padding-top: 14px; font-size: 20px; border:none; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['area']; ?>" placeholder="Enter Your Needs Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-4@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                  </div>
                <div class="text-wrapper-4">
                  <input type="text" name="acc" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['acc']; ?>" placeholder="Enter Your Account Info Here">
                        </div>
                </div>
              </div>
            </div>                    
                 
            


    <div class="group-7">
        <div class="group-3">
    <div class="text-wrapper-2">
    <input type="text" name="category" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['category']; ?>" placeholder="Category">
            </div>
                <img class="line" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
              </div>
            <div class="div-wrapper">
                <div class="overlap-group-2">
                  <div class="group-4">
                    <div class="group-5">
                    <div class="text-wrapper-3">
                        <input type="text" style="padding-top: 14px; font-size: 20px; border:none; background-color: #fff; margin-top: -31px; width: 340px; height: 60px;"
                        name="members" value="<?php echo $row['members']; ?>" placeholder="Enter Your Members Here">
                        </div>

                        <div class="text-wrapper-2">
                        <input type="text" name="phone" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['phone']; ?>" placeholder="Enter Your Phone Here">
                        </div>
                            <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                            <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                    <div class="group-6">
                    <div class="text-wrapper-2">
                    <input type="text" name="trustname" style="padding-top: 14px; font-size: 20px; border:none; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                            value="<?php echo $row['trustname']; ?>" placeholder="Enter Your Name Here">
                        </div>
                      <img class="img" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-4@2x.png" />
                      <img class="line-2" src="https://c.animaapp.com/bjeG0MyZ/img/line-1-5@2x.png" />
                    </div>
                  </div>
                  <div class="text-wrapper-4">
                  <input type="text" name="mail" style="padding-top: 14px; border:none; font-size: 20px; background-color: #fff; margin-top: -31px; width: 400px; height: 60px;"
                    value="<?php echo $row['mail']; ?>" placeholder="Enter Your Mail Here">
                </div>
                </div>
                </div>
            </div>
            <img class="category" src="https://c.animaapp.com/bjeG0MyZ/img/icons8-category-50-3@2x.png" />
            <!-- <div class="rectangle"></div> -->
            <!-- <div class="rectangle-2"></div> -->
            <div class="user-wrapper">

                        
                        <input type="file" name="pic" id="pic" style="padding-top: 14px; border:none; font-size: 15px; background-color: #fff; left: 25px; margin-top: -31px; width: 100px; height: 60px; top:168px; position:relative;">
                            <?php
                            if (!empty($row['pic'])) {echo '<img id="preview-pic" width="150px" height="145" style="border-radius: 30px;border-style: double;border-width: 4px;top: -40px;position: relative;" radius="40px" position:relative; top="-45";  src="../tsignup/upload/' . $row['pic'] . '" alt="Profile Picture" style="border-radius: 30px;border-style: double;border-width: 4px;" >';}
                            ?>
                            </div>
                            
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
var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

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


    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Trust Profile</title>
    <link rel="stylesheet" href="../hc.css">
    <!-- <link rel="stylesheet" href="tprog.css" /> -->
    <link rel="stylesheet" href="tp1.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
      body
      {
        /* overflow-x:hidden;
        overflow-y:hidden; */
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

        .panel {
    top: 520px;
    /* left: 826px; */
    padding: 0 18px;
    background-color: white;
    display: none;
    overflow: hidden;
}

.accordion {
  background-color: #fff;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
  top: 439px;
}

.needs-container {
    display: flex;
    flex-wrap: wrap;
}

.need-input {
    flex: 0 0 calc(48% - 131px); /* Adjust the width of each need input as needed and subtract 1px for the space */
    margin: 0.5em 0.5em 0.5em 0; /* Adjust the margin for top, right, bottom, and left */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}

.need-input label {
    display: block;
}


/* Adjust styling as needed */

    </style>


</head>
<body onload="previewImage()">
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

    <div class="side-content" style="background-color: #918ae5;">
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
                    <a href="../tprofile/tpro.php" class="active">
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
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url('../tsignup/upload/<?php echo $row7['pic']; ?>')"></div>
                        
                        <span class="las la-power-off"></span>
                        <a href="../../start/start.php">
                        <span>Logout</span>
                      </a>
                    </div>
                </div>
            </div>
        </header>
        
        
           
            <div class="page-header" style="padding: 2.3rem 1rem;">
                <h1>Profile</h1>
                <small>Trustee / Profile</small>
            </div>
            
            

            <?php
// session_start();

if (!isset($_SESSION['trustid'])) {
    header("Location: tpro.php");
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
    $newfor1 = mysqli_real_escape_string($connection, $_POST['for1']);
    $newMembers = mysqli_real_escape_string($connection, $_POST['members']);
    $newCategory = mysqli_real_escape_string($connection, $_POST['category']);
    $newstatus1 = mysqli_real_escape_string($connection, $_POST['status1']);
    $newNeed1 = mysqli_real_escape_string($connection, $_POST['need1']);
    $newNeed2 = mysqli_real_escape_string($connection, $_POST['need2']);
    $newNeed3 = mysqli_real_escape_string($connection, $_POST['need3']);
    $newNeed4 = mysqli_real_escape_string($connection, $_POST['need4']);
    

    $newNeed5 = isset($_POST['need5']) ? array_map(function($value) use ($connection) { return mysqli_real_escape_string($connection, $value); }, $_POST['need5']) : array();


    // Update user data with the new information
    $updateQuery = "UPDATE trustinfo SET trustname='$newtrustname', mail='$newMail', phone='$newPhone', category='$newCategory', area='$newArea', upi='$newUpi', acc='$newAcc', ct='$newCt', members='$newMembers', need1='$newNeed1',need2='$newNeed2',need3='$newNeed3',need4='$newNeed4', need5='$newNeed5', status1='$newstatus1', for1='$newfor1' WHERE trustid=$trustid";
    $updateResult = mysqli_query($connection, $updateQuery);

   
}

// Fetch the user's current details
$query = "SELECT trustname, mail, phone, pic, upi, area, ct, acc, for1, members, category, need1, need2, need3, status1, need4, need5 FROM trustinfo WHERE trustid = $trustid";
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
                            <input type="text" name="trustname" style="position: relative; text-align: center;" value="<?php echo $row['trustname']; ?>" placeholder="Enter Your TrustName" required>
                            <img class="screenshot" id="preview-pic" src="../tsignup/upload/<?php echo $row7['pic']; ?>">

                            <img class="screenshot" id="preview-pic-1" src="<?php echo $imageSource; ?>">
                        </div>

                        <div class="input-field">
                            <label>Account Number</label>
                            <input type="text" name="acc" style="position: relative; text-align: center;" value="<?php echo $row['acc']; ?>" placeholder="Enter Account Number" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="mail" style="position: relative; text-align: center;" value="<?php echo $row['mail']; ?>" placeholder="Enter Your Mail" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="phone" style="position: relative; text-align: center;" value="<?php echo $row['phone']; ?>" placeholder="Enter Your Number" required>
                        </div>

                        <div class="input-field">
                            <label>UPI ID</label>
                            <input type="text" name="upi" style="position: relative; text-align: center;" value="<?php echo $row['upi']; ?>" placeholder="Enter Your UPI Number" required>
                        </div>

                        <div class="input-field">
                            <label>Status</label>
                            <input type="text" name="status1" style="position: relative; text-align: center;" value="<?php echo $row['status1']; ?>" placeholder="Enter Your status1" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Other Details</span>
                    

                <div class="fields">
                    <div class="input-field">
                            <label>Category</label>
                            <select name="category" style="position: relative; text-align: center;" required>
                                <option value="old" <?php echo ($row['category'] === 'old') ? 'selected' : ''; ?>>Old Age</option>
                                <option value="women" <?php echo ($row['category'] === 'women') ? 'selected' : ''; ?>>Women Care</option>
                                <option value="mental" <?php echo ($row['category'] === 'mental') ? 'selected' : ''; ?>>Mental </option>
                                <option value="handicap" <?php echo ($row['category'] === 'handicap') ? 'selected' : ''; ?>>Handicap </option>
                                <option value="private" <?php echo ($row['category'] === 'private') ? 'selected' : ''; ?>>Private Care</option>
                                <option value="child" <?php echo ($row['category'] === 'child') ? 'selected' : ''; ?>>Child Care</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Members</label>
                            <input type="number" name="members" style="position: relative; text-align: center;" value="<?php echo $row['members']; ?>" placeholder="Enter Your Members" required>
                        </div>

                        <div class="input-field">
                            <label>CareTaker</label>
                            <input type="text" name="ct" style="position: relative; text-align: center;" value="<?php echo $row['ct']; ?>" placeholder="Enter CareTakers name" required>
                        </div>

                        <div class="input-field">
                            <label>Only For</label>
                            <input type="text" name="for1" style="position: relative; text-align: center;" value="<?php echo $row['for1']; ?>" placeholder="For whome" required>
                        </div>

                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="area" style="position: relative; text-align: center;" value="<?php echo $row['area']; ?>" placeholder="Enter Your Location" required>
                        </div>

                        <div class="input-field">
                            <button class="accordion" style="border: double;max-width: 354px;z-index: 1;position: fixed;top: 52.4%;background-color: #848993;">Needs</button>
                                <div class="panel" style="position: fixed;display: none;z-index: 1;left: 700px;top: 500px;width: 456px;">
                                <div class="needs-container">
                                    <div class="need-input">
                                        <label for="need1">Need 1</label>
                                        <input type="text" name="need1" value="<?php echo $row['need1']; ?>" placeholder="Enter Your needs Here">
                                    </div>
                                    <div class="need-input">
                                        <label for="need2">Need 2</label>
                                        <input type="text" name="need2" value="<?php echo $row['need2']; ?>" placeholder="Enter Your needs Here">
                                    </div>
                                    <div class="need-input">
                                        <label for="need3">Need 3</label>
                                        <input type="text" name="need3" value="<?php echo $row['need3']; ?>" placeholder="Enter Your needs Here">
                                    </div>
                                    <div class="need-input">
                                        <label for="need4">Need 4</label>
                                        <input type="text" name="need4" value="<?php echo $row['need4']; ?>" placeholder="Enter Your needs Here">
                                    </div>
                                </div>

                                    <div id="dynamicInputs" class="need-input"></div>
                                        <!-- Button to add more input tags -->
                                        <button type="button" onclick="addInput()">Add Input</button>

                                </div>
                
                        </div>
                    </div>
</div>

                    <img
              >
              <div class="profile-img-container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $updateQuery = "UPDATE trustinfo SET trustname='$newtrustname', mail='$newMail', phone='$newPhone', category='$newCategory', area='$newArea', upi='$newUpi', acc='$newAcc', ct='$newCt', members='$newMembers', need1='$newNeed1',need2='$newNeed2',need3='$newNeed3',need4='$newNeed4', need5='$newNeed5', status1='$newstatus1', for1='$newfor1' WHERE trustid=$trustid";
    $updateResult = mysqli_query($connection, $updateQuery);

    // Handle file upload
    if ($_FILES['pic']['error'] == 0) {
        $targetDir = '../tsignup/upload/';
        $targetFile = $targetDir . basename($_FILES['pic']['name']);
        move_uploaded_file($_FILES['pic']['tmp_name'], $targetFile);

        // Update the 'pic' column in the database
        $updatePicQuery = "UPDATE trustinfo SET pic='" . basename($_FILES['pic']['name']) . "' WHERE trustid=$trustid";
        $updatePicResult = mysqli_query($connection, $updatePicQuery);

        
    }
}
    ?>
<div class="file-input-container">
    <input class="file-input" type="file" name="pic" id="pic" >
    <button class="nextBtn" style="left: 73px;position: relative;" type="button" onclick="document.getElementById('pic').click()">Choose Image</button>
</div>


</div>

        <button class="nextBtn" style="left: 40%; top: -71px;position: relative;" type="submit" name="submit">
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

<script>
    function addInput() {
      // Create a new input element
      var input = document.createElement("input");
      input.type = "text";
      input.name = "need5[]";
      value="<?php echo implode(', ', $row['need5']); ?>";
      input.placeholder = "Dynamic Input";

      // Append the new input element to the container
      document.getElementById("dynamicInputs").appendChild(input);
    }

    document.addEventListener('DOMContentLoaded', function () {
    // Load previously added dynamic inputs from local storage
    loadDynamicInputs();

    // Add event listener for the "Needs" button
    var needsButton = document.querySelector(".accordion");
    needsButton.addEventListener("click", function(e) {
        e.preventDefault();
    });

    // Add event listener for form submission
    var form = document.querySelector(".signin-form");
    form.addEventListener("submit", function() {
        // Save dynamic inputs to local storage
        saveDynamicInputs();
    });

    // Function to load dynamic inputs from local storage
    function loadDynamicInputs() {
        var dynamicInputsContainer = document.getElementById("dynamicInputs");

        // Retrieve dynamic inputs from local storage
        var storedInputs = localStorage.getItem("dynamicInputs");

        if (storedInputs) {
            dynamicInputsContainer.innerHTML = storedInputs;
        }
    }

    // Function to save dynamic inputs to local storage
    function saveDynamicInputs() {
        var dynamicInputsContainer = document.getElementById("dynamicInputs");

        // Save dynamic inputs to local storage
        localStorage.setItem("dynamicInputs", dynamicInputsContainer.innerHTML);
    }

    function addInput() {
        // Create a new input element
        var input = document.createElement("input");
        input.type = "text";
        input.name = "dynamicInput";
        input.placeholder = "Dynamic Input";

        // Append the new input element to the container
        document.getElementById("dynamicInputs").appendChild(input);

        // Save dynamic inputs to local storage after adding a new input
        saveDynamicInputs();
    }
});

  </script>

</body> <!-- Close the body tag -->
</html>
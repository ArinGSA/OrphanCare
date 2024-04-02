<?php
session_start(); // Start the session

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['trustid'])) {
    header("Location: login.php"); // Change login.php to your actual login page
    exit();
}

$trustid = $_SESSION['trustid'];

// Database connection
$servername = "localhost";
$trustname = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $trustname, $password, $database);

if (!$connection) {
    die("Connection failed: " . $conn->connect_error);
}



// Retrieve user profile information
$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $connection->query($sql2);

$row6 = ($result2) ? $result2->fetch_assoc() : ['trustname' => '']; // Corrected assignment

$sql2 = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result2 = $connection->query($sql2);

$row7 = ($result2) ? $result2->fetch_assoc() : ['pic' => '']; // Corrected assignment
?>


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







        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
        }

        input[type="submit"], .create-tags-btn, .plus-btn, .minus-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        input[type="submit"]:hover, .create-tags-btn:hover, .plus-btn:hover, .minus-btn:hover {
            background-color: #45a049;
        }

        .tag-buttons {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .plus-btn, .minus-btn {
            font-size: 16px;
            margin-right: 5px;
        }

        .container1 form {
            position: relative;
            margin-top: 16px;
            
            background-color: #fff;
            overflow: hidden;
        }
        .container1 {
            position: fixed;
            left: 84%;
            top: 64.5%;
            transform: translate(-50%, -50%);
            max-width: 519px;
            width: 100%;
            max-height: 68vh;
            overflow-y: auto;
            border-radius: 75px;
            padding: 115px 2rem;
            margin: 0 15px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            scrollbar-width: thin;
            scrollbar-color: #737373 #f0f0f0;
        }
        

        .container1::-webkit-scrollbar-thumb {
    /* background-color: transparent; Transparent background */
    border: 2px solid #737373; /* Border to simulate height */
    border-radius: 4px; /* Adjust the border-radius for a rounded thumb */
    box-shadow: inset 0 0 0 4px #f0f0f0; /* Simulate height with box-shadow */
}

        .container1::-webkit-scrollbar-thumb {
            background-color: #737373; /* Color of the thumb */
        }

        .container1::-webkit-scrollbar-track {
            background-color: #f0f0f0; /* Color of the track */
        }

        /* Move the scrollbar a little to the left */
        .container1::-webkit-scrollbar {
    width: 6px; /* Adjust the width as needed */
    right: 11; /* Move the scrollbar to the right edge */
}

        .container1::-webkit-scrollbar-button {
        /* width: 50px; //for horizontal scrollbar */
        height: 48px; //for vertical scrollbar
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
    </style>


</head>
<body onload="previewImage()">

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
    
    <div class="main-content" style="top: 63px;position: relative;">
        
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
                <h1>Profile</h1>
                <small>Trust / Profile</small>
            </div>
            </header>                        

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
    $newStates = mysqli_real_escape_string($connection, $_POST['states']);
    $newUpi = mysqli_real_escape_string($connection, $_POST['upi']);
    $newAcc = mysqli_real_escape_string($connection, $_POST['acc']);
    $newCt = mysqli_real_escape_string($connection, $_POST['ct']);
    $newfor1 = mysqli_real_escape_string($connection, $_POST['for1']);
    $newMembers = mysqli_real_escape_string($connection, $_POST['members']);
    $newCategory = mysqli_real_escape_string($connection, $_POST['category']);
    $newstatus1 = mysqli_real_escape_string($connection, $_POST['status1']);
    // $newneed5 = mysqli_real_escape_string($connection, $_POST['need5']);


    // Update user data with the new information
    $updateQuery = "UPDATE trustinfo SET trustname='$newtrustname', mail='$newMail', phone='$newPhone', category='$newCategory', area='$newArea', states='$newStates', upi='$newUpi', acc='$newAcc', ct='$newCt', members='$newMembers', status1='$newstatus1', for1='$newfor1' WHERE trustid=$trustid";
    $updateResult = mysqli_query($connection, $updateQuery);

   
}

// Fetch the user's current details
$query = "SELECT trustname, mail, phone, pic, upi, area, states, ct, acc, for1, members, category,status1, need5 FROM trustinfo WHERE trustid = $trustid";
$result = mysqli_query($connection, $query);



if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>





<div class="container1">

<body>
<span class="t1" >Needs</span>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
    <div style="top: 21px;position: relative;">
    <p>Total No of Needs: <?php echo max(0, $numInputTags - 1); ?></p>
    <div class="columns">

    <?php
    // Display input fields based on the user's request
    for ($i = 2; $i <= $numInputTags; $i++) {
        $value = isset($existingData[$i - 1]) ? htmlspecialchars($existingData[$i - 1]) : '';
        echo '<div class="column"><input type="text" name="input_' . $i . '" placeholder="Input ' . $i . '" style="border: groove;" value="' . $value . '"><br></div>';
    }
    ?>
    </div>
<?php
echo '<a href="needs.php?trustid=' . $_SESSION['trustid'] . '" class="active">
<span style="
    font-weight: 600;
    margin: 6px 0;
    border: double;
    max-width: 260px;
    height: 48px;
    width: 100%;
    position: fixed;
    left: 27%;
    /* top: 77px; */
    color: #fff;
    font-size: larger;
    z-index: 1;
    background-color: #3f6eef;
    display: flex;
    align-items: center;
    justify-content: center;
">Needs</span> </a>';
?>
    </div> 
</form>

</div>
                         
                        
<div class="container" style="padding: 40px 2rem;top: 353px;">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signin-form" enctype="multipart/form-data" style="width: 956px;max-width: 100%;">

            <div class="form first">
                <div class="details personal">
                    <span class="title">Care Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" name="trustname" style="position: relative; text-align: center;" value="<?php echo $row['trustname']; ?>" placeholder="Enter Your TrustName" required>
                            <img class="screenshot" style="top: -3%;" id="preview-pic" src="../tsignup/upload/<?php echo $row7['pic']; ?>">

                            <img class="screenshot" style="top: -3%;" id="preview-pic" src="<?php echo $imageSource; ?>">
                            
                        </div>

                        <div class="input-field">
                            <label>Account Number</label>
                            <input type="text" name="acc" style="position: relative; text-align: center;" value="<?php echo $row['acc']; ?>" placeholder="Enter Account Number" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="mail" style="position: relative; text-align: center;" value="<?php echo $row['mail']; ?>" placeholder="Enter Your Mail" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="tel" name="phone" style="position: relative; text-align: center;" value="<?php echo $row['phone']; ?>" placeholder="Enter Your Number" pattern="[0-9]{10}" title="Please enter a 10-digit number" required>

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

    $updateQuery = "UPDATE trustinfo SET trustname='$newtrustname', mail='$newMail', phone='$newPhone', category='$newCategory', area='$newArea', states='$newStates', upi='$newUpi', acc='$newAcc', ct='$newCt', members='$newMembers',status1='$newstatus1', for1='$newfor1' WHERE trustid=$trustid";
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

            
        
        
    </div>
    </main>
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
    function changeTags(change) {
        var numInputTags = parseInt(document.getElementById('numInputTags').value);
        numInputTags += change;
        document.getElementById('numInputTags').value = numInputTags;
        adjustContainerPadding();
    }

    function createInputTags() {
        var numInputTags = parseInt(document.getElementById('numInputTags').value);
        var form = document.querySelector('form');

        for (var i = 1; i <= numInputTags; i++) {
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'input_' + i;
            input.placeholder = 'Input ' + i;

            input.style.width = '100%';
            input.style.padding = '8px';
            input.style.position = 'relative';
            input.style.top = '-55px';
            input.style.marginBottom = '10px';
            input.style.border = 'groove';
            input.style.borderColor = 'blue';

            form.insertBefore(input, form.lastElementChild);
        }

        adjustContainerPadding();
    }


</script>

</body> <!-- Close the body tag -->
</html>
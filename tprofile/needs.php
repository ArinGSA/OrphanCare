<?php
session_start();

if (!isset($_SESSION['trustid'])) {
    header("Location: login.php");
    exit();
}

$trustid = $_SESSION['trustid'];

$servername = "localhost";
$trustname = "root";
$password = "";
$database = "orphan_care"; 

$connection = mysqli_connect($servername, $trustname, $password, $database);

if (!$connection) {
    die("Connection failed: " . $connection->connect_error);
}
$sql = "SELECT * FROM trustinfo WHERE trustid = $trustid";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $row6 = ['trustname' => $row['trustname']];
    
    $row7 = ['pic' => $row['pic']];
} else {
    $row6 = ['trustname' => ''];
    
    $row7 = ['pic' => ''];
}

$sql2 = "SELECT COUNT(*) AS notiNum FROM accepted WHERE trustid = $trustid";
$result2 = $connection->query($sql2);
$row11 = ($result2) ? $result2->fetch_assoc() : ['notiNum' => 0];

$sql2 = "SELECT COUNT(*) AS rejNum FROM declined WHERE trustid = $trustid";
$result2 = $connection->query($sql2);
$row12 = ($result2) ? $result2->fetch_assoc() : ['rejNum' => 0];

$sql2 = "SELECT AVG(rating1) AS review FROM review WHERE trustid = $trustid";
$result2 = $connection->query($sql2);
$row66 = ($result2) ? $result2->fetch_assoc() : ['review' => 0];
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Trust Profile</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="tp1.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
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
        .container1::-webkit-scrollbar {
    width: 6px; /* Adjust the width as needed */
    right: 11; /* Move the scrollbar to the right edge */
}

        .container1::-webkit-scrollbar-button {
        /* width: 50px; //for horizontal scrollbar */
        height: 48px; //for vertical scrollbar
        }

        .btn {
          /* background-color: #8984e2; */
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

        .container1 form .input-tag-row {
        display: flex;
        justify-content: space-between;
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
<body >

<?php

$numInputTags = 0;

$sqlFetch = "SELECT * FROM trustinfo WHERE trustid= $trustid";
$resultFetch = $connection->query($sqlFetch);

if ($resultFetch->num_rows > 0) {
    $row = $resultFetch->fetch_assoc();
    $existingData = explode(',', $row['need5']);
    $numInputTags = count($existingData);
} else {
    $existingData = array();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteIndex = $_POST['delete'];

    // Delete the specific set of data in the database
    unset($existingData[$deleteIndex - 1]); // Adjust index as it starts from 1
    $updatedneed5 = implode(',', $existingData);
    $sqlUpdate = "UPDATE trustinfo SET need5 = '$updatedneed5' WHERE trustid = $trustid";
    $connection->query($sqlUpdate);

    // Fetch the updated data to display after deletion
    $resultFetch = $connection->query($sqlFetch);
    $row = $resultFetch->fetch_assoc();
    $existingData = explode(',', $row['need5']);
    $numInputTags = count($existingData);
}

// Check if the form has been submitted for new tag addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newTags = [];

    // Process the submitted values for new tags
    for ($i = 1; $i <= $_POST['numInputTags']; $i++) {
        $inputValue = isset($_POST['input_' . $i]) ? $_POST['input_' . $i] : '';

        if (!empty($inputValue)) {
            $newTags[] = $inputValue;
        }
    }

    // Merge existing and new tags
    $allTags = array_merge($existingData, $newTags);

    // Convert array to comma-separated string
    $updatedneed5 = implode(',', $allTags);

    // Update the row with the new need5 values
    $sqlUpdate = "UPDATE trustinfo SET need5 = '$updatedneed5' WHERE trustid = $trustid";
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

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $query = "SELECT trustname, mail, phone, pic, upi, area, ct, acc, for1, members, category, status1, need5 FROM trustinfo WHERE trustid = $trustid";
    $result = mysqli_query($connection, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    
        // Define variables with default values
        $newtrustname = $row['trustname'] ?? '';
        $newMail = $row['mail'] ?? '';
        $newPhone = $row['phone'] ?? '';
        $newCategory = $row['category'] ?? '';
        $newArea = $row['area'] ?? '';
        $newUpi = $row['upi'] ?? '';
        $newAcc = $row['acc'] ?? '';
        $newCt = $row['ct'] ?? '';
        $newMembers = $row['members'] ?? '';
        $newneed5 = $row['need5'] ?? '';
        $newstatus1 = $row['status1'] ?? '';
        $newfor1 = $row['for1'] ?? '';

} else {
    echo "Data not found";
}
}
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
                    <a href="../thome/thome.php" class="btn">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="tpro.php" class="active">
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
    <header>
    <div class="header-content" style="height: 61px;">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>

            <div class="header-menu">

            <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify"><?php echo $row12['reqNum']; ?></span>
            </div>

                <!-- <div class="notify-icon">
                <a href="../tnotification/rev.php">
                <td style="left: 29px;position: relative;"> ⭐ <?php echo intval($row66['review']); ?></td>
            </a>
                </div> -->

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

    <div class="page-header" style="top: -78px;position: relative;padding: 2.3rem 1rem;">
        <h1>Profile</h1>
        <small>Trustee / Profile</small>
    </div>

    <div class="container1" style="padding:32px 2rem;">
        <body>
            <span class="t1" style="top:14px">Needs</span>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="tag-buttons" style="top: 41px;position: relative;">
                    <div style="top: 28px;position: relative;left: -26px;">
                        <label for="numInputTags">No of Needs:</label>
                        <input type="number" name="numInputTags" id="numInputTags" min="1" style="z-index: 11111;left: 92px;height: 30px;border: solid 2px;" required>
                    </div>
                    <div style="left: 82%;top: -26px;position: relative;">
                        <button type="button" class="plus-btn" onclick="changeTags(1)" style="width: 10px;height: 10px;position: relative;">+</button>
                        <button type="button" class="minus-btn" onclick="changeTags(-1)" style="width: 10px;height: 10px;position: relative;bottom: 14px;">-</button>
                    </div>
                    <button type="button" class="create-tags-btn" onclick="createInputTags()" style="left: 35.3%;width: 178px;height: 34px;top: -52px;position: relative;">Create Tags</button>
                </div>

                <div style="top: -13px;position: relative;left: 20px;">
                    <!-- <p>Total No of Needs: <?php echo max(0, $numInputTags - 1); ?></p> -->
                    <div class="columns">

                    <?php
                    // for ($i = 2; $i <= $numInputTags; $i++) {
                    //     $value = isset($existingData[$i - 1]) ? htmlspecialchars($existingData[$i - 1]) : '';
                    //     echo '<div class="column"><input type="text" name="input_' . $i . '" placeholder="Input ' . $i . '" value="' . $value . '" style="border: groove;width: 100%;height: 35px;border-color: black;margin-bottom: 8px;" disabled><br></div>';
                    // }
                    ?>
                </div>
                <button type="submit" name="submit" value="Submit" class="create-tags-btn" style="position: relative;left: 125px;">Send Request</button>
                <!-- <input type="submit" name="submit" value="Submit"> -->


</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<!-- <div style="top: 13px;position: relative;"> -->
<p>Total No of Needs: <?php echo max(0, $numInputTags - 1); ?></p>
                    <!-- </div> -->
<div class="columns">
    <?php foreach ($existingData as $index => $data): ?>
        <div class="column">
            <div class="input-group">
                <input type="text" name="input_<?php echo $index + 1; ?>" placeholder="Input <?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($data); ?>" style="height: 32px;">
                <div class="icon-group" style="top: -54px;left: 146px;position: relative;">
                    <button type="submit" name="delete" value="<?php echo $index + 1; ?>" onclick="return confirm('Are you sure you want to delete this data?')" style="width: 24px;height: 26px;background-color: #c1c1c1;">
                        <i class="fa fa-trash-o" style="font-size:24px"></i>
                    </button>
                </div>
            </div>
        </div>
        
    <?php endforeach; ?>
</div>

</form>
    </div>
                
    </div>

    <div class="container" style="padding: 40px 3rem;top: 332px;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signin-form" enctype="multipart/form-data">

<div class="form first">
    <div class="details personal">
        <span class="title">Care Details</span>

        <div class="fields">
            <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="trustname" style="position: relative; text-align: center;" value="<?php echo $row['trustname']; ?>" placeholder="Enter Your TrustName" required>
                <img class="screenshot" id="preview-pic" style="top: -3%;" src="../tsignup/upload/<?php echo $imageSource = $row['pic'];
 ?>">

                <img class="screenshot" id="preview-pic" style="top: -3%;" src="<?php echo $imageSource; ?>">
                
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
        </div>

        <img
              >
              <div class="profile-img-container" style="padding: 40px 2rem;">

</div>
</form>
    </div> 
</div>

</tbody>
            </table>
        </div>

    </div>

</div>


<script>
    function createInputTags() {
        var numInputTags = parseInt(document.getElementById('numInputTags').value);
        var container = document.querySelector('.columns');

        // Remove existing input elements
        container.innerHTML = '';

        for (var i = 1; i <= numInputTags; i++) {
            var column = document.createElement('div');
            column.className = 'column';

            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'input_' + i;
            input.placeholder = 'Input ' + i;
            input.style.width = '100%';
            input.style.padding = '8px';
            input.style.position = 'relative';
            input.style.marginBottom = '10px';
            input.style.border = 'groove';
            input.style.borderColor = 'blue';
            input.style.left = '-15px';

            // Append the input element to the column
            column.appendChild(input);

            // Append the column to the container
            container.appendChild(column);
        }
    }
</script>


</body>
</html>
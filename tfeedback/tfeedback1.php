<?php
session_start();

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
    <link rel="stylesheet" href="css/demo.css" />
</head>
<body>
  
<div class="f">
    <div class="div">
      <div class="rectangle"></div>	

<header class="ScriptHeader">
    <div class="rt-container">
        <div class="col-rt-12">
            <div class="rt-heading">
                <h1>Review</h1>
                <p>Feed your star rating.</p>
            </div>
        </div>
    </div>
</header>

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
        <label>2. Friendliness and courtesy shown to you while receiving your vehicle</label><br>
        <span class="star-rating">
            <input type="radio" name="rating2" value="1"><i></i>
            <input type="radio" name="rating2" value="2"><i></i>
            <input type="radio" name="rating2" value="3"><i></i>
            <input type="radio" name="rating2" value="4"><i></i>
            <input type="radio" name="rating2" value="5"><i></i>
        </span>
        <div class="clear"></div> 
        <hr class="survey-hr">
        <label>3. Friendliness and courtesy shown to you while delivery of your vehicle</label><br><br/>
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
        <textarea cols="75" name="commentText" ></textarea><br>
        <br>
        <div class="clear"></div> 
        <input style="background:#43a7d5;color:#fff;padding:12px;border:0" type="submit" value="Submit your review">&nbsp;
    </form>
</div>
           
    		</div>
		</div>
    </div>
</section>
     



    <div class="rectangle-2"></div>
  </div>
</div>
</body>
</html>

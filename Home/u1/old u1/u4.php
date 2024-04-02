<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>Trust Info</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="u4.css"/>
<style type="text/css">
    body {
    color: #797979;
    background: #f1f2f7;
    font-family: 'Open Sans', sans-serif;
    padding: 0px !important;
    margin: 0px !important;
    font-size: 19px;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
}


    </style>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">



<?php

    $servername = "localhost";
    $trustname = "root";
    $password = "";
    $dbname = "orphan_care"; // Replace with your actual database name

    // Create a database connection
    $conn = new mysqli($servername, $trustname, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['trustid'])) {
        $trustid = intval($_GET['trustid']);
        $_SESSION['trustid'] = $trustid;
    }

    $query = "SELECT * FROM trustinfo WHERE trustid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $trustid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo'

        
<div class="container bootstrap snippets bootdey">
<div class="row">
<div class="profile-nav col-md-3">
<div class="panel">
<div class="user-heading round">
<a href="#">
<img src="../../trust/tsignup/upload/' . $row['pic'] . '" alt>
</a>
<h1>' . $row['trustname'] . '</h1>
<p>' . $row['mail'] . '</p>
</div>
<ul class="nav nav-pills nav-stacked">
<li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>
<li><a href="donate.php"> <i class="fa fa-inr"></i> Donate </a></li>  

<li><a href="../../form/latest.php?trustid=' . $row['trustid'] . '"> <i class="fa fa-edit"></i> Adopt</a></li>
</ul>
</div>
</div>
<div class="profile-info col-md-9">

<div class="panel">
<div class="bio-graph-heading">
Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ispum. Aliquam ac magna metus.
</div>
<div class="panel-body bio-graph-info">

<div class="row">
<div class="bio-row">
<p><span>Trust Name </span>: ' . $row['trustname'] . '</p>
</div>
<div class="bio-row">
<p><span>Category </span>: ' . $row['category'] . '</p>
</div>
<div class="bio-row">
<p><span>For </span>: ' . $row['for1'] . '</p>
</div>
<div class="bio-row">
<p><span>Members</span>: ' . $row['members'] . '</p>
</div>
<div class="bio-row">
<p><span>Care Takers </span>: ' . $row['ct'] . '</p>
</div>
<div class="bio-row">
<p><span>Email </span>: ' . $row['mail'] . '</p>
</div>
<div class="bio-row">
<p><span>Mobile </span>: ' . $row['phone'] . '</p>
</div>
<div class="bio-row">
<div class="overlap-group-2">
            <div class="text-wrapper-4" id="needs">Needs</div>
            <div class="dropdown-box" id="dropdown-options">
            <div class="needinfo1">
            <div >' . $row['need1'] . '</div>
            <div >' . $row['need2'] . '</div>
            <div >' . $row['need3'] . '</div>
            <div >' . $row['need4'] . '</div>
            </div>
            </div>
            </div>
</div>
</div>
</div>
</div>
<div>
<div class="row">



</div>
</div>
</div>
</div>
</div>';

} else {
    echo 'User not found.';
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->close();
?>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script>
    document.getElementById("needs").addEventListener("click", function (event) {
    event.stopPropagation();
    var dropdown = document.getElementById("dropdown-options");
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
});

document.addEventListener("click", function (event) {
    var dropdown = document.getElementById("dropdown-options");
    if (event.target !== dropdown && event.target !== document.getElementById("needs")) {
        dropdown.style.display = "none";
    }
});

</script>
	
</script>
</body>
</html>
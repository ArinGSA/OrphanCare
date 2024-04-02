<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trust info</title>
    <link rel="stylesheet" href="u1g.css"/>
    <link rel="stylesheet" href="u1s.css"/>
    <style>
        body{
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .welcome {
            position: absolute;
            font-size: 34px;
            font-weight: bold;
        }

        .red {
            left: 768px;
            top: 67px;
            color: red;
        }

        .blue {
            left: 911px;
            top: 67px;
        }

        .green {
            left: 1008px;
            top: 67px;
            color: limegreen;
        }

        .image-slider {
            position: relative;
            max-width: 633px;
            max-height: 291px; /* Reduce the image height */
        }

        .image-slider img {
            position: absolute;
            top: 135px;
            left: 632px;
            width: 633px;
            height: 291px;
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        /* Previous and Next buttons styles */
        .slider-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 24px;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }
        /* Dropdown box styles */
        .dropdown-box {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    width: 430px;
    top: 60px;
    left: 9px;
    height: 190px;
    font-size: 22px;
    z-index: 1;
}

/* Style the dropdown options */
.dropdown-box a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #000;
}

/* Style for the "Needs" link */
#needs {
    cursor: pointer;
    text-decoration: underline;
}

    </style>

    <script>
        
    </script>
</head>
<body>
<div class="container">
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
        echo '
        <div class="search-result">
        <div class="overlap-wrapper">
            <div class="overlap">
                <div class="rectangle"></div>
                <div class="welcome red">Begin</div>
                <div class="welcome blue">the</div>
                <div class="welcome green">CHANGE</div>
                <div class="div"></div>
                <div class="text-wrapper"><p>' . $row['trustname'] . '</p></div>

                <img class="group" src="../../tsignup/upload/' . $row['pic'] . '" alt="Trust Image">

                zz
                <div class="rectangle-2"></div>
                <div class="rectangle-3"></div>
                
                
            
                <a href="../../form/f3.php?trustid=' . $row['trustid'] . '">
                <div class="div-wrapper">
                
                </div>
                </a>
            </div>
            
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
        
            <div class="info1">
            <p class="trust-name-womens">Trust Name&nbsp;&nbsp; - ' . $row['trustname'] . ' </p></p>
            <div class="category-womens">Category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -  ' . $row['category'] . '</p></div>
            <div class="for-womens-oldage">
                For&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - ' . $row['for1'] . '
            </div>
            <div class="phone">
                Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $row['phone'] . '</div>
                </div>
            <div class="info2">
            <div class="care-takers">Care Takers&nbsp;&nbsp;- ' . $row['ct'] . '</div>
            <div class="members">Members&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $row['members'] . '</p></div>
            <div class="mail-womensold-mail">
            Mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $row['mail'] . '</p></div>
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
</div>
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
</body>
</html>
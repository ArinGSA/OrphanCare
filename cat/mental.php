<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

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
    $row6 = ['username' => $row['username']];
    $row10 = ['job' => $row['job']];
    $row7 = ['pic' => $row['pic']];
} else {
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Orphan Care Dashboard</title>
    <link rel="stylesheet" href="../hc.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
        body {
            overflow-x: hidden;
        }

        #noResults {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: red;
        }

        .slider-container {
            position: relative;
            width: 100vw;
            height: 60vh; /* Set a fixed height for the slider container */
            overflow-y: hidden; /* Add a vertical scrollbar when content exceeds the height */
            overflow-x: hidden; /* Hide horizontal scrollbar */
            position: relative;
        }

        .slider-content {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            flex: 0 0 100%;
        }


        /* .slide img {
    width: 91%;
    height: 52%;
    object-fit: cover;
} */
.slide img.slide-image1 {
    width: 100%;
    height: 52%;
    object-fit: cover;
}

.slide img.slide-image2 {
    width: 100%;
    height: 52%;
    object-fit: cover;
}

.slide img.slide-image3 {
    width: 100%;
    height: 52%;
    object-fit: cover;
}

        /* button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            padding: 10px;
            cursor: pointer;
            border: none;
            background: none;
        } */

        #prevBtn {
                position: absolute;
                bottom: 238px;
                font-size: 20px;
                /* padding: 40px; */
                cursor: pointer;
                border: none;
                background: none;
                transform: translateY(-50%);
                /* top: 564px; */
                left: 2%;
                transform: translateX(-50%) translateY(-50%);
                margin-right: 10px;
            }

            #nextBtn {
                position: absolute;
                bottom: 238px;
                font-size: 20px;
                /* padding: 40px; */
                cursor: pointer;
                border: none;
                background: none;
                transform: translateY(-50%);
                /* top: 564px; */
                right: 2%;
                transform: translateX(50%) translateY(-50%);
                z-index: 111111;
                margin-left: 10px;
            }


        .combined-content {
            display: flex;
            flex-direction: column;
            /* top: -21px; */
            /* left: 4%; */
            position: relative;
        }

        .page-content,
        .records.table-responsive {
            margin-top: 20px;
        }


        .btn {
          background-color: #8984e2;
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

        .btn1 {

            background-color: #fff;
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 / 10%);
            /* background: #fff; */
            padding: 0.4rem;
            border-radius: 25px;
            border: outset;
            border-color: #0035ff;
            /* transition: 0.3s; */
            position: relative;
            transition: transform 0.3s ease-in-out; 
        }

            .btn1:hover {
            transform: scale(1.1);
            /* background-color: #74767d; */
            /* color: white; */
        }

        .btn2 {

            background-color: #fff;
            box-shadow: 0px 5px 5px -5px rgb(0 0 0 / 10%);
            background: #fff;
            padding: 0.5rem;
            border-radius: 25px;
            border: outset;
            border-color: #0035ff;
            transition: 0.3s;
            position: relative;
            transition: transform 0.3s ease-in-out; 
        }

            .btn2:hover {
            transform: scale(4);
            background-color: #bdcbff;
            color: red;
        }

        .client-img {
            background-size: cover;
            background-position: center;
            height: 50%;
            width: 50%;
        }

        /* Add this style to remove extra margin/padding from the image container */
        .client-info {
            margin: 0;
            padding: 0;
            object-fit: cover;
        }


        .hidden-header, .hidden-sidebar {
    opacity: 0;
    pointer-events: none; /* To prevent interaction when hidden */
    transition: opacity 0.3s ease; /* You can adjust the duration and timing function as needed */
}

/* Visible state with full opacity */
header, .sidebar {
    opacity: 1;
    pointer-events: auto; /* Enable interaction when visible */
}
    </style>

</head>

<body>


<div class="slider-container">
            <div class="slider-content" id="slider">
            <div class="slide">
    <img class="slide-image1" src="slide/image2.png" alt="Image 1">
</div>
<div class="slide">
    <img class="slide-image2" src="slide/image1.jpeg" alt="Image 2">
</div>
<div class="slide">
    <img class="slide-image3" src="slide/image20.jpg" alt="Image 3">
</div>
                <!-- Add more slides as needed -->
            </div>

            <button id="prevBtn" onclick="prevSlide()">❮</button>
            <button id="nextBtn" onclick="nextSlide()">❯</button>
        </div>
</div>


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
                    <a href="../Home/home.php" class="active">
                        <span class="las la-home"></span>
                        <small>Home</small>
                    </a>
                </li>
                <li>
                    <a href="../Profile/pro.php" class="btn">
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
<header class="header">
        <div class="header-content" style="height: 61px;">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>

            <div class="header-menu">
                <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify"><?php echo $row11['notiNum']; ?></span>
                </div>

                <div class="notify-icon">
                    <span class="las la-bell" style="background-color: red; border-radius: 50%; padding: 2px;"></span>
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

    <?php
    $selectedCategory = 'mental';
    $sql = "SELECT * FROM trustinfo WHERE category = '$selectedCategory'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql2 = "SELECT SUM(amount) AS totalDonate FROM donation WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row2 = ($result2) ? $result2->fetch_assoc() : ['totalDonate' => 0];

        $sql2 = "SELECT COUNT(*) AS trustNum FROM trustinfo";
        $result2 = $conn->query($sql2);
        $row3 = ($result2) ? $result2->fetch_assoc() : ['trustNum' => 0];

        $sql2 = "SELECT COUNT(*) AS donateNum FROM donation WHERE userid = $userid";
        $result2 = $conn->query($sql2);
        $row4 = ($result2) ? $result2->fetch_assoc() : ['donateNum' => 0];

        $sql2 = "SELECT SUM(amount) AS allDonate FROM donation";
        $result2 = $conn->query($sql2);
        $row5 = ($result2) ? $result2->fetch_assoc() : ['allDonate' => 0];

        echo '

        

        <div class="combined-content">
            

            <div class="page-content" style="background-color: white;padding: 1.3rem 0rem;">
                <div class="analytics">
                    <div class="card">
                        <div class="card-head">
                            <h2> ₹ ' . $row2['totalDonate'] . '</h2>
                            <span class="las la-hand-holding-heart"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Donations Done</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>' . $row3['trustNum'] . '</h2>
                            <span class="las la-users"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Trusts</small>
                            <div class="card-indicator">
                                <div class="indicator two" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>₹ ' . $row5['allDonate'] . '</h2>
                            <span> &#8377</span>
                        </div>
                        <div class="card-progress">
                            <small>Donations done in our app</small>
                            <div class="card-indicator">
                                <div class="indicator three" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>' . $row4['donateNum'] . '</h2>
                            <span class="las la-list"></span>
                        </div>
                        <div class="card-progress">
                            <small>Times you Have Donated</small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="records table-responsive" style="overflow-x: hidden;">
                    <div class="record-header">
                        <div class="browse">
                            <input class="record-search" type="text" id="searchInput" oninput="filterTable()" placeholder="Search by trustname">
                            <div id="noResults">No matching results found.</div>
                        </div>
                    </div>

                    <table width="100%" style="font-size:large;" >
                        <thead style="overflow: hidden;">
                            <tr>
                                <th style="font-size:large;">User ID</th>
                                <th style="font-size:large; padding: 1rem 5rem;"> TRUST</th>
                                <th style="font-size:large; padding: 1rem 0rem;"> TrustName</th>
                                <th style="font-size:large;"> MAIL</th>
                                <th style="font-size:large;"> Review</th>
                                <th style="font-size:large;"> DONATIONS</th>
                                <th style="font-size:large;"> NUMBER</th>
                                <th style="font-size:large;"> CATEGORY</th>
                            </tr>
                        </thead>
                        <tbody>';

        while ($row = $result->fetch_assoc()) {
            $trustId = $row['trustid'];

            $sql2 = "SELECT AVG(rating1) AS review FROM review WHERE trustid = $trustId";
            $result2 = $conn->query($sql2);

            if ($result2) {
                $row2 = $result2->fetch_assoc();
                $reviewDisplay = isset($row2['review']) ? ' ' . $row2['review'] : '';
            }

            $sql1 = "SELECT SUM(amount) AS totalAmount FROM donation WHERE trustid = $trustId";
            $result1 = $conn->query($sql1);

            if ($result1) {
                $row1 = $result1->fetch_assoc();
                $totalAmountDisplay = isset($row1['totalAmount']) ? '₹ ' . $row1['totalAmount'] : '';

                echo '
                <tr style="border-bottom: 1px solid #dee2e8;">
                    <td>Tru' . $row['trustid'] . '</td>
                    <td style="width: 22%;">
                        <div class="client">

                        <a href="u1/u5.php?trustid=' . $row['trustid'] . '">
                        <div class="client-img" style="border : none;" >
                        <img src="../trust/tsignup/upload/' . $row['pic'] . '" class="btn1" alt="No Image" style="width: 238px;height: 117px;">
                    </div>
                    
                    </a>
                            <div class="client-info">
                            <td>
                                    <h4>' . $row['trustname'] . '</h4>
                            </td>
                        
                                <td>
                                    <a href="mailto:' . $row['mail'] . '">
                                        <h4><small>' . $row['mail'] . '</small></h4>
                                    </a>
                                </td>
                            </div>
                        </div>
                    </td>
                    <td style="left: 29px;position: relative;" > <a href="../review/review.php?trustid=' . $row['trustid'] . '" style="left: -14px;position: relative;" class="btn2">⭐ ' . (int)$reviewDisplay . ' </td>
                    <td style="left: 29px;position: relative;">' . $totalAmountDisplay . '</td>


                    <td >' . $row['phone'] . '</td>
                    <td style="left: 26px;position: relative;">' . $row['category'] . '</td>
                </tr>';
            }
         }

        echo '
        </div>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
    
    </div>';
    } else {
        echo 'No data found in the table.';
    }
    ?>

<script>
        // Function to filter the table data
        function filterTable() {
            const filterText = document.getElementById('searchInput').value.toLowerCase();
            const tableRows = document.querySelectorAll('.records table tbody tr');

            tableRows.forEach((row) => {
                const cardTitle = row.querySelector('h4').textContent.toLowerCase();

                if (cardTitle.includes(filterText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');

            // Show or hide "No results" message
            if ([...tableRows].every(row => row.style.display === 'none')) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
        </script>

        <script>
        let currentSlide = 0;

        function showSlide() {
            const slider = document.getElementById('slider');
            const slides = document.getElementsByClassName('slide');
            if (currentSlide >= slides.length - 1) {
                currentSlide = 0;
            } else {
                currentSlide++;
            }
            slider.style.transform = `translateX(${-currentSlide * 100}%)`;
        }

        function prevSlide() {
            const slider = document.getElementById('slider');
            if (currentSlide <= 0) {
                currentSlide = slider.children.length - 1;
            } else {
                currentSlide--;
            }
            slider.style.transform = `translateX(${-currentSlide * 100}%)`;
        }

        function nextSlide() {
            showSlide();
        }

        // Auto slide every 3 seconds
        setInterval(showSlide, 300000);
    </script>

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector(".header");
    const sidebar = document.querySelector(".sidebar");
    const scrollThreshold = 300; // Adjust this value based on your preference
    const fadeInDistance = 50; // Adjust this value based on how far you want to scroll before elements start fading in

    // Initial styles
    header.style.opacity = 0;
    sidebar.style.opacity = 0;
    sidebar.style.pointerEvents = "none";

    window.onscroll = function () {
        let currentScrollPos = window.pageYOffset;

        // Toggle the styles based on the scroll position for buttons
        if (currentScrollPos < fadeInDistance) {
            header.style.pointerEvents = "none";
            sidebar.style.pointerEvents = "none";
        } else {
            header.style.pointerEvents = "auto";
            sidebar.style.pointerEvents = "auto";
        }

        // Apply the fading effect only when scrolling down
        if (currentScrollPos > fadeInDistance) {
            let opacity = (currentScrollPos - fadeInDistance) / (scrollThreshold - fadeInDistance);
            opacity = Math.min(1, Math.max(0, opacity));
            header.style.opacity = opacity;
            sidebar.style.opacity = opacity;
        } else {
            // Reset opacity if scrolling up
            header.style.opacity = 0;
            sidebar.style.opacity = 0;
        }
    };

    // Trigger the scroll event once to apply initial styles
    window.dispatchEvent(new Event("scroll"));
});
</script> -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector(".header");
    const sidebar = document.querySelector(".sidebar");
    const combinedContent = document.querySelector(".combined-content");
    const barsIcon = document.querySelector(".las.la-bars");
    const scrollThreshold = 100; // Adjust this value based on your preference
    const fadeInDistance = 50; // Adjust this value based on how far you want to scroll before elements start fading in

    // Initial styles
    header.style.opacity = 0;
    sidebar.style.opacity = 0;
    sidebar.style.pointerEvents = "none";

    window.onscroll = function () {
        let currentScrollPos = window.pageYOffset;

        // Toggle the styles based on the scroll position for buttons
        if (currentScrollPos < fadeInDistance) {
            header.style.pointerEvents = "none";
            sidebar.style.pointerEvents = "none";
        } else {
            header.style.pointerEvents = "auto";
            sidebar.style.pointerEvents = "auto";
        }

        // Apply the fading effect only when scrolling down
        if (currentScrollPos > fadeInDistance) {
            let opacity = (currentScrollPos - fadeInDistance) / (scrollThreshold - fadeInDistance);
            opacity = Math.min(1, Math.max(0, opacity));
            header.style.opacity = opacity;
            sidebar.style.opacity = opacity;
        } else {
            // Reset opacity if scrolling up
            header.style.opacity = 0;
            sidebar.style.opacity = 0;

            // Simulate click on bars-icon when scrolling up
            if (currentScrollPos === 0 && barsIcon) {
                barsIcon.click();
            }
        }

        // Move the combined-content to the right when scrolling up
        if (currentScrollPos < fadeInDistance) {
            combinedContent.style.right = "2.5%";
        } else {
            combinedContent.style.right = "-1%";
        }
    };

    // Trigger the scroll event once to apply initial styles
    window.dispatchEvent(new Event("scroll"));
});
</script>

</body>

</html>

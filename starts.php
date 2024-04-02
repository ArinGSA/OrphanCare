<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Page Image with Buttons</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column; /* Display children in a column */
            height: 100vh;
        }

        body {
            overflow-x: hidden;
        }

        .navbar-nav>li {
            float: left;
            color: black;
        }

        .modal-open-scroll-lock {
            overflow: hidden;
        }

        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .full-page-image {
          height: 100%;
          width: 100%;
          position: fixed;
          bottom: 10%;
          right: 110%;
          object-fit: cover;
          z-index: 111;
        }
        .button-container {
            /* text-align: center; */
            right: 115px;
            top: 601px;
            position: relative;
            z-index: 11111;
        }

        .button-container button {
            margin: 20px;
            padding: 15px 0px;
            font-size: 16px;
            cursor: pointer;
            background-color: transparent;
            border: none;
            border-radius: 5px;
        }

        .btn {
          background-color: #4e5893d1;
          border-radius: 10px;
          color: black;
          padding: 22px 61px;
          text-align: center;
          font-size: 16px;
          margin: 4px 2px;
          transition: 0.3s;
          
        }

        .btn:hover {
        background-color: #a39ff2;
        color: white;
        }


    </style>
</head>
<body>
<!-- <div class="div tp"> -->
<div class="full-page-image">
    <img src="t2.jpg" alt="Full Page Image">
</div>
    
    <div class="button-container">
        <button onclick="handleButtonClick('button1')"><a class="btn" style="padding: 22px 66px;" href="../Login/login.php">Donor</a></button>
    </div>

    <div class="button-container">
        <button onclick="handleButtonClick('button2')"><a class="btn" href="../trust/tlogin/tlogin.php">Trustee</a></btn></button>
    </div>
<!-- </div> -->

    <!-- <script>
        function handleButtonClick(button) {
            alert(button + ' clicked!');
            // Add your button click functionality here
        }
    </script> -->
</body>
</html>

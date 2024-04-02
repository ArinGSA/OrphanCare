<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="startg1.css" />
  <link rel="stylesheet" href="starts1.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    .login-admin {
      width: 100%;
      height: 100vh; /* 100% of the viewport height */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .div {
      text-align: center;
    }

    .rectangle {
      width: 100%;
      height: 50%;
      background-color: #yourColor;
    }

    .rectangle-2 {
      max-width: 100%;
      height: auto;
    }

    .screenshot {
      max-width: 100%;
      height: auto;
    }

    .group {
      margin-top: 10px;
    }

    .overlap-group {
      display: inline-block;
    }

    .text-wrapper, .text-wrapper-2 {
      font-size: 18px;
      text-decoration: none;
      color: black;
    }

    .btn {
          background-color: #ddd;
          border-radius: 10px;
          color: black;
          padding: 22px 61px;
          text-align: center;
          font-size: 16px;
          margin: 4px 2px;
          transition: 0.3s;
          position: relative;
          left: -24px;
        }

.btn:hover {
  background-color: #a39ff2;
  color: white;
}
  </style>
</head>
<body>
  <div class="login-admin">
    <div class="div">
      <div class="rectangle"></div>
      <div class="rectangle-2"></div>
      <img class="rectangle-2" src="startimg.png">
      <img class="screenshot" src="logo1.png">
      <div class="group">
        <!-- <div class="overlap-group"> -->
          <div class="text-wrapper">
            <a class="btn" style="padding: 22px 66px;" href="../Login/login.php">Donor</a>
          <!-- </div> -->
        </div>
      </div>
      <div class="overlap-wrapper">
        <!-- <div class="overlap-group"> -->
          <div class="text-wrapper-2">
            <a class="btn" href="../trust/tlogin/tlogin.php">Trustee</a>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>

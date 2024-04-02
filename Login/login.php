<?php
$startTime = microtime(true); // Record the start time
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orphan_care";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameInput = isset($_POST["username"]) ? $_POST["username"] : "";
    $passwordInput = isset($_POST["password"]) ? $_POST["password"] : "";

    // Admin login check
    if (strtoupper($usernameInput) == "ADMIN" && $passwordInput == "admincare") {
        // Admin login successful
        $_SESSION['userid'] = '1111'; // Set a unique identifier for admin (you can customize this)
        // $_SESSION['username'] = 'admin'; // Set the username for admin
        header("location: ../home/h2.php");
        exit();
    } else {
        // Debugging statement for admin login
        echo "Admin login failed!<br>";
    }

    // User login check
    $stmt = $conn->prepare("SELECT userid, username, password FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $usernameInput);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $db_username, $db_password);
        $stmt->fetch();

        if ($passwordInput == $db_password) {
            // User login successful
            $_SESSION['userid'] = $userid;
            $_SESSION['username'] = $db_username;
            header("location: ../home/home.php");
            exit();
        } else {
            $errorMsg = "Incorrect password. Please try again.";
        }
    } else {
        $errorMsg = "User not found. Please check your username or <a href='sign.php'>create a new account</a>.";
    }

    $stmt->close();
    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

    // Log the response time in error.log
    error_log("Response Time: " . $executionTime . " ms");
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" href="./login.css">

</head>
<body>
<div class="container">
      <div class="forms-container">
        <div class="form-control signup-form">
        <form action="register.php" method="post">
            <h2>Sign Up</h2>
            <input type="text" placeholder="Username" name="username" required />
            <input type="email" placeholder="Email" name="mail" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="phone" placeholder="Phone" name="phone" pattern="[0-9]{10}" title="Please enter a 10-digit number" required />
            <button type="submit">Sign Up</button>
          </form>
          
        </div>
        <div class="form-control signin-form">
          <form method="post">
            <h2>Sign In</h2>
            <input type="text" placeholder="Username" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <button type="submit">Sign In</button>
            <?php echo isset($errorMsg) ? $errorMsg : ''; ?>
          </form>
          
        </div>
      </div>
      <div class="intros-container">
        <div class="intro-control signin-intro">
          <div class="intro-control__inner">
            <h2>Welcome back!</h2>
            <p>
              Welcome back! We are so happy to have you here. It's great to see you again. We hope that your help makes big changes.
            </p>
            <button id="signup-btn">No account yet? Sign Up.</button>
          </div>
        </div>
        <div class="intro-control signup-intro">
          <div class="intro-control__inner">
            <h2>Come join us!</h2>
            <p>
              We are so excited to have you here.If you haven't already, create an account to help the helpless.
            </p>
            <button id="signin-btn">Already have an account? Sign In.</button>
          </div>
        </div>
      </div>
    </div>

  <script>
                const signupBtn = document.getElementById("signup-btn");
                const signinBtn = document.getElementById("signin-btn");
                const mainContainer = document.querySelector(".container");

                signupBtn.addEventListener("click", () => {
                  mainContainer.classList.toggle("change");
                });
                signinBtn.addEventListener("click", () => {
                  mainContainer.classList.toggle("change");
                });
  </script>
</body>
</html>
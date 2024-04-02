<?php
$servername = "localhost";
$trustname = "root";
$password = "";
$dbname = "orphan_care";

$conn = new mysqli("localhost", "root", "", "orphan_care");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $trustname = isset($_POST["trustname"]) ? $_POST["trustname"] : "";
  $password = isset($_POST["password"]) ? $_POST["password"] : "";


    $stmt = $conn->prepare("SELECT trustid, trustname, password FROM trustinfo WHERE trustname = ?");
    $stmt->bind_param("s", $trustname);
    $stmt->execute();
    $stmt->store_result();

    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($trustid, $db_trustname, $db_password);
        $stmt->fetch();

        
        if (password_verify($password, $db_password)) {
            
            $_SESSION['trustid'] = $trustid;
            $_SESSION['trustname'] = $db_trustname;
            
          
                header("location: ../home/home.php");
            
            exit();
        } else {
          $errorMsg = "Incorrect password. Please try again.";
        }
    } else {
      $errorMsg = "User not found. Please check your trustname or <a href='signup.html'>create a new account</a>.";
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signin</title>
  <link rel="stylesheet" href="./login.css">

</head>
<body>
<div class="container">
      <div class="forms-container">
        <div class="form-control signup-form">
        <form method="post">
            <h2>Signin</h2>
            <input type="text" placeholder="trustname or Mail" name="trustname" required />
            <input type="password" placeholder="Password" name="password" required />
            <button type="submit">Signin</button>
            <?php echo isset($errorMsg) ? $errorMsg : ''; ?>
          </form>
          
        </div>
        <div class="form-control signin-form">
        <form action="register.php" method="post">
            <h2>Signup</h2>
            <input type="text" placeholder="trustname" name="trustname" required />
            <input type="email" placeholder="Email" name="mail" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="phone" placeholder="Phone" name="phone" pattern="[0-9]{10}" title="Please enter a 10-digit number" required />
            <button type="submit">Signup</button>
          </form>
          
        </div>
      </div>
      <div class="intros-container">
        <div class="intro-control signin-intro">
          <div class="intro-control__inner">
            <h2>Come join us!</h2>
            <p>
            We are so excited to have you here.If you haven't already, create an account to help the helpless.
            </p>
            <button id="signin-btn">Already have an account? Signin.</button>
          </div>
        </div>
        <div class="intro-control signup-intro">
          <div class="intro-control__inner">
            <h2>Welcome back!</h2>
            <p>
            Welcome back! We are so happy to have you here. It's great to see you again. We hope that your help makes big changes.
            </p>
            <button id="signup-btn">No account yet? Signup.</button>
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
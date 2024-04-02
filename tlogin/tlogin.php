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
    $mail = isset($_POST["mail"]) ? $_POST["mail"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $stmt = $conn->prepare("SELECT trustid, trustname, usertype, mail, password FROM trustinfo WHERE trustname = ? OR mail = ?");
    $stmt->bind_param("ss", $trustname, $trustname);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password === $row['password'] && $row['usertype'] === 'yes') {
          $_SESSION['trustid'] = $row['trustid'];
          $_SESSION['trustname'] = $row['trustname'];
          header("location: ../thome/thome.php");
          exit();
      } else {
          $errorMsg = "Incorrect password or account not activated. Please try again.";
      }
    } else {
        $errorMsg = "User not found. Please check your trustname or <a href='signup.php'>create a new account</a>.";
    }

    $stmt->close();
}

$conn->close();
?>

<!-- The rest of your HTML remains unchanged -->




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
        <form action="register.php" method="post">
            <h3>Trust</h3>
            <input type="text" placeholder="trustname" name="trustname" required />
            <input type="email" placeholder="Email" name="mail" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="phone" placeholder="Phone" name="phone" pattern="[0-9]{10}" title="Please enter a 10-digit number" required />
            <button type="submit">Sign Up</button>
          </form>
          
        </div>
        <div class="form-control signin-form">
          <form method="post">
            <h2>Trust In</h2>
            <input type="text" placeholder="Trustname or Mail" name="trustname" required />
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
              Welcome back! We are so happy to have you here. It's great to see you again. We hope that your trust got the changes.
            </p>
            <button id="signup-btn">No account yet? Sign Up.</button>
          </div>
        </div>
        <div class="intro-control signup-intro">
          <div class="intro-control__inner">
            <h2>Come join us!</h2>
            <p>
              We are so excited to have you here.If you haven't already, create an account for your trust.
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
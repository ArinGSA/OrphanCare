<?php
// Database connection settings
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trustname = $_POST["trustname"];
    $password = $_POST["password"];

    $mail = $_POST["mail"];
    $phone = $_POST["phone"];
    // $phone = $_POST["user_type"];

    // Check if the trustname already exists
    $check_query = "SELECT trustid FROM trustinfo WHERE mail=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $mail);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Mail ID Already Exists want to log in. <a href='../tlogin/tlogin.php'>Go to login</a>";
    } else {
        $insert_query = "INSERT INTO trustinfo (trustname, password, mail, phone, usertype) VALUES (?, ?, ?, ?, 'yes')";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("ssss", $trustname, $password, $mail, $phone);



        if ($insert_stmt->execute()) {
            header("Location: ../tlogin/tlogin.php");
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}

// Close the database connection
$conn->close();
?>

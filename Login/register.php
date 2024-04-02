<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orphan_care"; // Replace with your actual database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $mail = $_POST["mail"];
    $phone = $_POST["phone"];

    // Check if the username already exists
    $check_query = "SELECT userid FROM userinfo WHERE mail=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $mail);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Mail ID Already Exists want to log in. <a href='../Login/login.php'>Go to login</a>";
    } else {
        // Insert user data into the database
        $insert_query = "INSERT INTO userinfo (username, password, mail, phone) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ssss", $username, $password, $mail, $phone);

        if ($insert_stmt->execute()) {
            header("Location: ../Login/login.php");
            exit(); 
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

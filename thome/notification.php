<?php
// Establish a database connection (replace with your own database credentials)
$db_host = 'localhost';
$db_user = 'your_db_user';
$db_pass = 'your_db_password';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start the session
if (!isset($_SESSION['trustid'])) {
    // Handle the case where trustid is not set in the session (e.g., redirect or handle the error)
    echo json_encode(['error' => 'Trust ID not found in session']);
    exit;
}

$trustid = $_SESSION['trustid']; // Get trustid from the session

// Query to get the notification count from your database
$sql = "SELECT COUNT(*) as count FROM request WHERE trustid = $trustid";
$result = $conn->query($sql);

if ($result === false) {
    // Handle database query error
    echo json_encode(['error' => 'Database query error']);
    exit;
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notificationCount = $row['count'];
} else {
    $notificationCount = 0;
}

$conn->close();

// Return the notification count as JSON
echo json_encode(['count' => $notificationCount]);
?>

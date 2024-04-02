<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteInput'])) {
    $trustid = $_SESSION['trustid'];
    $inputName = $_POST['deleteInput'];

    // Validate and sanitize $inputName if necessary

    $servername = "localhost";
    $trustname = "root";
    $password = "";
    $database = "orphan_care"; 

    $connection = mysqli_connect($servername, $trustname, $password, $database);

    if (!$connection) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Delete the corresponding data from the database based on $inputName
    $sqlDelete = "UPDATE trustinfo SET need5 = REPLACE(need5, '$inputName', '') WHERE trustid = $trustid";
    $result = $connection->query($sqlDelete);

    if ($result) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Handle invalid or missing request parameters
    $response = ['success' => false];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

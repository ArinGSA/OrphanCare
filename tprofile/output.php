<?php

session_start();

if (!isset($_SESSION['trustid'])) {
    echo "trust ID not found in session.";
    exit();
}

$db_host = 'localhost';
$db_trust = 'root';
$db_pass = '';
$db_name = 'orphan_care';

$conn = new mysqli($db_host, $db_trust, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$trustid = $_SESSION['trustid']; // Replace with the actual ID
$sqlFetch = "SELECT * FROM trustinfo WHERE trustid= $trustid";
$resultFetch = $conn->query($sqlFetch);

$row = $resultFetch->fetch_assoc();
$existingData = explode(',', $row['need5']);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Updates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
        }

        h2 {
            color: #4caf50;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>View Updates</h2>

<p>Total No of Needs: <?php echo count($existingData); ?></p>

<?php
// Display the retrieved data
foreach ($existingData as $index => $value) {
    $index += 1; // Adjust index to start from 1
    echo '<p>Input ' . $index . ': ' . htmlspecialchars($value) . '</p>';
}
?>

</body>
</html>

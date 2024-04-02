<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orphan_care";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = $_SESSION['userid'];

$data = [
    'userid' => $userid,
    'payment_id' => $_POST['razorpay_payment_id'],
    'amount' => $_POST['totalAmount'],
    'trustid' => $_POST['product_id'],
];

// Define the SQL query to insert data into the donation table
$sql = "INSERT INTO donation (userid, payment_id, amount, trustid) VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters and execute the query
$stmt->bind_param("issi", $data['userid'], $data['payment_id'], $data['amount'], $data['trustid']);

if ($stmt->execute()) {
    // Now, let's retrieve the username associated with the userid
    $username = getUsername($conn, $data['userid']);
    if ($username !== false) {
        // Update the donation table with the retrieved username
        $updateSql = "UPDATE donation SET username = ? WHERE userid = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $username, $data['userid']);
        if ($updateStmt->execute()) {
            $arr = array('msg' => 'Payment successfully credited', 'status' => true, 'username' => $username);
            echo json_encode($arr);
        } else {
            $arr = array('msg' => 'Error: Unable to update username', 'status' => false);
            echo json_encode($arr);
        }
    } else {
        $arr = array('msg' => 'Error: Unable to retrieve username', 'status' => false);
        echo json_encode($arr);
    }
} else {
    $arr = array('msg' => 'Error: Unable to insert data into the database', 'status' => false);
    echo json_encode($arr);
}

// Close the statements and database connection
$stmt->close();
$updateStmt->close();
$conn->close();

// Function to retrieve username based on userid
function getUsername($conn, $userid)
{
    $sql = "SELECT username FROM userinfo WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['username'];
        }
    }

    return false;
}
?>

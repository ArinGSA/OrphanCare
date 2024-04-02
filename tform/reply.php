<?php
if(isset($_POST['accept'])) {
    // Handle the Accept operation
    $id = $_POST['id'];
$trustid = $_POST['trustid'];
    
    // Database connection settings (similar to your previous script)
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
    
    // Fetch the data from the current table
    $query = "SELECT * FROM form WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();


    echo ("<script>alert($id)</script>");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Insert the data into another table (e.g., 'accepted_forms')
        $insertQuery = "INSERT INTO accepted (trustid, userid, full_name, id_type, mail, phone, reason, gender, dob, income, area, occupation, aadhar, relationship)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssssssssssss", $trustid, $row['userid'], $row['full_name'], $row['id_type'], $row['mail'], $row['phone'], $row['reason'], $row['gender'], $row['dob'], $row['income'], $row['area'], $row['occupation'], $row['aadhar'], $row['relationship']);
        
        if ($stmt->execute()) {
            // Data inserted successfully, now delete from the current table
            $deleteQuery = "DELETE FROM form WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo "Data accepted and moved to another table successfully.";
            } else {
                echo "Error deleting data from current table: " . $conn->error;
            }
        } else {
            echo "Error inserting data into another table: " . $conn->error;
        }
    } else {
        echo "Data not found in the current table.";
    }
    
    $conn->close();
} elseif(isset($_POST['decline'])) {
    // Handle the Decline operation
    $id = $_POST['id'];
    $trustid = $_POST['trustid'];
    
    // Database connection settings (similar to your previous script)
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
    
    // Fetch the data from the current table
    $query = "SELECT * FROM form WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Insert the data into another table (e.g., 'accepted_forms')
        $insertQuery = "INSERT INTO declined (trustid, userid, full_name, id_type, mail, phone, reason, gender, dob, income, area, occupation, aadhar, relationship)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssssssssssss", $trustid, $row['userid'], $row['full_name'], $row['id_type'], $row['mail'], $row['phone'], $row['reason'], $row['gender'], $row['dob'], $row['income'], $row['area'], $row['occupation'], $row['aadhar'], $row['relationship']);
        
        if ($stmt->execute()) {
            // Data inserted successfully, now delete from the current table
            $deleteQuery = "DELETE FROM form WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo "Data accepted and moved to another table successfully.";
            } else {
                echo "Error deleting data from current table: " . $conn->error;
            }
        } else {
            echo "Error inserting data into another table: " . $conn->error;
        }
    } else {
        echo "Data not found in the current table.";
    }
    
    $conn->close();
} else {
    echo "Invalid operation.";
}
?>

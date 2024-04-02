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

// Define an array of valid categories
$validCategories = array("child", "old", "women", "private", "handicap", "mental");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trustname = $_POST["trustname"];
    $password = $_POST["password"]; // Store password in plain text

    $mail = $_POST["mail"];
    $phone = $_POST["phone"];
    $category = $_POST["category"];

    // Check if the selected category is valid
    if (in_array($category, $validCategories)) {
        // Check if the email (mail) already exists in the database
        $check_query = "SELECT trustid FROM trustinfo WHERE mail=?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $mail);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Email already exists, display an error message
            echo "Email address already registered. <a href='../tlogin/tlogin.html'>Go to login</a>";
        } else {
            // Email is not registered, proceed with user registration
            // Insert user data into the database
            $insert_query = "INSERT INTO trustinfo (trustname, password, mail, phone, category) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sssss", $trustname, $password, $mail, $phone, $category);

            if ($insert_stmt->execute()) {
                // Registration successful
                echo "Registration successful. <a href='../tlogin/tlogin.html'>Go to login</a>";
                
                // Check if a new profile picture was uploaded
                if ($_FILES['pic']['error'] === UPLOAD_ERR_OK) {
                    $filename = $_FILES['pic']['name'];
                    $temp_name = $_FILES['pic']['tmp_name'];
                    
                    // Define the target directory for the uploaded file
                    $target_dir = "upload/";
                    $target_file = $target_dir . $filename;
                    
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($temp_name, $target_file)) {
                        // Get the user's ID from the inserted row
                        $trustid = $insert_stmt->insert_id;
                        
                        // Update the profile_pic field in the database
                        $updatePicQuery = "UPDATE trustinfo SET pic=? WHERE trustid=?";
                        $updatePicStmt = $conn->prepare($updatePicQuery);
                        $updatePicStmt->bind_param("si", $filename, $trustid);
                        
                        if ($updatePicStmt->execute()) {
                            // Profile picture updated successfully
                        } else {
                            echo 'Error updating profile picture: ' . $updatePicStmt->error;
                        }
                        
                        $updatePicStmt->close();
                    } else {
                        echo 'Error moving uploaded file to destination.';
                    }
                }
                
                // Insert the trustname into the 'form' table
            //     $insertFormQuery = "INSERT INTO form (trustname) VALUES (?)";
            //     $stmtForm = $conn->prepare($insertFormQuery);
            //     $stmtForm->bind_param("s", $trustname);
                
            //     if ($stmtForm->execute()) {
            //         // Trustname inserted into 'form' table successfully
            //     } else {
            //         echo 'Error inserting trustname into form table: ' . $stmtForm->error;
            //     }
                
            //     $stmtForm->close();
            // } else {
            //     echo "Error: " . $insert_stmt->error;
            // }

        //     $insert_stmt->close();
        // }

        $check_stmt->close();
    } else {
        // Invalid category selected
        echo "Invalid category selected. Please choose a valid category.";
    }
}
    }
}

// Close the database connection
$conn->close();
?>

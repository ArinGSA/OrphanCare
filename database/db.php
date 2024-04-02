<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        input[type="text"] {
            width: 100%;
        }

        .update-form {
            margin-top: 20px;
        }

        .save-btn {
            margin-top: 10px;
        }

        .delete-btn {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>Database Viewer</h1>
    </header>

    <div class="container">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Database configuration
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'orphan_care';

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission for updating records
        // Handle form submission for deleting records
// Handle form submission for deleting records
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $inputName => $value) {
        if (strpos($inputName, 'delete_') === 0) {
            $trustid = substr($inputName, strlen('delete_'));

            // Use prepared statements to prevent SQL injection
            $delete_sql = "DELETE FROM trustinfo WHERE trustid = ?";
            $delete_stmt = $conn->prepare($delete_sql);

            // Check if the statement is prepared successfully
            if ($delete_stmt) {
                $delete_stmt->bind_param("i", $trustid);
                $delete_stmt->execute();
                $delete_stmt->close();
            } else {
                echo "Error in preparing the delete statement: " . $conn->error;
            }
        }
    }
}

// Query all data from the 'trustinfo' table
$sql = "SELECT * FROM trustinfo";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        // Output data of each row in an HTML table
        echo "<form method='POST' class='update-form'>";
        echo "<table>";
        echo "<tr>";

        // Output column names as table headers
        $row = $result->fetch_assoc();
        foreach ($row as $columnName => $value) {
            echo "<th>{$columnName}</th>";
        }

        echo "<th>Action</th>"; // Add a column for delete button
        echo "</tr>";

        // Output data of each row
        $result->data_seek(0); // Reset result set pointer to the beginning
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            // Display each column's value and add an input field for editing
            foreach ($row as $columnName => $value) {
                echo "<td><input type='text' name='{$columnName}_{$row['trustid']}' value='{$value}'></td>";
            }

            // Add a delete button for each row
            echo "<td><button type='submit' name='delete_{$row['trustid']}' class='delete-btn'>Delete</button></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<center>";
        echo "<button type='submit' class='save-btn'>Save Changes</button>";
        echo "</center>";
        echo "</form>";
        echo "<hr>"; // Add a horizontal line for better readability
    } else {
        echo "<p>No records found</p>";
    }

    // Free the result set
    $result->free();
} else {
    // Handle the case where the query fails
    echo "Error: " . $conn->error;
}


        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>

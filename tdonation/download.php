<?php
if (isset($_POST['download'])) {
    $userid = $_POST['userid'];
    $donation_id = $_POST['donation_id'];

    // Database connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'orphan_care';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data for the specified donation_id
    $sql = "SELECT * FROM donation WHERE id = $donation_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Start building HTML table with inline styles
        $html_table = "<table style='width: 70%; height: 70%; border-collapse: collapse; margin: 20px auto;' border='1'>";
        
        // Output each column as a row with styles
        foreach ($row as $key => $value) {
            $html_table .= "<tr style='height: 30px;'><td style='padding: 5px; text-align: center; font-size: xx-large; background-color: #f2f2f2;'><strong>$key</strong></td><td style='padding: 5px; font-size: xx-large; text-align: center;'>$value</td></tr>";
        }

        $html_table .= "</table>";

        // Set the content type to force download as HTML file
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="donation_' . $donation_id . '.html"');

        // Output the HTML table content to the browser
        echo $html_table;
        exit();
    } else {
        echo 'No data found for the specified donation ID.';
    }

    $conn->close();
}
?>

<?php
    // Check if trustid is provided in the query parameter
    if (isset($_GET['trustid'])) {
        // Get the user ID from the query parameter
        $trustid = $_GET['trustid'];

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

        // Prepare and execute a SQL query to fetch user information
        $query = "SELECT * FROM form WHERE trustid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $trustid); // Use 'i' for integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user data was found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id']; // Retrieve the 'id' from the fetched data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="latest.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Adoption Request Form</title>
</head>
<body>
    <div class="container">
        <header>Registration</header>

        <form action="reply.php" method="post" onsubmit="return showSubmitAlert();">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="trustid" value="<?php echo $trustid; ?>">

            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" id="dob" name="dob" value="<?php echo $row['dob']; ?>"  required />
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" id="mail" name="mail" value="<?php echo $row['mail']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Occupation</label>
                            <input type="text" id="occupation" name="occupation" value="<?php echo $row['occupation']; ?>" required />
                        </div>

                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>ID Type</label>
                            <input type="text" id="id_type" name="id_type" value="<?php echo $row['id_type']; ?>" required>
                        </div>

                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="text" id="aadhar" name="aadhar" value="<?php echo $row['aadhar']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Reason</label>
                            <input type="text" id="reason" name="reason" value="<?php echo $row['reason']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>states</label>
                            <input type="text" id="states" name="states" value="<?php echo $row['states']; ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" id="area" name="area" value="<?php echo $row['area']; ?>" required />
                        </div>

                        <div class="input-field">
                            <label>Relationship</label>
                            <input type="text" id="relationship" name="relationship" value="<?php echo $row['relationship']; ?>" required />
</select>
                        </div>
                    <!-- </div> -->

                    </div>

                    <button type="submit" class="text-wrapper-25" style="border:none; background-color: #8683c5;" name="accept">Accept</button>

                    
                    <button type="submit" class="text-wrapper-25" style="border:none; background-color: #8683c5; border:none;top: -70px;left: 700px;position: relative;" name="decline">Decline</button>

                </div>
            </div>
        </form>
    </div>
</body>
</html>
<?php
        } else {
            echo '<p>User not found.</p>';
        }

        $conn->close();
    } else {
        echo '<p>User ID not provided in the query parameter.</p>';
    }
?>

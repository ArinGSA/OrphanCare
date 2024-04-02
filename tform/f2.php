<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="f2g.css" />
    <link rel="stylesheet" href="f2s.css" />
  </head>
  <body>

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

    <div class="form">
    <div class="div"></div>
    <div class="rectangle"></div>
    <div class="double-lined-rectangle"> </div>
      <div class="overlap-wrapper">
        <div class="overlap">
         
          <div class="text-wrapper">Adoption Application Form</div>
          <div class="group">
            <div class="group-2">
              <div class="rectangle-2"></div>
              <div class="overlap-group">
                <div class="rectangle-3"></div>
                <div class="rectangle-4"></div>
                <div class="text-wrapper-2">Email</div>
                <span class="text-wrapper-15" style="left: 27px;font-size: 17px;"><?php echo $row['id_type']; ?></span>
                <span class="text-wrapper-4"><?php echo $row['mail']; ?></span>

              </div>
              <div class="overlap-2">
                <div class="rectangle-5"></div>
                <div class="text-wrapper-5">Number</div>
                <span class="text-wrapper-6"><?php echo $row['phone']; ?></span>
              </div>
              <div class="overlap-3">
                <div class="rectangle-6"></div>
                <div class="text-wrapper-5">Reason</div>
                <span class="text-wrapper-6"><?php echo $row['reason']; ?></span>
              </div>
              <div class="overlap-4">
                <div class="ellipse"></div>
                
                <div class="overlap-5">
                  <div class="text-wrapper-7">Gender</div>
                  <span class="text-wrapper-8"><?php echo $row['gender']; ?></span>
                  
                </div>
              </div>
              <div class="overlap-6">
                <div class="rectangle-3"></div>
                <div class="rectangle-3"></div>
                <span class="text-wrapper-10"><?php echo $row['dob']; ?></span>
              </div>
              <div class="overlap-7">
                <div class="rectangle-3"></div>
                <span class="text-wrapper-11"><?php echo $row['income']; ?></span>
              </div>
              <div class="overlap-8">
                <div class="rectangle-3"></div>
                <span class="text-wrapper-11"><?php echo $row['area']; ?></span>
              </div>
              <div class="overlap-9">
                <div class="rectangle-7"></div>
                <div class="text-wrapper-12">Occupation</div>
                <span class="text-wrapper-11" style="top: 30px;"><?php echo $row['occupation']; ?></span>
              </div>
              <div class="overlap-group-2">
                <div class="rectangle-7"></div>
                <div class="text-wrapper-14">Aadhar number</div>
                <span class="text-wrapper-13"><?php echo $row['aadhar']; ?></span>
              </div>
              <div class="ellipse-3"></div>
              
              <span class="text-wrapper-15" style="left: 30px;font-size: 18px;top: 38px;"><?php echo $row['full_name']; ?></span>
              <div class="text-wrapper-5">Name</div>
              <div class="text-wrapper-15">Last name</div>
              <div class="text-wrapper-16">DoB</div>
              <div class="text-wrapper-17">Annual Income</div>
              <div class="text-wrapper-18">Place</div>
              <div class="text-wrapper-19">Occupation</div>
              <span class="text-wrapper-20"><?php echo $row['relationship']; ?></span>
              
            </div>
          </div>
          
                    <div class="overlap-group-wrapper">
                        <div class="div-wrapper">
                            <form action="reply.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="trustid" value="<?php echo $trustid; ?>">
                                <button type="submit" class="text-wrapper-25" style="border:none; background-color: #8683c5;" name="accept">Accept</button>
                            </form>
                        </div>
                    </div>

                    <div class="overlap-group-wrapper2">
                        <div class="div-wrapper12">
                            <form action="reply.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="trustid" value="<?php echo $trustid; ?>">
                                <button type="submit" class="text-wrapper-25" style="border:none; background-color: #8683c5;" name="decline">Decline</button>
                            </form>
          </div>
        </div>
      </div>
    </div>
<?php
    } else {
        echo '<p>User not found.</p>';
    }

    $conn->close();
} else {
    echo '<p>User ID not provided in the query parameter.</p>';
}
?>
</body>
</html>

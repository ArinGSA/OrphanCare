<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "User ID not found in session.";
    exit();
}

$userid = $_SESSION['userid'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "orphan_care";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Error in DB connection: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

if (isset($_GET['trustid'])) {
    $trustid = mysqli_real_escape_string($connection, $_GET['trustid']);
} else {
    echo "Trust ID not found in URL parameter.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userid = mysqli_real_escape_string($connection, $_POST['userid']);
    $trustid = mysqli_real_escape_string($connection, $_POST['trustid']);
    $newMail = mysqli_real_escape_string($connection, $_POST['mail']);
    $newPhone = mysqli_real_escape_string($connection, $_POST['phone']);
    $newArea = mysqli_real_escape_string($connection, $_POST['area']);
    $newfull_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $newid_type = mysqli_real_escape_string($connection, $_POST['id_type']);
    $newRelationship = mysqli_real_escape_string($connection, $_POST['relationship']);
    $newstates = mysqli_real_escape_string($connection, $_POST['states']);
    $newgender = mysqli_real_escape_string($connection, $_POST['gender']);
    $newoccupation = mysqli_real_escape_string($connection, $_POST['occupation']);
    $newdob = mysqli_real_escape_string($connection, $_POST['dob']);
    $newreason = mysqli_real_escape_string($connection, $_POST['reason']);
    $newaadhar = mysqli_real_escape_string($connection, $_POST['aadhar']);

    $insertQuery = "INSERT INTO form (userid, trustid, mail, phone, area, id_type, full_name, relationship, states, gender, occupation, dob, reason, aadhar) 
                   VALUES ('$userid', '$trustid', '$newMail', '$newPhone', '$newArea', '$newid_type', '$newfull_name', '$newRelationship', '$newstates', '$newgender', '$newoccupation', '$newdob', '$newreason', '$newaadhar')";

    $insertResult = mysqli_query($connection, $insertQuery);

    if (!$insertResult) {
        echo "Error inserting data: " . mysqli_error($connection);
        exit();
    }

}

mysqli_close($connection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="latest.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
    

    .modal {
        display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-content {
        padding: 20px;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
    }

    .popup {
        display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .popup-content {
        max-height: 80vh; /* Set a maximum height */
        overflow-y: auto; /* Enable vertical scrolling if content exceeds the height */
        /* Additional styles... */
    }

</style>

   <title>Adoption Request Form </title>
</head>
<body>
    <div class="container">
        <header>Request Form(<span style="color: red;font-size: 15px;">Fill All Data</span>)</header>

        <form action="" method="post" onsubmit="return showSubmitAlert();">
        <input type="hidden" name="trustid" value="<?php echo $trustid; ?>">
        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" id="full_name" name="full_name" placeholder="Enter Name" required />
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" id="dob" name="dob" placeholder="Enter DOB" required />
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" id="mail" name="mail" placeholder="Enter Mail" required />
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter Phone" required />
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select id="Gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="female">Transgender</option>
                        </select>
                        </div>

                        <div class="input-field">
                            <label>Occupation</label>
                            <input type="text" id="occupation" name="occupation" placeholder="Enter Occupation" required />
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>

                    <div class="fields">
                    <div class="input-field">
                            <label>Address</label>
                            <input type="text" id="area" name="area" placeholder="Enter Address" required />
                        </div>

                        <div class="input-field">
                            <label>Reason</label>
                            <input type="text" id="reason" name="reason" placeholder="Enter Reason" required />
                        </div>

                        <div class="input-field">
                            <label>State</label>
                            <select id="states" name="states" required>
                                <option value="andhra_pradesh">Andhra Pradesh</option>
                                <option value="arunachal_pradesh">Arunachal Pradesh</option>
                                <option value="assam">Assam</option>
                                <option value="bihar">Bihar</option>
                                <option value="chhattisgarh">Chhattisgarh</option>
                                <option value="goa">Goa</option>
                                <option value="gujarat">Gujarat</option>
                                <option value="haryana">Haryana</option>
                                <option value="himachal_pradesh">Himachal Pradesh</option>
                                <option value="jammu_kashmir">Jammu and Kashmir</option>
                                <option value="jharkhand">Jharkhand</option>
                                <option value="karnataka">Karnataka</option>
                                <option value="kerala">Kerala</option>
                                <option value="madhya_pradesh">Madhya Pradesh</option>
                                <option value="maharashtra">Maharashtra</option>
                                <option value="manipur">Manipur</option>
                                <option value="meghalaya">Meghalaya</option>
                                <option value="mizoram">Mizoram</option>
                                <option value="nagaland">Nagaland</option>
                                <option value="odisha">Odisha</option>
                                <option value="punjab">Punjab</option>
                                <option value="rajasthan">Rajasthan</option>
                                <option value="sikkim">Sikkim</option>
                                <option value="tamil_nadu">Tamil Nadu</option>
                                <option value="telangana">Telangana</option>
                                <option value="tripura">Tripura</option>
                                <option value="uttar_pradesh">Uttar Pradesh</option>
                                <option value="uttarakhand">Uttarakhand</option>
                                <option value="west_bengal">West Bengal</option>
                            </select>
                        </div>


                        <div class="input-field">
                            <label>ID Type</label>
                            <select id="id_type" name="id_type" required>
                            <option value="aadhar">Aadhar</option>
                            <option value="pan card">PAN card</option>
                            <option value="driving licence">Driving Licence</option>
                            <option value="voterid">VoterID</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="text" id="aadhar" name="aadhar" placeholder="Enter id" required />
                        </div>

                        <div class="input-field">
                            <label>Relationship</label>
                            <select id="relationship" name="relationship" required>
                            <!-- <option value="Single">Single</option> -->
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>

                            Trust ID: <?php echo $trustid; ?>
                            User ID: <?php echo $userid; ?>
</select>
                        </div>
                    </div>

                    <button class="nextBtn">
                        <span class="btnText" type="submit">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form"),
        idTypeSelect = form.querySelector("#id_type");

    function getSelectedIdType() {
        return idTypeSelect.value;
    }

    const nextBtn = form.querySelector(".nextBtn"),
        backBtn = form.querySelector(".backBtn"),
        allInput = form.querySelectorAll(".first input");

    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        const selectedIdType = getSelectedIdType();
        const idNumberInput = document.querySelector("#aadhar");

        const idTypeLengths = {
            "aadhar": 12,
            "pan card": 10,
            "driving licence": 15,
            "voterid": 10
        };

        if (idNumberInput.value.length !== idTypeLengths[selectedIdType]) {
            alert(`ID Number must have exactly ${idTypeLengths[selectedIdType]} characters for ${selectedIdType}.`);
            return;
        }

        alert('Submitted Successfully.');
        window.location.replace('../Home/home.php');
    });

    idTypeSelect.addEventListener("change", function() {
        const selectedIdType = getSelectedIdType();
        const idNumberInput = document.querySelector("#aadhar");

        idNumberInput.removeAttribute("maxlength");

        if (selectedIdType === "aadhar") {
            idNumberInput.setAttribute("maxlength", "12");
        } else if (selectedIdType === "pan card") {
            idNumberInput.setAttribute("maxlength", "10");
        } else if (selectedIdType === "driving licence") {
            idNumberInput.setAttribute("maxlength", "15");
        } else if (selectedIdType === "voterid") {
            idNumberInput.setAttribute("maxlength", "10");
        }
    });
});

    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to show the popup
        function showPopup() {
            const popup = document.getElementById("popup");
            popup.style.display = "block";
        }

        // Function to hide the popup
        function hidePopup() {
            const popup = document.getElementById("popup");
            popup.style.display = "none";
        }

        // Show the popup when the page loads
        showPopup();

        // Close the popup when the user clicks the close button
        document.getElementById("close-popup").addEventListener("click", function() {
            hidePopup();
        });

        // Close the popup when the user clicks anywhere outside it
        window.addEventListener("click", function(event) {
            const popup = document.getElementById("popup");
            if (event.target === popup) {
                hidePopup();
            }
        });

        // Close the popup when the user presses the Escape key
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                hidePopup();
            }
        });
    });
</script>

<!-- Popup HTML -->
<div id="popup" class="popup"  style="display: block;position: relative;left: -507px;">
    <div class="popup-content">

        
        
        <p><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligibility Criteria for Prospective Adoptive Parents</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #b3c8ff;
}

.container1 {
    max-width: 1111px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #333;
}

.criteria-box {
    margin-bottom: 4px;
    padding: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.criteria-box p {
    margin-bottom: 10px;
}

.criteria-box ul {
    padding-left: 20px;
}

.criteria-box li {
    margin-bottom: 5px;
}

.criteria-box table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.criteria-box th, .criteria-box td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.buttons-container {
    margin-top: 20px;
    text-align: center;
}

.accept-button
{
    padding: 10px 20px;
    font-size: 16px;
    margin: 0 10px;
    cursor: pointer;
}

.decline-button {
    padding: 10px 20px;
    font-size: 16px;
    margin: 0 10px;
    cursor: pointer;
}

.accept-button {
    background-color: #4caf50;
    color: #fff;
    border: none;
}

.decline-button {
    background-color: #f44336;
    color: #fff;
    border: none;
}


/* Add more styling as needed */

    </style>
</head>
<body>
<body class="modal-open">
    <div class="overlay"></div>

    <div id="popup" class="modal" style="width: 1146px;top: 319px;">
        <div class="modal-content">

    <div class="container1">
        <center>
        <h1>Eligibility Criteria for Prospective Adoptive Parents</h1>
    </center>

        <div class="criteria-box">
            <h2>1. Physical, Mental, Emotional, and Financial Capability</h2>
            <p>
                The prospective adoptive parents shall be physically, mentally, emotionally, and financially capable.
                They shall not have any life-threatening medical condition and should not have been convicted in a criminal act of any nature or accused in any case of child rights violation.
            </p>
        </div>

        <div class="criteria-box">
            <h2>2. Marital Status and Adoption</h2>
            <p>
                Any prospective adoptive parents, irrespective of their marital status and whether or not they have a biological son or daughter, can adopt a child.
            </p>
            <ul>
                <li>The consent of both spouses for adoption is required in the case of a married couple.</li>
                <li>A single female can adopt a child of any gender.</li>
                <li>A single male shall not be eligible to adopt a girl child.</li>
            </ul>
        </div>

        <div class="criteria-box">
            <h2>3. Stable Marital Relationship</h2>
            <p>
                No child shall be given in adoption to a couple unless they have at least two years of stable marital relationship except in the cases of relative or step-parent adoption.
            </p>
        </div>

        <div class="criteria-box">
            <h2>4. Age Criteria</h2>
            <span id="close-popup" class="accept-button" class="close-popup" style="top: 882px;left: 135px;position: relative;">Accept</span>
            <!-- <span class="close-modal" onclick="hidePopup()">&times;</span>
        <span id="close-popup" class="close-popup">&times;</span>
        <span id="close-popup" class="close-popup">&times;</span> -->
            <p>The age of prospective adoptive parents, as on the date of registration, shall be counted for deciding the eligibility for children of different age groups as follows:</p>
            <table>
                <thead>
                    <tr>
                        <th>Age of the Child</th>
                        <th>Maximum Composite Age of Prospective Adoptive Parents (Couple)</th>
                        <th>Maximum Age of Single Prospective Adoptive Parent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Up to 2 years</td>
                        <td>85 years</td>
                        <td>40 years</td>
                    </tr>
                    <tr>
                        <td>Above 2 and up to 4 years</td>
                        <td>90 years</td>
                        <td>45 years</td>
                    </tr>
                    <tr>
                        <td>Above 4 and up to 8 years</td>
                        <td>100 years</td>
                        <td>50 years</td>
                    </tr>
                    <tr>
                        <td>Above 8 and up to 18 years</td>
                        <td>110 years</td>
                        <td>55 years</td>
                    </tr>
                </tbody>
            </table>
            <p>Minimum age difference between the child and either of the prospective adoptive parents shall not be less than twenty-five years.</p>
        </div>

        <div class="criteria-box">
            <h2>5. Special Consideration for Couples with Two or More Children</h2>
            <p>
                Couples with two or more children shall only be considered for special needs children and hard-to-place children unless they are relatives or step-children.
            </p>
        </div>

        <div class="criteria-box">
            <h2>6. Home Study Report Revalidation</h2>
            <p>The prospective adoptive parents have to revalidate their home study report after a period of three years.</p>
        </div>

        <div class="criteria-box">
            <h2>7. Seniority Criteria</h2>
            <p>
                The seniority of the prospective adoptive parents who have not received a single referral within three years shall be counted from their date of registration except those who have crossed composite years of one hundred ten years.
            </p>
        </div>
        </div>
        </div>
    </div>

        

        <div class="buttons-container" style="top: 1350px;position: fixed;z-index: 10000;">
            <!-- <button class="accept-button" onclick="acceptTerms()" style="right: 383px;position: relative;">Accept</button> -->
            <a href="../Home/home.php" class="decline-button" onclick="declineTerms()" style="left: 317px; position: relative; top: -298px;">Decline</a>

        </div>
    </div>

    <script>

function showPopup() {
        document.body.classList.add('modal-open');
        document.getElementById("popup").style.display = "block";
    }

    function hidePopup() {
        document.body.classList.remove('modal-open');
        document.getElementById("popup").style.display = "none";
    }

    // function acceptTerms() {
    //     alert("You have accepted the terms and conditions.");
    //     // Use inline PHP to pass $row['trustid'] to JavaScript
    //     var trustId = <?php echo json_encode($row['trustid']); ?>;
    //     window.location.href = 'latest.php?trustid=' + trustId;
    // }

    function declineTerms() {
        alert("You have declined the terms and conditions.");
        window.history.back();
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to show the popup
        function showPopup() {
            document.body.classList.add('modal-open');
            const popup = document.getElementById("popup");
            popup.style.display = "block";
        }

        // Function to hide the popup
        function hidePopup() {
            document.body.classList.remove('modal-open');
            const popup = document.getElementById("popup");
            popup.style.display = "none";
        }

        // Show the popup when the page loads
        showPopup();

        // Close the popup when the user clicks the close button
        document.getElementById("close-popup").addEventListener("click", function() {
            hidePopup();
        });

        // Close the popup when the user clicks anywhere outside it
        window.addEventListener("click", function(event) {
            const popup = document.getElementById("popup");
            if (event.target === popup) {
                hidePopup();
            }
        });

        // Close the popup when the user presses the Escape key
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                hidePopup();
            }
        });

        // ... other event listeners ...
    });
</script>



</body>
</html>

    </div>
</div>


</body>
</html>

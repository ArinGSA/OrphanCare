<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Urbanist:wght@100;200;300;400;500;600;700;800;900&display=swap' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src=
 "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js">
    </script>
    <script src=
 "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js">
    </script>
    <style>
        table {
            border-collapse: collapse;
            
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            width: 22%;
        }

        .center {
            margin: 0 auto;
            width: 50%; /* Adjust the width as needed */
        }

        .center1 {
            margin-left: 39%;
            
        }

        h2 {
            margin-left: 40.5%;
            
        }

        .narrow-column {
            width: 10%; /* Adjust the width as needed */
        }
    </style>
</head>
<body>
<div class="center">
<div class="pdf" id="pdf">
        
    <div>
    <img src="logo1.png" alt="" class="center1">
    </div>
    <h2>  Donation Recipt</h2>
        <table style="height: 100px;">
            <tr>
            <th class="narrow-column">No.</th>
                <th>Donor Name</th>
                <th>PaymentID</th>
                <th>Money</th>
                <th>Date</th>
            </tr>
            <?php
            
            $userid = $_POST['userid'];
            $donation_id = $_POST['donation_id'];

            $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = '';
            $db_name = 'orphan_care';

            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM donation WHERE id = $donation_id";
            $result = $conn->query($sql);

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>1</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['payment_id'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }

            $conn->close();
            ?>
        </table>
        </div>
</div>

<div style="margin-bottom:68px"></div>
<div style="display: flex; justify-content: center; align-items: center;">
    <button onclick="generatePDF()" style="background-color: lightgreen; border: none; height: 50px; width: 200px; cursor: pointer; color: black; font-weight: 700;">Generate Recipt</button>
</div>
<div style="margin-bottom:100px"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script type="text/javascript">
    function generatePDF() {
        const { jsPDF } = window.jspdf;

        let doc = new jsPDF('l', 'mm', [1500, 1400]);
        let pdfjs = document.querySelector('#pdf');

        doc.html(pdfjs, {
            callback: function(doc) {
                doc.save("Donation.pdf");
            },
            x: 12,
            y: 12
        });                
    }            
</script>

</body>
</html>

<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freebeez";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to select data from the database
$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #ff4c4c;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #ff4c4c;
        }

        .accepted-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .accepted-button:hover {
            background-color: #45a049;
        }

        .email-form {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        .email-input {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
        }

        .submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .submit-button:hover {
            background-color: #45a049;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #333;
            color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 1000;
        }

        footer {
            background-color: #333;
            color: #f1f1f1;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<h2>Jobs Listing</h2>

<table id="jobsTable">
    <tr>
        <th>ID</th>
        <th>Job Title</th>
        <th>Company Name</th>
        <th>Job Description</th>
        <th>Salary</th>
        <th>Job Type</th>
        <th>LinkedIn</th>
        <th>WhatsApp</th>
        <th>Action</th>
    </tr>
    <?php
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr id='jobRow" . $row["ID"] . "'>";
        echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["job_title"] . "</td>";
        echo "<td>" . $row["company_name"] . "</td>";
        echo "<td>" . $row["job_description"] . "</td>";
        echo "<td>" . $row["salary"] . "</td>";
        echo "<td>" . $row["job_type"] . "</td>";
        echo "<td>" . $row["linkedin"] . "</td>";
        echo "<td>" . $row["whatsapp"] . "</td>";
        echo "<td><button class='accepted-button' onclick='acceptJob(" . $row["ID"] . ")'>Accept Job</button></td>";
        echo "</tr>";
    }
    ?>
</table>

<div class="email-form" id="emailForm">
    <p>Please enter your email to receive the job details:</p>
    <input type="email" class="email-input" id="emailInput" placeholder="Enter your email" required>
    <input type="hidden" id="jobIdInput">
    <button type="submit" class="submit-button" onclick="submitForm()">Submit</button>
</div>

<div class="popup" id="popup">
    <h3>Job Accepted!</h3>
    <p id="popupMessage"></p>
    <p>You will be contacted soon.</p>
</div>

<footer>
    <p>Freebeez Pvt. Ltd. | Contact: freebeez@gmail.com | Karur, Tamil Nadu</p>
</footer>

<script>
    function acceptJob(jobId) {
        var button = document.querySelector("#jobRow" + jobId + " button");
        button.classList.add("accepted-button");
        button.textContent = "Accepted";
        button.disabled = true; // Disable the button after it's been accepted

        // Show email form and set job ID
        showEmailForm(jobId);
    }

    function showEmailForm(jobId) {
        var emailForm = document.getElementById("emailForm");
        var jobIdInput = document.getElementById("jobIdInput");
        jobIdInput.value = jobId;
        emailForm.style.display = "block";
    }

    function submitForm() {
        var jobId = document.getElementById("jobIdInput").value;
        var jobRow = document.getElementById("jobRow" + jobId);

        // Get job details
        var jobTitle = jobRow.querySelector("td:nth-child(2)").textContent;
        var companyName = jobRow.querySelector("td:nth-child(3)").textContent;
        var jobDescription = jobRow.querySelector("td:nth-child(4)").textContent;
        var salary = jobRow.querySelector("td:nth-child(5)").textContent;
        var jobType = jobRow.querySelector("td:nth-child(6)").textContent;

        // Show popup with job details
        var jobDetails = "Job Title: " + jobTitle + "<br>" +
                         "Company Name: " + companyName + "<br>" +
                         "Job Description: " + jobDescription + "<br>" +
                         "Salary: " + salary + "<br>" +
                         "Job Type: " + jobType;
        showPopup(jobDetails);
    }

    function showPopup(jobDetails) {
        var popup = document.getElementById("popup");
        var popupMessage = document.getElementById("popupMessage");
        popupMessage.innerHTML = jobDetails;
        popup.style.display = "block";

        // Hide popup after 10 seconds
        setTimeout(function() {
            popup.style.display = "none";
        }, 10000);
    }
</script>

</body>
</html>

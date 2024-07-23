<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "freebeez";

    // Create connection using PDO
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        // Display error message if connection fails
        die("Connection failed: " . $e->getMessage());
    }

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO lanceregister (firstname, lastname, email, phone, jobtitle, message) VALUES (:firstname, :lastname, :email, :phone, :jobtitle, :message)");
    
    // Bind parameters to the prepared statement
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':jobtitle', $jobtitle);
    $stmt->bindParam(':message', $message);

    // Get form data from POST request
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $jobtitle = $_POST['jobtitle'];
    $message = $_POST['message'];

    // Execute the prepared statement
    try {
        $stmt->execute();
        // Redirect to a success page after successful insertion
        header("Location: freelancers.html");
        exit(); // Terminate script after redirection
    } catch(PDOException $e) {
        // Display error message if insertion fails
        echo '<script>alert("Sorry, there was an error storing your message. Please try again later.");</script>';
    }

    // Close connection
    $conn = null;
}
?>

<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "assn_mgn";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

  
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $sql = "SELECT * FROM admin_details WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        
        $_SESSION['admin_email'] = $email;
        $_SESSION['loggedin'] = true; 
        
        header("Location: Admin-dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }
    $conn->close();
}
?>

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

    // Retrieve input data from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch teacher details
    $sql = "SELECT * FROM student_details WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Teacher login successful
        $_SESSION['student_email'] = $email;
        // Redirect to teacher dashboard or any other page
        header("Location: student-dashboard.php");
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
        echo "<script>window.location.href='index.html';</script>";

    }

    // Close database connection
    $conn->close();
}
?>

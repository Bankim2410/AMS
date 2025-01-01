<?php
// Start or resume the session
session_start();

// Establish a connection to your database
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "assn_mgn"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $enrollment_id = $_POST['enrollment_id'];
    $fullName = $_POST['full_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $mobileNo = $_POST['mobile_no'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $aadharNo = $_POST['aadhar_no'];
    $dateAdmission = $_POST['date_admission'];
    $programme = $_POST['programme'];
    $semester = $_POST['Semester'];
    $s_year = $_POST['s_year'];
    $department = $_POST['department'];

    // Prepare SQL statement to update student information
    $sql = "UPDATE student_details 
        SET full_name='$fullName', 
            date_of_birth='$dateOfBirth', 
            email='$email', 
            mobile_no='$mobileNo', 
            gender='$gender', 
            address='$address', 
            aadhar_no='$aadharNo', 
            date_admission='$dateAdmission', 
            programme='$programme', 
            Semester='$semester',
            s_year='$s_year',
            department='$department'
        WHERE enrollment_id='$enrollment_id'";


    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Set success message
        $_SESSION['message'] = "Successfully updated!";
        // Redirect to view student page after successful update
        header("Location: View-student.php");
        exit();
    } else {
        // Handle error
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['enrollment_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch submitted data
    $enrollment_id = $_SESSION['enrollment_id'];
    $paper_ids = $_POST['paper_ids'];

    // Check if the student has already submitted assignments
    $check_submission_stmt = $conn->prepare("SELECT is_submitted FROM student_submissions WHERE enrollment_id = ? LIMIT 1");
    $check_submission_stmt->bind_param("s", $enrollment_id);
    $check_submission_stmt->execute();
    $check_submission_result = $check_submission_stmt->get_result();

    if ($check_submission_result->num_rows > 0) {
        $row = $check_submission_result->fetch_assoc();
        if ($row['is_submitted'] == 1) {
            // Assignments already submitted
            echo "<script>alert('Assignments have already been submitted.');";
            echo "window.location.href='Paper-submission-status.php';</script>";
            exit();
        }
    }

    // Directory where files will be stored
    $upload_directory = "uploads/";

    // File paths
    $file_paths = array();

    for ($i = 0; $i < count($paper_ids); $i++) {
        // File details
        $file_name = basename($_FILES["papers"]["name"][$i]);
        $file_tmp = $_FILES["papers"]["tmp_name"][$i];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_path = $upload_directory . $enrollment_id . "_paper_" . ($i + 1) . "." . $file_type;

        // Move uploaded file to directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            $file_paths[] = $file_path;
        } else {
            // Error moving file
            echo "Error uploading file " . ($i + 1) . ".";
            exit();
        }
    }

    // Ensure $file_paths array contains exactly 3 elements
    if (count($file_paths) !== count($paper_ids)) {
        echo "Error: Missing paper IDs or file paths.";
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO student_submissions (enrollment_id, paper_id_1, paper_id_2, paper_id_3, file_path_1, file_path_2, file_path_3, is_submitted) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");

    // Check for preparation errors
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("siiisss", $enrollment_id, $paper_ids[0], $paper_ids[1], $paper_ids[2], $file_paths[0], $file_paths[1], $file_paths[2]);

    // Execute the statement
    if ($stmt->execute()) {
        // Submission successful
        echo "<script>alert('Assignments submitted successfully.');</script>";
        echo "<script>setTimeout(function(){ window.location.href='Paper-submission-status.php'; }, 1000);</script>";
    } else {
        // Error executing statement
        echo "Error submitting assignments: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Form not submitted
    echo "Form not submitted.";
}

// Close the connection
$conn->close();
?>

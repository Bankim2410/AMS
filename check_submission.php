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

// Fetch student's enrollment ID, name, semester, and department from the database
$enrollment_id = $_SESSION['enrollment_id'];

// Fetch student details
$sql_student = "SELECT full_name, semester, department FROM student_details WHERE enrollment_id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("s", $enrollment_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();

if ($result_student->num_rows > 0) {
    $row_student = $result_student->fetch_assoc();
    $name = $row_student['full_name'];
    $semester = $row_student['semester'];
    $department = $row_student['department'];
} else {
    // Handle if student details not found
    echo "Student details not found.";
    exit();
}

// Fetch paper details for the student's department and semester
// Fetch paper details for the student's department and semester
// Fetch paper details for the student's department and semester
$sql_paper = "SELECT p.paper_id, p.paper_code, p.paper_name, IFNULL(s.is_submitted, 0) AS is_submitted
              FROM papers_of_departments p
              LEFT JOIN (SELECT * FROM student_submissions WHERE enrollment_id = ?) s
              ON p.paper_id = s.paper_id_1 OR p.paper_id = s.paper_id_2 OR p.paper_id = s.paper_id_3
              WHERE p.semester = ? AND p.dept_id = (SELECT dept_id FROM departments WHERE dept_name = ?)";
$stmt_paper = $conn->prepare($sql_paper);
$stmt_paper->bind_param("sis", $enrollment_id, $semester, $department);
$stmt_paper->execute();
$result_paper = $stmt_paper->get_result();


// Close the statement
$stmt_student->close();
$stmt_paper->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Submission Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .paper-list {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .paper-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .paper-item span {
            display: block;
            margin-bottom: 5px;
        }

        .paper-item .paper-code {
            font-weight: bold;
            font-size: 18px;
        }

        .paper-item .paper-name {
            font-style: italic;
        }

        .status-submitted {
            color: green;
        }

        .status-not-submitted {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Paper Submission Status</h1>
    <div class="paper-list">
        <h2>Hey, <?php echo $name; ?></h2>
        <h3>Semester: <?php echo $semester; ?></h3>
        <h3>Department: <?php echo $department; ?></h3>
        <?php if ($result_paper->num_rows > 0) : ?>
            <?php while ($row_paper = $result_paper->fetch_assoc()) : ?>
                <div class="paper-item">
                    <span class="paper-code"><?php echo $row_paper['paper_code']; ?></span>
                    <span class="paper-name"><?php echo $row_paper['paper_name']; ?></span>
                    <?php if ($row_paper['is_submitted'] == 1) : ?>
                        <span class="status-submitted">Submitted</span>
                    <?php else : ?>
                        <span class="status-not-submitted">Not Submitted</span>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No papers found for the semester.</p>
        <?php endif; ?>
    </div>
</body>

</html>
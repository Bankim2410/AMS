<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['enrollment_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch student's enrollment ID, name, semester, and department from the database
$enrollment_id = $_SESSION['enrollment_id'];

// Database connection parameters
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "assn_mgn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student details
$sql = "SELECT full_name, enrollment_id, semester, department FROM student_details WHERE enrollment_id = '$enrollment_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['full_name'];
    $enrollment_id = $row['enrollment_id'];
    $semester = $row['semester'];
    $department = $row['department'];
} else {
    // Handle if student details not found
    echo "Student details not found.";
    exit();
}

// Fetch paper details for the student's department and semester
$sql = "SELECT p.* FROM papers_of_departments p 
        JOIN departments d ON p.dept_id = d.dept_id 
        WHERE d.dept_name = '$department' AND p.semester = '$semester'";

$result = $conn->query($sql);

$papers = array(); // Initialize an array to store paper details

if ($result->num_rows > 0) {
    // Fetch and store paper details in the array
    while ($row = $result->fetch_assoc()) {
        $papers[] = $row;
    }
} else {
    // Handle if no papers found for the semester
    echo "No papers found for the semester.";
    exit();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
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

        .submission-form {
            background-color: #fff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .submission-form table {
            width: 100%;
            border-collapse: collapse;
        }

        .submission-form table,
        th,
        td {
            border: 1px solid #ddd;
        }

        .submission-form th,
        .submission-form td {
            padding: 10px;
            text-align: left;
        }

        .submission-form th {
            background-color: #f2f2f2;
        }

        .submission-form input[type="file"] {
            display: block;
            margin-top: 5px;
        }

        .submission-form input[type="submit"] {
            background-color: #b653ef;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .submission-form input[type="submit"]:hover {
            background-color: #DE44E8;
        }
        
    </style>
</head>

<body>
    <h1><u>Submit Your Assignments</u></h1>
    <div class="submission-form">
        <h2>Name: <?php echo $name; ?></h2>
        <h3>Enrollment ID: <?php echo $enrollment_id; ?></h3>
        <form action="submit_handler.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Paper Code</th>
                    <th>Upload Assignment</th>
                </tr>
                <?php foreach ($papers as $paper) : ?>
                    <tr>
                        <td><?php echo $paper['paper_code']; ?></td>
                        <td>
                            <!-- Apply inline styles to the file input button -->
                            <input type="file" name="papers[]" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; color: #b653ef;">
                            <input type="hidden" name="paper_ids[]" value="<?php echo $paper['paper_id']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
            <input type="submit" value="Submit Papers">
        </form>
    </div>
</body>

</html>
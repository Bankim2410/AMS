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

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Your PHP code to determine the current mode
$currentMode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled' ? 'dark' : 'light';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Submission Status</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Paper-submission-status.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="favicon.ico">
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="Photo">
                </span>
                <div class="text header-text">
                    <span class="name">Assignment Management System</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search-alt-2 icon'></i>
                    <input type="search" placeholder="Search...">
                </li>
                <ul class="menu-links">
                    <li class="nav-link <?php echo $current_page == 'Student-dashboard.php' ? 'active-link' : ''; ?>">
                        <a href="Student-dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'Student-profile.php' ? 'active-link' : ''; ?>">
                        <a href="Student-profile.php">
                            <i class='bx bxs-user-account icon'></i>
                            <span class="text nav-text">View Profile</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'Paper-submission-status.php' ? 'active-link' : ''; ?>">
                        <a href="Paper-submission-status.php">
                            <i class='bx bxs-shield icon'></i>
                            <span class="text nav-text">Paper Submission Status</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'Submit-assignment.php' ? 'active-link' : ''; ?>">
                        <a href="Submit-assignment.php">
                            <i class='bx bxs-send icon'></i>
                            <span class="text nav-text">Submit Assignment</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'Change-password.php' ? 'active-link' : ''; ?>">
                        <a href="Change-password.php">
                            <i class='bx bxs-pencil icon'></i>
                            <span class="text nav-text">Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li>
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <header>
        <div class="main-header sizeAdjust">
            <span class="text">Paper Submission Status</span>
        </div>
    </header>

    <div class="maintainWidth">

        <div class="paper-list">
            <h2>Hey, <?php echo $name; ?></h2>
            <h3>Semester: <?php echo $semester; ?></h3>
            <h3>Department: <?php echo $department; ?></h3>
            <?php if ($result_paper->num_rows > 0) : ?>
                <?php while ($row_paper = $result_paper->fetch_assoc()) : ?>
                    <div class="paper-item">
                        <span class="paper-code make-white"><?php echo $row_paper['paper_code']; ?></span>
                        <span class="paper-name make-white"><?php echo $row_paper['paper_name']; ?></span>
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

    </div>

    <footer>
        <div class="main-footer sizeAdjust">
            <span class="text footer-disclaimer" style="color: white;">
                <p>&copy;Disclaimer:</p>
                <p>This website, developed by Bankim Chandra Das, Arijit Das, Nayanadhir Nandi, and Jagatbandhu Tudu,
                    serves as an assignment management system for educational purposes only. While every effort has been
                    made to ensure its functionality and reliability, users are advised to verify critical information
                    independently. We do not take responsibility for any inaccuracies or disruptions in service. Use at
                    your own discretion.
                </p>
            </span>
            <span class="img"> <img src="FooterLogo.png" alt="image" class="footerlogo">
                <img src="FooterLogo2.png" alt="image" class="footerlogo">
                <img src="FooterLogo3.png" alt="image" class="footerlogoEnd">
            </span>
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>
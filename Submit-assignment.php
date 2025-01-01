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
    <title>Submit Assignment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Submit-assignment.css">
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
            <span class="text">Submit Assignment</span>
        </div>
    </header>

    <div class="maintainWidth">
            <div class="submission-form">
                <h2>Name: <?php echo $name; ?></h2>
                <h3>Enrolment ID: <?php echo $enrollment_id; ?></h3>
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
                                    
                                    <input type="file" name="papers[]" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; color: var(--sub-write-color);">
                                    <input type="hidden" name="paper_ids[]" value="<?php echo $paper['paper_id']; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                    <input type="submit" value="Submit Papers">
                </form>
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
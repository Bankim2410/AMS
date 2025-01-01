<?php
// Start session
session_start();

// Check if the session is set
if (!isset($_SESSION['student_email'])) {
    // Redirect to login page if session is not set
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

// Retrieve student details from the database
$email = $_SESSION['student_email'];
$sql = "SELECT * FROM student_details WHERE email = '$email'";
$result = $conn->query($sql);

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Fetch student details
    $row = $result->fetch_assoc();
    $enrlid = $row['enrollment_id'];
    $fullName = $row['full_name'];
    $dateOfBirth = $row['date_of_birth'];
    $mobileNo = $row['mobile_no'];
    $gender = $row['gender'];
    $address = $row['address'];
    $aadharNo = $row['aadhar_no'];
    $year = $row['s_year'];
    $semester = $row['Semester'];
    $dateAdmission = $row['date_admission'];
    $programme = $row['programme'];
    $sSubject = $row['department'];
} else {
    // Redirect or show error message if student details are not found
    echo "Student details not found.";
}

// Close database connection
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
    <title>Student Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Student-profile.css">
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
                        <a href="">
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
            <span class="text">Your profile</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="content">
                <table class="center-table">
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Enrolment ID:</td>
                        <td><?php echo $enrlid; ?></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><?php echo $fullName; ?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td><?php echo $dateOfBirth; ?></td>
                    </tr>
                    <tr>
                        <td>Mobile No:</td>
                        <td><?php echo $mobileNo; ?></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><?php echo $gender; ?></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td>Aadhar No:</td>
                        <td><?php echo $aadharNo; ?></td>
                    </tr>
                    <tr>
                        <td>Year:</td>
                        <td><?php echo $year; ?></td>
                    </tr>
                    <tr>
                        <td>Semester:</td>
                        <td><?php echo $semester; ?></td>
                    </tr>
                    <tr>
                        <td>Date of Admission:</td>
                        <td><?php echo $dateAdmission; ?></td>
                    </tr>
                    <tr>
                        <td>Programme:</td>
                        <td><?php echo $programme; ?></td>
                    </tr>
                    <tr>
                        <td>Subject:</td>
                        <td><?php echo $sSubject; ?></td>
                    </tr>
                </table>

            </div>
        </section>
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
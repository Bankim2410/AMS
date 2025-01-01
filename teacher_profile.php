<?php
// Start session
session_start();

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
    <title>Teacher Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="teacher_profile.css">
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
                    <li class="nav-link <?php echo $current_page == 'teacher_dashboard.php' ? 'active-link' : ''; ?>">
                        <a href="teacher_dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'teacher_profile.php' ? 'active-link' : ''; ?>">
                        <a href="teacher_profile.php">
                            <i class='bx bxs-user-account icon'></i>
                            <span class="text nav-text">View Profile</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'teacher_assn_download.php' ? 'active-link' : ''; ?>">
                        <a href="teacher_assn_download.php">
                            <i class='bx bxs-download icon'></i>
                            <span class="text nav-text">Download Assignment</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'teacher_marks_upload.php' ? 'active-link' : ''; ?>">
                        <a href="teacher_marks_upload.php">
                            <i class='bx bx-upload icon'></i>
                            <span class="text nav-text">Upload Marks</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'teacher_contact_student.php' ? 'active-link' : ''; ?>">
                        <a href="teacher_contact_student.php">
                            <i class='bx bxs-contact icon'></i>
                            <span class="text nav-text">Contact Student</span>
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
            <span class="text">Teacher Profile</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="container1">
                <h1>Teacher Profile</h1>
                <?php
                // Check if the session is set
                if (!isset($_SESSION['teacher_email'])) {
                    // Redirect to login page if session is not set
                    header("Location: teacher_login.php");
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

                $email = $_SESSION['teacher_email'];

                // Query to fetch personal details including department name
                $sql_personal = "SELECT td.*, d.dept_name 
                         FROM teachers_details td 
                         JOIN departments d ON td.dept_id = d.dept_id 
                         WHERE email = '$email'";
                $result_personal = $conn->query($sql_personal);

                // Query to fetch contact details
                $sql_contact = "SELECT phone_no, email, joining_date FROM teachers_details WHERE email = '$email'";
                $result_contact = $conn->query($sql_contact);

                // Query to fetch paper details
                $sql_paper = "SELECT paper1_code, paper2_code, paper3_code FROM teachers_details WHERE email = '$email'";
                $result_paper = $conn->query($sql_paper);

                if ($result_personal->num_rows > 0 && $result_contact->num_rows > 0 && $result_paper->num_rows > 0) {
                    // Fetch personal details
                    $row_personal = $result_personal->fetch_assoc();
                    $teacher_id = $row_personal['teacher_id'];
                    $full_name = $row_personal['full_name'];
                    $dept_name = $row_personal['dept_name'];

                    // Fetch contact details
                    $row_contact = $result_contact->fetch_assoc();
                    $phone_no = $row_contact['phone_no'];
                    $email = $row_contact['email'];
                    $joining_date = $row_contact['joining_date'];

                    // Fetch paper details
                    $row_paper = $result_paper->fetch_assoc();
                    $paper1_code = $row_paper['paper1_code'];
                    $paper2_code = $row_paper['paper2_code'];
                    $paper3_code = $row_paper['paper3_code'];

                    // Display teacher's profile information
                    echo "<table>";
                    echo "<tr><th colspan='2'>Personal Information</th></tr>";
                    echo "<tr><td>Teacher ID:</td><td>$teacher_id</td></tr>";
                    echo "<tr><td>Full Name:</td><td>$full_name</td></tr>";
                    echo "<tr><td>Department Name:</td><td>$dept_name</td></tr>";
                    echo "</table>";

                    echo "<table>";
                    echo "<tr><th colspan='2'>Contact Information</th></tr>";
                    echo "<tr><td>Email:</td><td>$email</td></tr>";
                    echo "<tr><td>Phone Number:</td><td>$phone_no</td></tr>";
                    echo "<tr><td>Joining Date:</td><td>$joining_date</td></tr>";
                    echo "</table>";

                    echo "<table>";
                    echo "<tr><th colspan='4'>Paper Details</th></tr>";
                    echo "<tr><th>Paper ID</th><th>Paper Name</th><th>Paper Code</th><th>Semester</th></tr>";

                    // Fetch paper details including paper ID, paper name, and semester
                    $sql_paper_details = "SELECT paper_id, paper_name, paper_code, semester 
                                  FROM papers_of_departments 
                                  WHERE paper_code IN ('$paper1_code', '$paper2_code', '$paper3_code')";
                    $result_paper_details = $conn->query($sql_paper_details);

                    if ($result_paper_details->num_rows > 0) {
                        while ($row = $result_paper_details->fetch_assoc()) {
                            $paper_id = $row['paper_id'];
                            $paper_name = $row['paper_name'];
                            $paper_code = $row['paper_code'];
                            $semester = $row['semester'];
                            echo "<tr><td>$paper_id</td><td>$paper_name</td><td>$paper_code</td><td>$semester</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No paper details found.</td></tr>";
                    }
                    echo "</table>";
                } else {
                    // Show error message if teacher details are not found
                    echo "<p>Teacher details not found.</p>";
                }
                // Close database connection
                $conn->close();
                ?>
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
    <script src="Student-dashboard.js"></script>
</body>

</html>
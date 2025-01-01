<?php
// Start session
session_start();

// Database connection settings
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enrollment_id = $_POST['enrollment_id'];
    $paper_code = $_POST['paper_code'];
    $paper = $_POST['paper'];
    $marks = $_POST['marks'];

    // Determine the correct column based on the selected paper
    $paper_column = "";
    $paper_id_column = "";

    if ($paper == "1") {
        $paper_column = "paper1_marks";
        $paper_id_column = "paper_id_1";
    } elseif ($paper == "2") {
        $paper_column = "paper2_marks";
        $paper_id_column = "paper_id_2";
    } elseif ($paper == "3") {
        $paper_column = "paper3_marks";
        $paper_id_column = "paper_id_3";
    } else {
        die("Invalid paper selection.");
    }

    // Construct and execute the SQL query
    $sql = "UPDATE student_marks_details SET $paper_column = $marks WHERE enrollment_id = $enrollment_id AND $paper_id_column = $paper_code";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "<script>alert('Marks Updated Successfully.')</script>";
        } else {
            echo "<script>alert('No records updated. Please check enrollment ID and paper code.')</script>";
        }
    } else {
        echo "Error updating marks: " . $conn->error;
    }
}
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
    <title>Upload Marks</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="teacher_marks_upload.css">
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
            <span class="text">Upload Marks</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="container">
                <h2>Upload Marks</h2>
                <form onsubmit="return validateForm()" method="POST">
                    <div class="form-group">
                        <label for="enrollment_id">Enrolment ID:</label>
                        <input type="text" id="enrollment_id" name="enrollment_id" required>
                    </div>
                    <div class="form-group">
                        <label for="paper_code">Paper Code:</label>
                        <input type="text" id="paper_code" name="paper_code" required>
                    </div>
                    <div class="form-group">
                        <label for="paper">Paper:</label>
                        <select id="paper" name="paper" required>
                            <option value="1">Paper 1</option>
                            <option value="2">Paper 2</option>
                            <option value="3">Paper 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marks">Marks Obtained:</label>
                        <input type="text" id="marks" name="marks" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="button">Submit</button>
                    </div>
                </form>
                <div class="exit-button">
                    <a href="teacher_dashboard.php">Exit</a>
                </div>
            </div>

            <script>
                function validateForm() {
                    let enrollmentId = document.getElementById("enrollment_id").value;
                    let paperCode = document.getElementById("paper_code").value;
                    let paper = document.getElementById("paper").value;
                    let marks = document.getElementById("marks").value;
                    let errorMsg = "";

                    if (isNaN(enrollmentId) || enrollmentId === "") {
                        errorMsg += "Enrollment ID must be a number.\n";
                    }

                    if (isNaN(paperCode) || paperCode === "") {
                        errorMsg += "Paper code must be a number.\n";
                    }

                    if (isNaN(marks) || marks < 0 || marks > 100) {
                        errorMsg += "Marks must be a number between 0 and 100.\n";
                    }

                    if (errorMsg !== "") {
                        alert(errorMsg);
                        return false;
                    }

                    return true;
                }
            </script>
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
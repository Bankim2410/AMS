<?php
// Start session
session_start();

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Your PHP code to determine the current mode
$currentMode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled' ? 'dark' : 'light';

// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Assignment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="teacher_assn_download.css">
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
            <span class="text">Download Assignment</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <h1>Download Assignment</h1>
            <form method="post">
                <label for="enrollment_id">Enrolment ID:</label>
                <input type="text" id="enrollment_id" name="enrollment_id" placeholder="Enter Enrolment Id" required>

                <label for="paper_id">Paper ID:</label>
                <input type="text" id="paper_id" name="paper_id" placeholder="Enter Paper Code" required>

                <input type="submit" value="Fetch">
                <br><br>
                <input type="button" id="exit" value="Exit" onclick="window.location.href='teacher_dashboard.php';">
            </form>

            <?php
            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get form data
                $enrollment_id = $_POST['enrollment_id'];
                $paper_id = $_POST['paper_id'];

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

                // Query to get the file paths based on enrollment ID and paper ID
                $sql_file_path = "SELECT file_path_1, file_path_2, file_path_3, paper_id_1, paper_id_2, paper_id_3
                                  FROM student_submissions 
                                  WHERE enrollment_id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($sql_file_path);
                $stmt->bind_param("i", $enrollment_id);

                // Execute the statement
                if ($stmt->execute()) {
                    // Bind the result variables
                    $stmt->bind_result($file_path_1, $file_path_2, $file_path_3, $paper_id_1, $paper_id_2, $paper_id_3);

                    // Fetch the result
                    if ($stmt->fetch()) {
                        // Initialize file path
                        $file_path = null;

                        // Determine the correct file path based on the paper ID
                        if ($paper_id == $paper_id_1) {
                            $file_path = $file_path_1;
                        } elseif ($paper_id == $paper_id_2) {
                            $file_path = $file_path_2;
                        } elseif ($paper_id == $paper_id_3) {
                            $file_path = $file_path_3;
                        }

                        // Check if file path is found and exists
                        if ($file_path && file_exists($file_path)) {
                            // Close statement
                            $stmt->close();

                            // Close connection
                            $conn->close();

                            // Clean output buffer
                            ob_end_clean();

                            // Set headers to download the file
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                            readfile($file_path);
                            exit;
                        } else {
                            echo "File not found or path is invalid.";
                        }
                    } else {
                        echo "<script>alert('Invalid Enrollment Number or Paper Code or Not Submitted Yet');</script>";
                        echo "<script>window.location.href='teacher_assn_download.php';</script>";
                    }
                } else {
                    echo "Error executing query: " . $stmt->error;
                }

                // Close statement and connection if not already closed
                if ($stmt) $stmt->close();
                if ($conn) $conn->close();
            }
            ?>

            <div class="caution-message">
                <br><br>
                Caution: If you don't know your assigned paper codes, please go to <br> 'Your Profile' section or <a href="teacher_profile.php">Click Here</a>.
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
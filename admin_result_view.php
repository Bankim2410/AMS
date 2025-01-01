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
    <title>Result View</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_result_view.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="favicon.ico">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableArea,
            #printableArea * {
                visibility: visible;
            }

            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 80%;
                height: 100%;
                overflow: visible;
            }
        }
    </style>
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
                    <li class="nav-link <?php echo $current_page == 'Admin-dashboard.php' ? 'active-link' : ''; ?>">
                        <a href="Admin-dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'View-student.php' ? 'active-link' : ''; ?>">
                        <a href="View-student.php">
                            <i class='bx bx-table icon'></i>
                            <span class="text nav-text">View Student</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'Student_DataEntry.php' ? 'active-link' : ''; ?>">
                        <a href="Student_DataEntry.php">
                            <i class='bx bxs-add-to-queue icon'></i>
                            <span class="text nav-text">Add Student</span>
                        </a>
                    </li>
                    <li class="nav-link <?php echo $current_page == 'admin_result_view.php' ? 'active-link' : ''; ?>">
                        <a href="admin_result_view.php">
                            <i class='bx bxs-notepad icon'></i>
                            <span class="text nav-text">Result View</span>
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
            <span class="text">Check Result</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="container">
                <h1>Student Result</h1>
                <form method="GET" action="">
                    <label for="enrollment_id">Enter Enrolment ID:</label>
                    <input type="text" name="enrollment_id" id="enrollment_id" required>
                    <button type="submit">Submit</button>
                </form>

                <div id="printableArea">
                    <?php
                    if (isset($_GET['enrollment_id'])) {
                        $host = "localhost";
                        $user = "root";
                        $password = "";
                        $database = "assn_mgn";

                        // Establish connection to database
                        $conn = new mysqli($host, $user, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $enrollment_id = intval($_GET['enrollment_id']);

                        // Prepare SQL query with joins
                        $sql = "SELECT sd.*, smd.*,
                           pod1.paper_name AS paper_name_1, pod1.paper_code AS paper_code_1, pod1.paper_id AS paper_id_1,
                           pod2.paper_name AS paper_name_2, pod2.paper_code AS paper_code_2, pod2.paper_id AS paper_id_2,
                           pod3.paper_name AS paper_name_3, pod3.paper_code AS paper_code_3, pod3.paper_id AS paper_id_3
                    FROM student_details sd
                    INNER JOIN student_marks_details smd ON sd.enrollment_id = smd.enrollment_id
                    LEFT JOIN papers_of_departments pod1 ON pod1.paper_id = smd.paper_id_1
                    LEFT JOIN papers_of_departments pod2 ON pod2.paper_id = smd.paper_id_2
                    LEFT JOIN papers_of_departments pod3 ON pod3.paper_id = smd.paper_id_3
                    WHERE sd.enrollment_id = ?";

                        // Prepare and bind parameter to avoid SQL injection
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $enrollment_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Check if student record exists
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // Calculate qualification status
                            $is_passed = $row['paper1_marks'] >= 30 && $row['paper2_marks'] >= 30 && $row['paper3_marks'] >= 30;
                            $status = $is_passed ? "Passed" : "Failed";
                            $percentage = ($row['marks_total_obtained'] / 300) * 100;

                            // Display student details
                            echo "<h2>Student Details</h2>";
                            echo "<table>
                        <tr><th>Enrolment ID</th><td>{$row['enrollment_id']}</td></tr>
                        <tr><th>Full Name</th><td>{$row['full_name']}</td></tr>
                        <tr><th>Date of Birth</th><td>{$row['date_of_birth']}</td></tr>
                        <tr><th>Gender</th><td>{$row['gender']}</td></tr>
                        <tr><th>Department</th><td>{$row['department']}</td></tr>
                        <tr><th>Programme</th><td>{$row['programme']}</td></tr>
                        <tr><th>Semester</th><td>{$row['Semester']}</td></tr>
                      </table>";

                            // Display marks details if available
                            if (!is_null($row['marks_total_obtained'])) {
                                echo "<h2>Marks Details</h2>";
                                echo "<table>
                            <tr><th>Paper Name</th><th>Paper ID</th><th>Paper Code</th><th>Marks</th></tr>";

                                // Display each paper and marks
                                echo "<tr><td>{$row['paper_name_1']}</td><td>{$row['paper_id_1']}</td><td>{$row['paper_code_1']}</td><td>{$row['paper1_marks']}</td></tr>";
                                echo "<tr><td>{$row['paper_name_2']}</td><td>{$row['paper_id_2']}</td><td>{$row['paper_code_2']}</td><td>{$row['paper2_marks']}</td></tr>";
                                echo "<tr><td>{$row['paper_name_3']}</td><td>{$row['paper_id_3']}</td><td>{$row['paper_code_3']}</td><td>{$row['paper3_marks']}</td></tr>";

                                echo "</table>";

                                // Display total marks obtained, qualification status, and percentage in a table row
                                echo "<table style='margin-top: 20px;'>";
                                echo "<tr><th>Total Marks Obtained</th><th>Qualification Status</th><th>Percentage</th></tr>";
                                echo "<tr>";
                                echo "<td>{$row['marks_total_obtained']}</td>";
                                echo "<td class='" . ($is_passed ? "pass" : "fail") . "'>$status</td>";
                                echo "<td>" . number_format($percentage, 2) . "%</td>";
                                echo "</tr>";
                                echo "</table>";

                                // Display the print button
                                echo "<div class='print-button'>
                            <button onclick='window.print()'>Print Result</button>
                          </div>";
                            } else {
                                echo "<p class='error'>Not all marks have been uploaded by the teacher.</p>";
                            }
                        } else {
                            echo "<p class='error'>Student not found.</p>";
                        }

                        // Close statement and connection
                        $stmt->close();
                        $conn->close();
                    }
                    ?>
                </div>
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
    <script src="Admin-dashboard.js"></script>
    <script>
        initializeDashboard("<?php echo $currentMode; ?>");
    </script>
</body>

</html>
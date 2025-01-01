<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="View-student.css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Favicon -->
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
                    <span class="name">Assignment Management system</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search-alt-2 icon'></i>
                    <input type="search" name="" id="" placeholder="Search...">
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
                <li class="">
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
            <span class="text">View Student</span>
        </div>
    </header>
    <?php
    // Check if a message is set
    if (isset($_SESSION['message'])) {
        // Display the message
        echo '<script>window.onload = function() { showMessage("' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '"); }</script>';
        // Clear the message after displaying it
        unset($_SESSION['message']);
    }
    ?>
    <div class="maintainWidth">
        <section class="home">
            <div class="table-block">
                <div class="heading text">Student Details</div>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Enrolment ID</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Aadhar Number</th>
                                <th>Year</th>
                                <th>Semester</th>
                                <th>Date of Admission</th>
                                <th>Programme</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="students-info">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <div class="btns">
                    <button id="prevBtn" onclick="prevPage()" class="btn">Previous</button>
                    <button id="nextBtn" onclick="nextPage()" class="btn">Next</button>
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
    <script src="view-student.js"></script>
    <script>
        // Parse the URL to extract query parameters
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        // Check if a success message should be displayed
        if (urlParams.has('message') && urlParams.get('message') === 'success') {
            console.log("Hi");
            // Display the success message using alert or any other method you prefer
            alert('Successfully updated!');
        }
    </script>
</body>
</html>

<?php

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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Admin-dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <span class="text">Home</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="upperContent">
                <div class="content" id="content1">
                    <!-- <i class='bx bxs-plus-circle' id="cross"></i> -->
                    <pre id="pre">
                        Hello, Mr. Admin!
                    </pre>
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
</body>
</html>
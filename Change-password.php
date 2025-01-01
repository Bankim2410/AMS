<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the old password and new password are set
    if (isset($_POST["oldPassword"]) && isset($_POST["newPassword"])) {
        
        $oldPassword = $_POST["oldPassword"]; 

        $newPassword = $_POST["newPassword"];
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

        // Retrieve user's stored password from the database (replace 'users' with your actual table name)
        $enrollment_id = $_SESSION['enrollment_id']; // Assuming you store user's email in session
        $sql = "SELECT password FROM student_details WHERE enrollment_id = '$enrollment_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch user's stored password
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];

            // Verify old password
            if ($oldPassword == $storedPassword) {
                // Update user's password in the database
                $updateSql = "UPDATE student_details SET password = '$newPassword' WHERE enrollment_id = '$enrollment_id'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<script>alert('Password changed successfully.');</script>";
                    echo "<script>window.location.href='Student-dashboard.php';</script>";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "<script>alert('Old Password is Incorrect.');</script>";
            }
        } else {
            echo "User not found.";
        }

        // Close database connection
        $conn->close();
    } else {
        echo "Please fill all the fields.";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Change-password.css">
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
                    <li class="nav-link <?php echo $current_page == '' ? 'active-link' : ''; ?>">
                        <a href="">
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
            <span class="text">Change Password</span>
        </div>
    </header>

    <div class="maintainWidth">
        <div class="container">
            <h2>Change Password</h2>
            <form id="passwordForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
                <label for="oldPassword">Old Password:</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <span id="passwordError" class="error"><?php echo $passwordError ?? ''; ?></span>
                <input type="submit" value="Change Password">
            </form>
            <p class="caution">If you don't remember your old password, please contact the administrator via <a href="mailto:jkcgroupa@gmail.com?subject=Password%20Recovery%20Request%20(Enrollment%20No.%20[Your%20Enrollment]%20-%20Department%20[Your%20Department])&body=Dear%20Administrator%2C%0A%0AI%20am%20writing%20to%20request%20assistance%20with%20recovering%20my%20password.%20Unfortunately%2C%20I%20have%20forgotten%20my%20old%20password%20and%20am%20unable%20to%20access%20my%20account.%20Could%20you%20please%20help%20me%20reset%20it%3F%0A%0AThank%20you%20for%20your%20prompt%20attention.%0A%0ASincerely%2C%0A[Your%20Name]%0AEnrollment%20No.%3A%20[Your%20Enrollment]%0ADepartment%3A%20[Your%20Department]">Email</a> or meet in person.</p>

        </div>

        <!-- JavaScript validation remains unchanged -->
        <script>
            function validateForm() {
                var newPassword = document.getElementById("newPassword").value;
                var passwordError = document.getElementById("passwordError");

                // Check if the new password contains at least 2 letters and 3 digits
                var letterCount = newPassword.replace(/[^a-zA-Z]/g, "").length;
                var digitCount = newPassword.replace(/[^0-9]/g, "").length;

                if (letterCount < 2 || digitCount < 3) {
                    passwordError.textContent = "New password must contain at least 2 letters and 3 digits.";
                    return false;
                }

                return true;
            }
        </script>


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
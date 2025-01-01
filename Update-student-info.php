<?php 
$current_page = basename($_SERVER['PHP_SELF']);
// Perform form processing and database operations here

// After processing the form data
if ($form_data_is_valid && $database_operation_successful) {
    // Redirect back to the second code (View-student.html) with a success message
    header("Location: View-student.php?message=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>

    <!-- CSS -->
    <link rel="stylesheet" href="Student_DataEntry.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="User-dashboard.css">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                    <li class="nav-link <?php echo $current_page == 'User-dashboard.php' ? 'active-link' : ''; ?>">
                        <a href="User-dashboard.php">
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
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="">
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
            <span class="text">Update Student</span>
        </div>
    </header>

    <div class="maintainWidth">
        <section class="home">
            <div class="container">
                <header>Edit Student</header>

                <form action="update-student-query.php" method="post">
                <?php
                // Establish a connection to your database
                $servername = "localhost";
                $username = "root"; // Update with your database username
                $password = ""; // Update with your database password
                $dbname = "assn_mgn"; // Update with your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve student ID from URL parameter
                $enrollment_id = $_GET['id'];

                // Prepare SQL statement to fetch student information
                $sql = "SELECT * FROM student_details WHERE enrollment_id='$enrollment_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of the first (and only) row
                    $row = $result->fetch_assoc();
                    $selectedDepartment = $row['department']; // Store the selected department
                    ?>
                    <!-- Hidden input field to store the student ID -->
                    <input type="hidden" name="enrollment_id" value="<?php echo $row['enrollment_id']; ?>">
                    <div class="form first">
                        <div class="details personnel">
                            <span class="title">Personnel Details</span>
                        </div>
                        <div class="fields">
                            <div class="input-field">
                                <label>Full Name:</label>
                                <input type="text" placeholder="Enter Your Name" name="full_name" required  value="<?php echo $row['full_name']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Date Of Birth:</label>
                                <input type="date" required id="dob" name="date_of_birth"  value="<?php echo $row['date_of_birth']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Email:</label>
                                <input type="email" placeholder="Enter Your Email" name="email" required  value="<?php echo $row['email']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Mobile Number:</label>
                                <input type="number" placeholder="Enter Your Mobile Number" name="mobile_no" required  value="<?php echo $row['mobile_no']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Gender:</label>
                                <select id="gender" name="gender" required>
                                    <option value="" disabled>Select Gender:</option>
                                    <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Others" <?php if ($row['gender'] == 'Others') echo 'selected'; ?>>Others</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <label>Address:</label>
                                <input type="text" placeholder="Enter Your Address" name="address" required value="<?php echo $row['address']; ?>">
                            </div>

                        </div>
                    </div>

                    <!--here-->
                    <div class="form first">
                        <div class="details personnel">
                            <span class="title">Course & Other Details:</span>
                        </div>
                        <div class="fields">
                            <div class="input-field">
                                <label>Aadhar Card Number:</label>
                                <input type="text" placeholder="Enter Aadhar Card No." name="aadhar_no" required value="<?php echo $row['aadhar_no']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Year:</label>
                                <input type="text" placeholder="Enter Your Year" name="s_year" required value="<?php echo $row['s_year']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Semester:</label>
                                <input type="text" placeholder="Enter Your Semester" name="Semester" required value="<?php echo $row['Semester']; ?>"> 
                            </div>

                            <div class="input-field">
                                <label>Date Of Admission:</label>
                                <input type="date" required id="dos" name="date_admission" value="<?php echo $row['date_admission']; ?>">
                            </div>
                            <div class="input-field">
                                <label for="programme">Programme Title & Code:</label>
                                <select id="programme" name="programme" onchange="populateDepartments()" required>
                                    <option value="" disabled>Select Programme:</option>
                                    <option value="B.Sc." <?php if ($row['programme'] == 'B.Sc.') echo 'selected'; ?>>B.Sc.</option>
                                    <option value="B.A." <?php if ($row['programme'] == 'B.A.') echo 'selected'; ?>>B.A.</option>
                                </select>
                            </div>
                            <div class="input-field" id="departmentDropdown" style="display:none; width:235px;">
                                <label for="department">Department:</label>
                                <select id="department" name="department" required>
                                    <option value="" disabled>Choose Department</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="input-field register">
                                <button name="Register" class="sign" type="submit" onclick="alert('Do You Want to Submit all the Data?')">Update</button>
                            </div>
                            <div class="input-field reset">
                                <button name="resetbutton" style="font-size: 13pt;" type="reset" onclick="alert('Do You Want to all Reset the Data?')">Reset</button>
                            </div>
                        </div>
                        <?php
                } else {
                    echo "No student found with the provided ID.";
                }

                // Close the database connection
                $conn->close();
                ?>
                <button><a href="View-student.php" style="text-decoration:none; color:white; font-size: 15px;">Back to View Student</a></button>
                </form>
            </div>
            <script>
                function populateDepartments() {
                    var selectedProgramme = document.getElementById("programme").value;
                    var selectedDepartment = "<?php echo $selectedDepartment; ?>"; // Fetch the previously selected department
                    var departmentSelect = document.getElementById("department");

                    // Clear previous options
                    departmentSelect.innerHTML = '';

                    // Show the department dropdown
                    document.getElementById("departmentDropdown").style.display = "block";

                    // Populate options based on selected program
                    if (selectedProgramme === "B.Sc.") {
                        var bscDepartments = ["COSH", "CHEM", "MATH"];
                        bscDepartments.forEach(function(department) {
                            var option = document.createElement("option");
                            option.text = department;
                            option.value = department;
                            if (department === selectedDepartment) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    } else if (selectedProgramme === "B.A.") {
                        var baDepartments = ["HIST", "BENG", "ENG"];
                        baDepartments.forEach(function(department) {
                            var option = document.createElement("option");
                            option.text = department;
                            option.value = department;
                            if (department === selectedDepartment) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    }
                }

                // Call populateDepartments on page load with the previously selected department
                document.addEventListener('DOMContentLoaded', function() {
                    populateDepartments();
                });
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
</body>

</html>

<?php
require "connect.php";
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Details</title>

        <!-- CSS -->

        <link rel="stylesheet" href="Student_DataEntry.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="User-dashboard.css">

        <!-- Boxicons -->

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- JavaScript -->



    </head>

    <body>
        <nav class="sidebar close">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="image/logo.png" alt="Photo">
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
                        <li class="nav-link">
                            <a href="admin-dashboard.php">
                                <i class='bx bx-home icon'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="assignment-submit.php">
                                <i class='bx bx-upload icon'></i>
                                <span class="text nav-text">Assignment Submission portal</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bxs-add-to-queue icon'></i>
                                <span class="text nav-text">Add Student</span>
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
                <span class="text">Add Student</span>
            </div>
        </header>

        <div class="maintainWidth">
            <section class="home">
                <div class="container">
                    <header>Add Student</header>

                    <form action="student_signup.php" method="post">
                        <div class="form first">
                            <div class="details personnel">
                                <span class="title">Personnel Details</span>
                            </div>
                            <div class="fields">
                                <div class="input-field">
                                    <label>Full Name:</label>
                                    <input type="text" placeholder="Enter Your Name" name="full_name" required>
                                </div>
                                <div class="input-field">
                                    <label>Date Of Birth:</label>
                                    <input type="date" required id="dob" name="date_of_birth">
                                </div>
                                <div class="input-field">
                                    <label>Email:</label>
                                    <input type="email" placeholder="Enter Your Email" name="email" required>
                                </div>
                                <div class="input-field">
                                    <label>Mobile Number:</label>
                                    <input type="number" placeholder="Enter Your Mobile Number" name="mobile_no" required>
                                </div>
                                <div class="input-field">
                                    <label>Gender:</label>
                                    <select id="gender" name="gender" required>
                                        <option value="" disabled selected>Select Gender:</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <label>Address:</label>
                                    <input type="text" placeholder="Enter Your Address" name="address" required>
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
                                    <input type="text" placeholder="Enter Aadhar Card No." name="aadhar_no" required>
                                </div>
                                <div class="input-field">
                                    <label>Year:</label>
                                    <input type="text" placeholder="Enter Your Year" name="s_year" required>
                                </div>
                                <div class="input-field">
                                    <label>Semester:</label>
                                    <input type="text" placeholder="Enter Your Semester" name="semester" required>
                                </div>

                                <div class="input-field">
                                    <label>Date Of Admission:</label>
                                    <input type="date" required id="dos" name="date_admission">
                                </div>
                                <div class="input-field">
                                    <label for="programme">Programme Title & Code:</label>
                                    <select id="programme" name="programme" onchange="populateSubjects()" required>
                                        <option value="" disabled selected>Select Programme:</option>
                                        <option value="B.Sc.">B.Sc.</option>
                                        <option value="B.A.">B.A.</option>
                                    </select>
                                </div>
                                <div class="input-field" id="subjectDropdown">
                                    <label for="subject">Choose Subject:</label>
                                    <select id="subject" name="subject" required>
                                        <option value="" disabled selected>Choose Subject</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                                <div class="input-field register">
                                    <button name="Register" class="sign" type="submit" onclick="alert('Do You Want to Submit all the Data?')">Register</button>
                                </div>
                                <div class="input-field reset">
                                    <button name="resetbutton" style="font-size: 13pt;" type="reset" onclick="alert('Do You Want to all Reset the Data?')">Reset</button>
                                </div>
                            </div>

                    </form>
                </div>
                <script>
                    function populateSubjects() {
                        var programSelect = document.getElementById("programme");
                        var subjectDropdown = document.getElementById("subjectDropdown");
                        var subjectSelect = document.getElementById("subject");

                        // Clear previous options
                        subjectSelect.innerHTML = '';

                        // Show the subject dropdown
                        subjectDropdown.style.display = "block";

                        // Enable subject dropdown only if a program is selected
                        subjectSelect.disabled = false;

                        // Populate options based on selected program
                        if (programSelect.value === "B.Sc.") {
                            var bscSubjects = ["COSH", "CHEM", "MATH"];
                            bscSubjects.forEach(function(subject) {
                                var option = document.createElement("option");
                                option.text = subject;
                                option.value = subject;
                                subjectSelect.appendChild(option);
                            });
                        } else if (programSelect.value === "B.A.") {
                            var baSubjects = ["HIST", "BENG", "ENG"];
                            baSubjects.forEach(function(subject) {
                                var option = document.createElement("option");
                                option.text = subject;
                                option.value = subject;
                                subjectSelect.appendChild(option);
                            });
                        }
                    }
                </script>


            </section>
        </div>

        <!--<footer>
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
            <span class="img"> <img src="image/FooterLogo.png" alt="image" class="footerlogo"> 
                <img src="image/FooterLogo2.png" alt="image" class="footerlogo">
                <img src="image/FooterLogo3.png" alt="image" class="footerlogoEnd">
            </span>
        </div>
    </footer>-->
        <script src="script.js"></script>
    </body>

    </html>

<?php
} else {
    header('Location: index.php'); // Redirect to index page if not logged in
    exit();
}

?>
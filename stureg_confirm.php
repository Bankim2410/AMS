<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h2 {
            font-size: 32px;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .enrollment-number,
        .password {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .enrollment-number span {
            color: #008000;
        }

        .password span {
            color: #ff5733;
        }

        .buttons-container {
            text-align: center;
            margin-top: 20px;
        }

        .exit-button,
        .print-button {
            display: inline-block;
            width: 150px;
            margin: 0 10px;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .exit-button:hover,
        .print-button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 28px;
                margin-bottom: 15px;
            }

            p {
                font-size: 14px;
                margin-bottom: 8px;
            }

            .enrollment-number,
            .password {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .exit-button,
            .print-button {
                width: 120px;
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <?php
        // Retrieve the enrollment ID and password from the URL
        if (isset($_GET['enrollment_id']) && isset($_GET['password'])) {
            $enrollment_id = $_GET['enrollment_id'];
            $password = $_GET['password'];

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $database = "assn_mgn";

            $conn = mysqli_connect($servername, $username, $password_db, $database);
            if (!$conn) {
                die('Connection Failed: ' . mysqli_connect_error());
            }

            // Retrieve student details from the database
            $sql = "SELECT * FROM student_details WHERE enrollment_id = '$enrollment_id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $full_name = $row['full_name'];
                $date_of_birth = $row['date_of_birth'];
                $gender = $row['gender'];
                $email = $row['email'];
                $mobile_no = $row['mobile_no'];
                $address = $row['address'];
                $study_year = $row['s_year'];
                $semester = $row['Semester'];
                $date_admission = $row['date_admission'];
                $programme = $row['programme'];
                $subjects = $row['department'];
                // Add more details here as needed
            }

            // Display student details and enrollment number
            echo "<h2>Registration Confirmation</h2>";
            echo "<p><strong>Full Name:</strong> $full_name</p>";
            echo "<p><strong>Date of Birth:</strong> $date_of_birth</p>";
            echo "<p><strong>Gender:</strong> $gender</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Mobile Number:</strong> $mobile_no</p>";
            echo "<p><strong>Address:</strong> $address</p>";
            echo "<p><strong>Year:</strong> $study_year </p>";
            echo "<p><strong>Semester:</strong> $semester</p>";
            echo "<p><strong>Date of Admission:</strong> $date_admission</p>";
            echo "<p><strong>Programme:</strong> $programme</p>";
            echo "<p><strong>Subject:</strong> $subjects</p>";

            // Display the enrollment number and generated password
            echo "<p class='enrollment-number'><b>Your Enrolment Number: <br><span>$enrollment_id</span></b></p>";
            echo "<p class='password'><b>Your Password: <br><span>$password</span></b></p>";

            // Close the database connection
            mysqli_close($conn);
        } else {
            // Handle case where enrollment ID or password is not found in the URL
            echo "<p>Error: Enrollment ID or Password not found.</p>";
        }
        ?>
        <div class="buttons-container">
            <a href="Student_DataEntry.php" class="print-button" onclick="window.print();">Print</a>
            <a href="Student_DataEntry.php" class="exit-button">Exit</a>
        </div>
    </div>
</body>

</html>
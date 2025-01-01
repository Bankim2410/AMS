<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .caution {
            color: #999;
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }

        .caution a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .caution a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
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

    <?php
    // Start session
    session_start();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the old password and new password are set
        if (isset($_POST["oldPassword"]) && isset($_POST["newPassword"])) {
            // Validate the old password (you may want to perform additional validation here)
            $oldPassword = $_POST["oldPassword"]; // Assuming the form is using POST method

            // Validate the new password format (already done with JavaScript)
            $newPassword = $_POST["newPassword"];

            // Database connection parameters
            $servername = "localhost:3307";
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
                        echo "<script>window.location.href='student_dashboard.php';</script>";
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
    ?>

</body>

</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "assn_mgn";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die('Connection Failed: ' . mysqli_connect_error());
}

$aadhar_no = $_POST['aadhar_no'];

$sql = "SELECT * FROM student_details WHERE aadhar_no = '$aadhar_no'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<p style="color: #ff5733; font-size: 20px; font-weight: bold; text-align: center;font-family: verdana ; border: 2px solid #ff5733; padding: 10px;">Record Already Present in The Database!</p>';
} else {
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $mobile_no  = $_POST['mobile_no'];
    $gender  = $_POST['gender'];
    $address = $_POST['address'];
    $study_year = $_POST['s_year'];
    $semester = $_POST['semester'];
    $date_admission = $_POST['date_admission'];
    $programme = $_POST['programme'];
    $subject = $_POST['subject']; // Department name

    // Generate enrollment ID
    $sql_last_id = "SELECT enrollment_id FROM student_details ORDER BY enrollment_id DESC LIMIT 1";
    $result_last_id = mysqli_query($conn, $sql_last_id);

    if (mysqli_num_rows($result_last_id) > 0) {
        $row = mysqli_fetch_assoc($result_last_id);
        $last_enrollment_id = $row['enrollment_id'];
        $enrollment_id = $last_enrollment_id + 1; // Increment the last ID
    } else {
        // If there are no existing IDs, start from 1000000001
        $enrollment_id = 1000000001;
    }

    // Function to generate password
    function generatePassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        $charPart = '';
        for ($i = 0; $i < 2; $i++) {
            $charPart .= $characters[rand(0, strlen($characters) - 1)];
        }
        $digitPart = '';
        for ($i = 0; $i < 3; $i++) {
            $digitPart .= $digits[rand(0, strlen($digits) - 1)];
        }
        return $charPart . $digitPart;
    }

    // Generate the password
    $password = generatePassword();

    // Fetch department ID based on department name
    $sql_dept_id = "SELECT dept_id FROM departments WHERE dept_name = '$subject'";
    $result_dept_id = mysqli_query($conn, $sql_dept_id);
    $row_dept_id = mysqli_fetch_assoc($result_dept_id);
    $dept_id = $row_dept_id['dept_id'];

    // Fetch paper IDs for the department and semester
    $sql_paper_ids = "SELECT paper_id FROM papers_of_departments WHERE dept_id = $dept_id AND semester = $semester";
    $result_paper_ids = mysqli_query($conn, $sql_paper_ids);
    $paper_ids = [];
    while ($row_paper = mysqli_fetch_assoc($result_paper_ids)) {
        $paper_ids[] = $row_paper['paper_id'];
    }

    // Insert data into student_details table
    $sql_insert_student = "INSERT INTO student_details (enrollment_id, full_name, date_of_birth, email, mobile_no, gender, address, aadhar_no, s_year, semester, date_admission, programme, department, password) 
                           VALUES ('$enrollment_id', '$full_name', '$date_of_birth', '$email', '$mobile_no', '$gender', '$address', '$aadhar_no','$study_year', '$semester', '$date_admission', '$programme', '$subject', '$password')";

    if (mysqli_query($conn, $sql_insert_student)) {
        // Insert data into student_marks_details table
        $sql_insert_marks = "INSERT INTO student_marks_details (enrollment_id, dept_id, semester, paper_id_1, paper_id_2, paper_id_3)
                             VALUES ('$enrollment_id', '$dept_id', '$semester', '$paper_ids[0]', '$paper_ids[1]', '$paper_ids[2]')";
        if (mysqli_query($conn, $sql_insert_marks)) {
            // Redirect to the confirmation page
            header("Location: stureg_confirm.php?enrollment_id=$enrollment_id&password=$password");
        } else {
            echo "<script>alert('Error adding marks to student_marks_details table')</script>";
            echo "Error: " . $sql_insert_marks . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Database error! Please check your data before input.')</script>";
        echo "Error: " . $sql_insert_student . "<br>" . mysqli_error($conn);
    }
}
mysqli_close($conn);

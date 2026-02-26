<?php
include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $yob = $_POST["yob"];
    $student_id = trim($_POST["student_id"]);
    $pattern = "/^SCT211-(?!0000)\d{4}\/\d{4}$/";
    $phone_number = trim($_POST["contact_number"]);
    $phone_pattern = "/^\+254[71]\d{8}$/";
    $course_id = $_POST["course_id"];

    $errors = [];

    $currentYear = (int)date("Y");
    $minAge = 16;
    $maxAge = 100;

    $maxYear = $currentYear - $minAge;
    $minYear = $currentYear - $maxAge;

    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (!filter_var($yob, FILTER_VALIDATE_INT, ["options" => ["min_range" => $minYear, "max_range" => $maxYear]])) {
        $errors[] = "Student must be between $minAge and $maxAge years old (Birth year: $minYear - $maxYear).";
    }
    if (empty($student_id)) {
        $errors[] = "Student ID is required.";
    }
    if (!preg_match($pattern, $student_id)) {
        $errors[] = "Invalid Student ID. The numeric part must be between 0001 and 9999. Format: SCT211-0000/YYYY";
    }
    if (empty($phone_number)) {
        $errors[] = "Contact number is required.";
    }
    if (!preg_match($phone_pattern, $phone_number)) {
        $errors[] = "Invalid phone number format. Must be in the format +2547XXXXXXXX or +2541XXXXXXXX.";
    }
    if (!filter_var($course_id, FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid course selection.";
    }

    if (empty($errors)) {
        $check_sql = "SELECT student_id, phone_number FROM students WHERE student_id = ? OR phone_number = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        
        if ($check_stmt) {
            mysqli_stmt_bind_param($check_stmt, "ss", $student_id, $phone_number);
            mysqli_stmt_execute($check_stmt);
            $result = mysqli_stmt_get_result($check_stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['student_id'] === $student_id) {
                    $errors[] = "This Student ID is already registered.";
                }
                if ($row['phone_number'] === $phone_number) {
                    $errors[] = "This phone number is already in use.";
                }
            }
            mysqli_stmt_close($check_stmt);
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO students (full_name, student_id, phone_number, year_of_birth, course_id) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssii", $fullname, $student_id, $phone_number, $yob, $course_id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: ../admin/dashboard.php?status=success");
                    exit();
                }
            } catch (mysqli_sql_exception $e) {
                echo "Database Error: " . $e->getMessage();
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>- " . htmlspecialchars($error) . "</p>";
        }
        echo "<button onclick='window.history.back()'>Go Back</button>";
    }
}

mysqli_close($conn);
?>
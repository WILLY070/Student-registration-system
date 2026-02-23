<?php
include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect raw data - no need to escape manually with prepared statements
    $fullname = $_POST["fullname"];
    $yob = $_POST["yob"];
    $student_id = $_POST["student_id"];
    $phone_number = $_POST["contact_number"];
    $course_id = $_POST["course_id"];

    // 1. Prepare the SQL template with placeholders (?)
    $sql = "INSERT INTO students (full_name, student_id, phone_number, year_of_birth, course_id) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        /* 2. Bind variables to the placeholders
           "ssssi" means: string, string, string, integer, integer
           Adjust these letters based on your database column types
        */
        mysqli_stmt_bind_param($stmt, "sssii", $fullname, $student_id, $phone_number, $yob, $course_id);

        try {
            // 3. Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../admin/dashboard.php?status=success");
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo "Database Error: " . $e->getMessage();
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Statement Preparation Failed: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<?php
include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect raw data
    $fullname = $_POST["fullname"];
    $yob = $_POST["yob"];
    $student_id = $_POST["student_id"];
    $phone_number = $_POST["contact_number"];
    $course_id = $_POST["course_id"];
    $id = $_POST["internal_id"];

    // 1. Prepare the SQL template with placeholders
    $sql = "UPDATE students 
            SET full_name = ?, student_id = ?, phone_number = ?, year_of_birth = ?, course_id = ? 
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        /* 2. Bind variables
           Order: full_name (s), student_id (s), phone_number (s), yob (i), course_id (i), id (i)
           Type string: "sssiii"
        */
        mysqli_stmt_bind_param($stmt, "sssiii", $fullname, $student_id, $phone_number, $yob, $course_id, $id);

        try {
            // 3. Execute
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../admin/dashboard.php?status=updated");
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo "Database Error: " . $e->getMessage();
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Statement Preparation Failed: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
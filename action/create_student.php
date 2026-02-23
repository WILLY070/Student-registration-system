<?php
include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $yob = mysqli_real_escape_string($conn, $_POST["yob"]);
    $student_id = mysqli_real_escape_string($conn, $_POST["student_id"]);
    $phone_number = mysqli_real_escape_string($conn, $_POST["contact_number"]);
    $course_id = mysqli_real_escape_string($conn, $_POST["course_id"]);

    $sql = "INSERT INTO students (full_name, student_id, phone_number, year_of_birth, course_id) 
            VALUES ('$fullname', '$student_id', '$phone_number', '$yob', '$course_id')";

    try {
        if (mysqli_query($conn, $sql)) {
            header("Location: ../admin/dashboard.php?status=success");
            exit(); 
        }
    } catch (mysqli_sql_exception $e) {
        echo "Database Error: " . $e->getMessage();
    }
}

mysqli_close($conn);
?>
<?php
include('../config/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../admin/dashboard.php?status=deleted");
        } else {
            header("Location: ../admin/dashboard.php?status=error");
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../admin/dashboard.php?status=error");
    }
    
    mysqli_close($conn);
    exit();
}
?>
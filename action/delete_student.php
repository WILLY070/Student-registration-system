<?php
include('../config/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Sanitize the input by forcing it to be an integer
    $id = (int)$_POST['id'];

    // Procedural mysqli_query instead of $conn->prepare
    $query = "DELETE FROM students WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        header("Location: ../admin/dashboard.php?status=deleted");
    } else {
        header("Location: ../admin/dashboard.php?status=error");
    }
    
    // Procedural close
    mysqli_close($conn);
    exit();
}
?>
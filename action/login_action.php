<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Use a placeholder for the username
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // 2. Bind and execute
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        
        // 3. Get the result
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);

        if ($admin && password_verify($password, $admin['password'])) {
            // Success! Store admin info in session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            // Same error for both wrong user and wrong password
            header("Location: ../index.php?error=invalid_credentials");
            exit();
        }

        mysqli_stmt_close($stmt);
    }
}
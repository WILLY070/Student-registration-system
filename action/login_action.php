<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            $admin = mysqli_fetch_assoc($result);

            if ($admin && password_verify($password, $admin['password'])) {
                if (!empty($_POST['remember_user'])) {
                    setcookie("saved_username", $username, [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                } else {
                    setcookie("saved_username", "", time() - 3600, "/");
                }

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                header("Location: ../index.php?error=invalid_credentials");
                exit();
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        header("Location: ../index.php?error=empty_fields");
        exit();
    }
}
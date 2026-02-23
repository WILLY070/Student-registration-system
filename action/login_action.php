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

    // 3. Only hit the database if formats are valid
    if (empty($errors)) {
        $query = "SELECT * FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            $admin = mysqli_fetch_assoc($result);

            // 4. Verify Credentials
            if ($admin && password_verify($password, $admin['password'])) {
                // Handle "Remember Username" Cookie
                if (!empty($_POST['remember_user'])) {
                    // Set cookie for 30 days
                    setcookie("saved_username", $username, [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'httponly' => true, // Security: prevents JS access
                        'samesite' => 'Lax'
                    ]);
                } else {
                    // If not checked, delete the cookie by setting it to the past
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
        // Handle empty field errors
        header("Location: ../index.php?error=empty_fields");
        exit();
    }
}
<?php
session_start();
require_once '../config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

if ($admin && password_verify($password, $admin['password'])) {
    // 1. Success! Store admin ID in the session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['username'];
    
    header("Location: ../admin/dashboard.php");
    exit();
} else {
    header("Location: ../index.php?error=invalid_credentials");
    exit();
}
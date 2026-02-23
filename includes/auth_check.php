<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    // If no session exists, kick them back to the login page
    header("Location: ../index.php");
    exit();
}
?>
<?php
session_start();
include 'db_login.php';

// Function to logout the user
function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if logout is requested
if(isset($_GET['logout'])) {
    logout();
}

$isLoggedIn = isset($_SESSION['username']);
?>

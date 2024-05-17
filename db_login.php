<?php
// Function to make connection to login database
function db_login() {
    $db_login = new mysqli('localhost', 'tc782_tom2', 'Tfbh985mDZk3Yuk', 'tc782_user_login');

    if ($db_login->connect_error) {
        die("Connection failed: " . $db_login->connect_error);
    }

    return $db_login;
}

$conn = db_login();
?>

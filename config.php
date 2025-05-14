<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'crud';

// Create connection with error handling
$con = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($con, "utf8");
?>
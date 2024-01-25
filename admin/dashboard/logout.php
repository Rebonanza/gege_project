<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['user'])) {
    // If logged in, destroy the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
}

// Redirect the user to the login page or any other page
header("Location: login.php");
exit();
?>

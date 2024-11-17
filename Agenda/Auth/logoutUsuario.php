<?php
session_start(); // Start the session


session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the home or login page
header('Location: index.php'); // This could be your login page or a common home page
exit();
?>
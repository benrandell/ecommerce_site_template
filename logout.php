<?php
// Start or resume the session
session_start();

// Clear the selectedItems in $_SESSION
unset($_SESSION['selectedItems']);

// Destroy the session
session_destroy();

// Redirect the user to the login page (or any other page you want)
header("Location: login.php");
exit();
?>

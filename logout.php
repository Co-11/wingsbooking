<!-- divya -->


<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page (or homepage)
header("Location: login.php");
exit;
?>

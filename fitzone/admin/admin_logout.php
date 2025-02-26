<?php
session_start();
session_unset();
session_destroy(); // Destroy all session data

// Set a session message for logout success
session_start();
$_SESSION['logout_message'] = "You have successfully logged out.";

// Redirect to the admin login page
header("Location: ../admin_staff_login.php");
exit();
?>

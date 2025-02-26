<?php
session_start();
session_unset();
session_destroy();

session_start(); // Start a new session to set the success message
$_SESSION['success'] = 'You have successfully logged out.';
header("Location: customer_login.php");
exit;
?>

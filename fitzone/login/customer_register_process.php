<?php
session_start(); 
include '../database_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form input (basic server-side validation)
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = "All fields are required.";
        header("Location: ../customer_register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: ../customer_register.php");
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM customers WHERE email = '$email' LIMIT 1";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['register_error'] = "An account with this email already exists.";
        header("Location: ../customer_register.php");
        exit;
    }

    // Insert the new customer into the database
    $query = "INSERT INTO customers (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['register_success'] = "Registration successful! You can now log in.";
        header("Location: ../customer_register.php"); 
        exit;
    } else {
        $_SESSION['register_error'] = "An error occurred. Please try again.";
        header("Location: ../customer_register.php");
        exit;
    }
} else {
    // Redirect to the registration page if not a POST request
    header("Location: ../customer_register.php");
    exit;
}
?>

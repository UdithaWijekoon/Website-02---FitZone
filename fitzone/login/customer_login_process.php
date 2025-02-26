<?php
session_start();
include '../database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query to get the customer with the provided username
    $query = "SELECT * FROM customers WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $customer = mysqli_fetch_assoc($result);

        // Verify the password using password_verify
        if (password_verify($password, $customer['password'])) {
            // Set session variables
            $_SESSION['customer_id'] = $customer['id'];
            $_SESSION['customer_username'] = $customer['username'];
            $_SESSION['is_logged_in'] = true;

            // Set success message
            $_SESSION['success'] = 'Login successful! Welcome, ' . $_SESSION['customer_username'] . '.';

            // Redirect to the index page
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['error'] = 'Invalid password. Please try again.';
            header("Location: ../customer_login.php");
        }
    } else {
        $_SESSION['error'] = 'Invalid username. Please try again.';
        header("Location: ../customer_login.php");
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header("Location: ../customer_login.php");
}
?>

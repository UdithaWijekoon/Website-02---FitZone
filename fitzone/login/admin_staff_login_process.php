<?php
session_start();
include '../database_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$query = "SELECT * FROM administration_accounts WHERE username = ? AND role = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ss', $username, $role);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $row['password'])) {
        session_regenerate_id(true); // Prevent session fixation attacks
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Set success message
        $_SESSION['success'] = 'Login successful! Welcome, ' . $_SESSION['username'] . '.';

        if ($role === 'admin') {
            header("Location: ../admin/admin_home.php");
        } elseif ($role === 'staff') {
            header("Location: ../staff/staff_home.php");
        }
        exit();
    } else {
        $_SESSION['error'] = 'Incorrect password. Please try again.';
        header("Location: ../admin_staff_login.php");
    }
} else {
    $_SESSION['error'] = 'Invalid username or role. Please try again.';
    header("Location: ../admin_staff_login.php");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

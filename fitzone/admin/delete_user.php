<?php
session_start();
include '../database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    // Determine the table based on role
    if ($role === 'admin' || $role === 'staff') {
        $table = 'administration_accounts';
    } elseif ($role === 'customer') {
        $table = 'customers';
    } else {
        $_SESSION['error'] = "Invalid user role.";
        header("Location: manage_users.php");
        exit();
    }

    // Prepare delete query
    $query = "DELETE FROM $table WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);

    try {
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = ucfirst($role) . " deleted successfully.";
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint failure
        if ($e->getCode() == 1451) { // Error code for foreign key constraint
            $_SESSION['error'] = "Failed to delete the user. Please ensure the user is not associated with other data.";
        } else {
            $_SESSION['error'] = "Error deleting $role.";
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: manage_users.php");
    exit();
}

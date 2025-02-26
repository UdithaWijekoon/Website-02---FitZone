<?php
include 'database_connection.php';
session_start(); // Start session to use session variables

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $plan_id = isset($_POST['plan_id']) ? (int)$_POST['plan_id'] : 0;

    if ($plan_id > 0) {
        // Insert membership record into user_memberships table
        $query = "INSERT INTO user_memberships (user_id, plan_id, start_date) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $plan_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Membership Successfully submitted to admin panel.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: Could not confirm membership.";
            $_SESSION['message_type'] = "error";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Invalid membership plan.";
        $_SESSION['message_type'] = "error";
    }

    // Redirect back to user_membership.php
    header("Location: user_membership.php?plan_id=" . $plan_id);
    exit();
}
?>

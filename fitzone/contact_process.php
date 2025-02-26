<?php
session_start();
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $subject, $message);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Thank you for contacting us! We will get back to you soon.";
    } else {
        $_SESSION['error_message'] = "There was an error submitting your message. Please try again later.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect back to contact.php
    header("Location: contact.php");
    exit();
}
?>

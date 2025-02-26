<?php
session_start(); // Start the session
include 'database_connection.php';

$id = $_GET['id'];

// Delete blog post
$sql = "DELETE FROM blog_posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Blog post deleted successfully!";
} else {
    $_SESSION['error_message'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: manage_blogs.php");
exit();
?>

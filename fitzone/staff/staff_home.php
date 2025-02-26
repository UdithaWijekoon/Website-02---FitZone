<?php
session_start();

// Check if the user is logged in and if they have the 'staff' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../admin_staff_login.php");
    exit();
}

include '../database_connection.php';
include 'assists/header_staff.php'; 
?>
<style>
    /* Popup and Card Styling */
    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
        text-align: center;
    }
    .card {
        display: inline-block;
        width: 300px;
        margin: 15px;
        padding: 30px;
        background-color: #464646;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, background-color 0.3s;
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
        position: relative;
    }
    .card:hover {
        transform: translateY(-5px);
        background-color: #2d2d2d;
    }
    .card .icon {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ff4c4c;
    }
    .card .count {
        font-size: 2.5rem;
        color: #fff;
    }
    .popup {
        position: fixed;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ff4c4c;
        color: #333;
        border: 2px solid #333;
        padding: 20px;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: bold;
        display: none;
        z-index: 1000;
    }
    .popup.show {
        display: block;
        animation: fadeInOut 4s ease forwards;
    }
    @keyframes fadeInOut {
        0%, 100% { opacity: 0; }
        10%, 90% { opacity: 1; }
    }
</style>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is the Staff Dashboard where you can view and manage your assigned tasks.</p>

    <?php
        // Queries for counts
        $totalMessages = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];
        $totalTrainers = $conn->query("SELECT COUNT(*) as count FROM trainers")->fetch_assoc()['count'];
        $totalBlogs = $conn->query("SELECT COUNT(*) as count FROM blog_posts")->fetch_assoc()['count'];

        // Close connection
        $conn->close();
    ?>

    <!-- Cards with Font Awesome icons -->
    <div class="card">
        <div class="icon"><i class="fas fa-dumbbell"></i></div>
        <h3>Total Trainers</h3>
        <p><?php echo $totalTrainers; ?></p>
    </div>
    <div class="card">
        <div class="icon"><i class="fas fa-envelope"></i></div>
        <h3>Total Messages</h3>
        <p><?php echo $totalMessages; ?></p>
    </div>
    <div class="card">
        <div class="icon"><i class="fas fa-blog"></i></div>
        <h3>Total Blogs</h3>
        <p><?php echo $totalBlogs; ?></p>
    </div>
</div>

<?php
    // Display success message if set
    if (isset($_SESSION['success'])) {
        echo "<div class='popup show'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']); // Clear the message after displaying
    }
?>

<?php include 'assists/footer_staff.php'; ?>

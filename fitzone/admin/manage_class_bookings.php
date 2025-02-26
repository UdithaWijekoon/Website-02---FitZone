<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}

include 'database_connection.php';

// Handle status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Status updated successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating status. Please try again.";
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();

    // Refresh the page to reflect the update and display the message
    header("Location: manage_class_bookings.php");
    exit();
}

// Fetch all bookings with class name, customer username, and schedule details
$bookings = $conn->query("
    SELECT b.booking_id, b.status, b.booking_date,
           c.name AS class_name, cust.username AS customer_name,
           cs.date AS schedule_date, cs.time AS schedule_time,
           cs.trainer AS trainer_name 
    FROM bookings b
    JOIN classes c ON b.class_id = c.id
    JOIN customers cust ON b.customer_id = cust.id
    JOIN class_schedule cs ON b.schedule_id = cs.id
");
include 'assists/header_admin.php';
?>
<style>
    /* General styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #1c1c1c;
    margin: 0;
    padding: 0;
}

.manage-class-bookings {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    color: #f4f4f9;
}

.manage-class-bookings h1 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #2a2a2a;
    color: #f4f4f9;
}

table, th, td {
    border: 1px solid #444;
}

th {
    padding: 10px;
    background-color: #ff4c4c;
    color: #fff;
    text-align: center;
}

td {
    padding: 10px;
    background-color: #333;
    text-align: center;
}

/* Status dropdown and button styling */
form {
    display: inline-block;
}

form select {
    padding: 5px;
    border: 1px solid #555;
    border-radius: 4px;
    background-color: #222;
    color: #f4f4f9;
}

.btn2 {
    padding: 5px 10px;
    background-color: #ff4c4c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 5px;
}

form button[type="submit"]:hover {
    background-color: #d14040;
}

/* Responsive design */
@media (max-width: 768px) {
    .manage-class-bookings {
        padding: 10px;
    }
    table, form {
        width: 100%;
    }
}
.message {
    max-width: 1000px;
    margin: 10px auto;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
}

.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
<section class="manage-class-bookings">
    <h1>Manage Class Bookings</h1>
    <!-- Display Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?= $_SESSION['message_type'] ?>">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
    <?php endif; ?>
    <!-- Bookings Table -->
    <table border="1">
        <tr>
            <th>Class Name</th>
            <th>Customer Name</th>
            <th>Trainer</th>
            <th>Schedule Date</th>
            <th>Schedule Time</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($booking = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($booking['class_name']) ?></td>
                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                <td><?= htmlspecialchars($booking['trainer_name']) ?></td>
                <td><?= htmlspecialchars($booking['schedule_date']) ?></td>
                <td><?= htmlspecialchars($booking['schedule_time']) ?></td>
                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <td>
                    <!-- Update Status Form -->
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                        <select name="status">
                            <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="canceled" <?= $booking['status'] === 'canceled' ? 'selected' : '' ?>>Canceled</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                        <button type="submit" class="btn2">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>
<?php include 'assists/footer_admin.php'; ?>
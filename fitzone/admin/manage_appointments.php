<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->bind_param("si", $status, $appointment_id);

    // Check if the update was successful
    if ($stmt->execute()) {
        $_SESSION['success'] = "Appointment status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating appointment status. Please try again.";
    }

    $stmt->close();
    header("Location: manage_appointments.php"); // Refresh the page to display the message
    exit();
}

// Fetch appointments with customer and trainer details
$query = "
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.status, 
           c.username AS customer_name, t.name AS trainer_name 
    FROM appointments a
    JOIN customers c ON a.customer_id = c.id
    JOIN trainers t ON a.trainer_id = t.id
    ORDER BY a.appointment_date, a.appointment_time
";
$appointments = $conn->query($query);
include 'assists/header_admin.php';
?>

<style>
    /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    color: #333333;
    margin: 0;
    padding: 0;
}

.manage-appointments {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.manage-appointments h1 {
    text-align: center;
    color: #333;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #333;
    color: #ffffff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}
.btn2 {
    background-color: #ff4c4c;
    color: #ffffff;
    margin-left: 10px;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.btn2:hover {
    background-color: #d93d3d;
}

/* Dropdown Styling */
select {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #ffffff;
    margin-left: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .manage-appointments {
        width: 95%;
        padding: 15px;
    }

    th, td {
        font-size: 14px;
    }
}
.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
}
.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<section class="manage-appointments">
    <h1>Manage Appointments</h1>
    <!-- Display Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success"><?= $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="message error"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <table border="1">
        <tr>
            <th>Customer</th>
            <th>Trainer</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $appointments->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['trainer_name']) ?></td>
            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
            <td><?= htmlspecialchars($row['appointment_time']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">
                    <select name="status">
                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Confirmed" <?= $row['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="Cancelled" <?= $row['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                    <input type="hidden" name="update_status" value="1">
                    <button class="btn2" type="submit">Update Status</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>
<?php include 'assists/footer_admin.php'; ?>
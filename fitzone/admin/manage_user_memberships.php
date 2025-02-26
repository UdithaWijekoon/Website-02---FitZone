<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'assists/header_admin.php'; 
include 'database_connection.php';

// Update Membership Status
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE user_memberships SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        $message = 'Membership status updated successfully!';
        $message_type = 'success';
    } else {
        $message = 'Error updating membership status.';
        $message_type = 'error';
    }
    $stmt->close();
}

// Fetch User Memberships
$sql = "SELECT um.id, um.user_id, um.plan_id, um.start_date, um.status, 
               u.username AS user_name, mp.plan_name 
        FROM user_memberships um
        JOIN customers u ON um.user_id = u.id
        JOIN membership_plans mp ON um.plan_id = mp.id
        ORDER BY um.start_date DESC";
$memberships = $conn->query($sql);
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

h1 {
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
    background-color: #333333;
    color: #ffffff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Form Styling within Table */
form {
    display: inline;
}

select {
    padding: 5px;
    margin-right: 5px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.btn2 {
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.btn2:hover {
    background-color: #d93d3d;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    th, td {
        padding: 10px;
    }

    button {
        padding: 4px 8px;
    }
}
/* Message Styling */
.message {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: opacity 0.3s ease-in-out;
        opacity: 1;
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
<h1>Manage User Memberships</h2>

<!-- Display the Message -->
<?php if (!empty($message)): ?>
    <div class="message <?php echo $message_type; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>User Name</th>
        <th>Membership Plan</th>
        <th>Start Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($membership = $memberships->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($membership['user_name']); ?></td>
            <td><?php echo htmlspecialchars($membership['plan_name']); ?></td>
            <td><?php echo htmlspecialchars($membership['start_date']); ?></td>
            <td><?php echo htmlspecialchars($membership['status']); ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $membership['id']; ?>">
                    <select name="status">
                        <option value="active" <?php if ($membership['status'] == 'active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if ($membership['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                        <option value="pending" <?php if ($membership['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                    </select>
                    <button class="btn2" type="submit" name="update_status">Update Status</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
$conn->close();
include 'assists/footer_admin.php';
?>

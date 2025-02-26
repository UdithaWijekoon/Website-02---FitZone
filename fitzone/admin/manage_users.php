<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';
include 'assists/header_admin.php'; 
// Fetch data for Admins, Staff, and Customers
$admins = mysqli_query($conn, "SELECT * FROM administration_accounts WHERE role = 'admin'");
$staff = mysqli_query($conn, "SELECT * FROM administration_accounts WHERE role = 'staff'");
$customers = mysqli_query($conn, "SELECT * FROM customers");

?>

<style>
    .container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background-color: #2c2c2c;
        color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    h2 {
        color: #fcfcfc;
        margin-bottom: 20px;
    }

    .table-container {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        background-color: #333;
        color: #fff;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #444;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #444;
    }

    .btn {
        padding: 5px 10px;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #ff4c4c;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .add-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #ff4c4c;
        text-decoration: none;
    }

    .add-link:hover {
        color: #ff6666;
        text-decoration: underline;
    }
    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1rem;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert button {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: 20px;
}

.alert button:hover {
    color: #000;
}

</style>

<!-- JavaScript for delete confirmation -->
<script>
function confirmDelete(form) {
    if (confirm("Are you sure you want to delete this user?")) {
        form.submit();
    }
}
</script>

<div class="container">
    <h2>Manage Users</h2>
<?php
if (isset($_SESSION['success'])) {
    echo "<p class='alert alert-success'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<p class='alert alert-danger'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>
    <a href="add_admin_staff.php" class="btn btn-outline add-link">+ Add New Admin/Staff</a>

    <!-- Admins Table -->
    <div class="table-container">
        <h3>Admins</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($admin = mysqli_fetch_assoc($admins)): ?>
                    <tr>
                        <td><?php echo $admin['id']; ?></td>
                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td>
                            <form action="delete_user.php" method="POST" style="display:inline;" onsubmit="event.preventDefault(); confirmDelete(this);">
                                <input type="hidden" name="user_id" value="<?php echo $admin['id']; ?>">
                                <input type="hidden" name="role" value="admin">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Staff Table -->
    <div class="table-container">
        <h3>Staff</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($staff_member = mysqli_fetch_assoc($staff)): ?>
                    <tr>
                        <td><?php echo $staff_member['id']; ?></td>
                        <td><?php echo htmlspecialchars($staff_member['username']); ?></td>
                        <td><?php echo htmlspecialchars($staff_member['email']); ?></td>
                        <td>
                            <form action="delete_user.php" method="POST" style="display:inline;" onsubmit="event.preventDefault(); confirmDelete(this);">
                                <input type="hidden" name="user_id" value="<?php echo $staff_member['id']; ?>">
                                <input type="hidden" name="role" value="staff">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Customers Table -->
    <div class="table-container">
        <h3>Customers</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($customer = mysqli_fetch_assoc($customers)): ?>
                    <tr>
                        <td><?php echo $customer['id']; ?></td>
                        <td><?php echo htmlspecialchars($customer['username']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td>
                            <form action="delete_user.php" method="POST" style="display:inline;" onsubmit="event.preventDefault(); confirmDelete(this);">
                                <input type="hidden" name="user_id" value="<?php echo $customer['id']; ?>">
                                <input type="hidden" name="role" value="customer">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'assists/footer_admin.php'; ?>
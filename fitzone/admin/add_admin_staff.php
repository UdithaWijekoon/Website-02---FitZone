<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include '../database_connection.php';
include 'assists/header_admin.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin/staff account into the database
    $query = "INSERT INTO administration_accounts (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $hashed_password, $role);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "New $role added successfully!";
    } else {
        $_SESSION['error'] = "Error adding $role. Please try again.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<style>
    /* Styling for Add New Admin/Staff Form */
    .add-account-container {
        max-width: 500px;
        margin: 20px auto;
        background-color: #2c2c2c;
        padding: 20px;
        border-radius: 8px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .add-account-container h2 {
        color: #ff4c4c;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        color: #ffffff;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #555;
        background-color: #333;
        color: #ffffff;
        border-radius: 5px;
    }

    .form-control:focus {
        border-color: #ff4c4c;
    }

    .btn-submit {
        background-color: #ff4c4c;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #ff3333;
    }

    .message {
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    .success {
        background-color: #28a745;
        color: #fff;
    }

    .error {
        background-color: #ff4c4c;
        color: #fff;
    }
    .back-button {
    display: inline-block;
    margin-bottom: 20px;
    margin-left: 20px;
    color: #ff4c4c;
    text-decoration: none;
    font-weight: bold;
    font-size: 1rem;
    padding: 8px 16px;
    border: 2px solid #ff4c4c;
    border-radius: 5px;
    transition: background 0.3s, color 0.3s;
    }

    .back-button:hover {
    background-color: #ff4c4c;
    color: white;
    }
</style>

<div class="add-account-container">
    <h2>Add New Admin/Staff</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="add_admin_staff.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="staff">Gym Management Staff</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Add Account</button>
        <a href="javascript:history.back()" class="back-button">← Back</a>
    </form>
</div>

<?php include 'assists/footer_admin.php'; ?>

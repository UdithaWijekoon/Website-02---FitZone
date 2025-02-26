<?php include 'assists/header.php'; ?>
<style>
    /* Login Container Styling */
    body {
        background-color: #1a1a1a;
    }
    .admin-login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        background-color: #1a1a1a;
    }

    .login-box {
        background-color: #2c2c2c;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .login-box h2 {
        color: #ff4c4c;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
        text-align: left;
    }

    .form-group label {
        color: #ffffff;
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border-radius: 5px;
        border: 1px solid #555;
        background-color: #333;
        color: #ffffff;
        outline: none;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #ff4c4c;
    }

    .btn-login {
        background-color: #ff4c4c;
        color: #ffffff;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        width: 100%;
        transition: transform 0.3s, background-color 0.3s;
    }

    .btn-login:hover {
        background-color: #ff3333;
        transform: scale(1.05);
        cursor: pointer;
    }

    .switch-login {
        color: #bbb;
        margin-top: 1rem;
    }

    .switch-login a {
        color: #ff4c4c;
        text-decoration: none;
        transition: color 0.3s;
    }

    .switch-login a:hover {
        color: #ff6666;
    }
    /* Centered Message Styling */
        .message {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px 20px;
        color: #000;
        font-weight: bold;
        border: 2px solid #000;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        opacity: 0;
        animation: fadeInOut 5s ease forwards;
    }

    .logout-message {
        background-color: #d4edda;
        color: #155724;
    }

    .error-message {
        background-color: #f8d7da; 
        color: #721c24; 
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-10px) translateX(-50%); }
        10%, 90% { opacity: 1; transform: translateY(0) translateX(-50%); }
        100% { opacity: 0; transform: translateY(-10px) translateX(-50%); }
    }
</style>

<div class="admin-login-container">
    <div class="login-box">
        <h2>Admin & Staff Login</h2>
        <form action="login/admin_staff_login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
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
            <button type="submit" class="btn-login">Login</button>
        </form>
        <p class="switch-login">Are you a customer? <a href="customer_login.php">Login here</a></p>
    </div>
</div>

<?php
// Display the logout message if it exists
if (isset($_SESSION['logout_message'])): ?>
    <div class="message logout-message">
        <?php 
        echo $_SESSION['logout_message']; 
        unset($_SESSION['logout_message']); // Clear the message after displaying it
        ?>
    </div>
<?php endif; ?>

<?php
// Display any error message if it exists
if (isset($_SESSION['error'])): ?>
    <div class="message error-message">
        <?php 
        echo $_SESSION['error']; 
        unset($_SESSION['error']); // Clear the message after displaying it
        ?>
    </div>
<?php endif; ?>

<?php include 'assists/footer.php'; ?>

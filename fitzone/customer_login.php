<?php include 'assists/header.php'; ?>

<style>
body {
    background-color: #1a1a1a;
}
/* Login Container Styling */
.login-container {
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

.signup-text {
    color: #bbb;
    margin-top: 1rem;
}

.signup-text a {
    color: #ff4c4c;
    text-decoration: none;
    transition: color 0.3s;
}

.signup-text a:hover {
    color: #ff6666;
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

/* Pop-up Message Styles */
.popup-message {
    position: fixed;
    top: 20%;
    left: 50%; 
    z-index: 1000;
    padding: 15px;
    border-radius: 5px;
    border: 2px solid #000;
    opacity: 0; 
    transition: opacity 0.5s ease-in-out, top 0.5s ease-in-out;
    width: 300px;
    transform: translate(-50%, -50%);
    text-align: center;
    font-weight: bold;
}

.popup-message.success {
    background-color: #d4edda;
    color: #155724;
}

.popup-message.error {
    background-color: #f8d7da; 
    color: #721c24; 
}

/* Animation for showing the pop-up */
.show {
    opacity: 1; 
    top: 25%; 
}
</style>

<div class="login-container">
    <div class="login-box">
        <h2>Customer Login</h2>

        <form action="login/customer_login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <p class="signup-text">Don't have an account? <a href="customer_register.php">Sign Up</a></p>
        <p class="switch-login">For Admin and Staff: <a href="admin_staff_login.php">Login here</a></p>
    </div>
</div>

<script>
// Function to show pop-up messages
function showPopup(message, type) {
    const popup = document.createElement('div');
    popup.className = `popup-message ${type}`;
    popup.textContent = message;

    document.body.appendChild(popup);
    
    // Trigger the show animation
    setTimeout(() => {
        popup.classList.add('show');
    }, 10);

    // Hide the pop-up after 3 seconds
    setTimeout(() => {
        popup.classList.remove('show');
        // Remove from DOM after fade out
        setTimeout(() => {
            popup.remove();
        }, 500); // Matches the CSS transition duration
    }, 3000);
}

// Display session messages if they exist
<?php if (isset($_SESSION['success'])): ?>
    showPopup("<?php echo $_SESSION['success']; ?>", "success");
    <?php unset($_SESSION['success']); // Clear message after displaying ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    showPopup("<?php echo $_SESSION['error']; ?>", "error");
    <?php unset($_SESSION['error']); // Clear message after displaying ?>
<?php endif; ?>
</script>

<?php include 'assists/footer.php'; ?>

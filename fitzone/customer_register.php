<?php include 'assists/header.php'; ?>
<style>
    /* Register Container Styling */
body {
    background-color: #1a1a1a;
}
.register-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    background-color: #1a1a1a;
}

.register-box {
    background-color: #2c2c2c;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 600px;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.register-box h2 {
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

.btn-register {
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

.btn-register:hover {
    background-color: #ff3333;
    transform: scale(1.05);
    cursor: pointer;
}

.login-text {
    color: #bbb;
    margin-top: 1rem;
}

.login-text a {
    color: #ff4c4c;
    text-decoration: none;
    transition: color 0.3s;
}

.login-text a:hover {
    color: #ff6666;
}
/* Pop-up Message Styles */
.popup-message {
        position: fixed;
        top: 20%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        z-index: 1000;
        padding: 15px;
        border-radius: 5px;
        border: 2px solid #000;
        opacity: 0; 
        transition: opacity 0.5s ease-in-out, top 0.5s ease-in-out;
        width: 400px; 
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
        top: 20%; 
    }
</style>
<div class="register-container">
    <div class="register-box">
        <h2>Customer Registration</h2>
        <form action="login/customer_register_process.php" method="POST">
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
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
        <p class="login-text">Already have an account? <a href="customer_login.php">Login here</a></p>
    </div>
</div>
<?php 
// Check for success or error messages in the session and display them
if (isset($_SESSION['register_success'])) {
    echo "<div class='popup-message success show'>" . $_SESSION['register_success'] . "</div>";
    unset($_SESSION['register_success']); // Clear the message after displaying it
}

if (isset($_SESSION['register_error'])) {
    echo "<div class='popup-message error show'>" . $_SESSION['register_error'] . "</div>";
    unset($_SESSION['register_error']); // Clear the message after displaying it
}
?>

<script>
    // Automatically hide the pop-up message after a few seconds
    setTimeout(function() {
        const messages = document.querySelectorAll('.popup-message');
        messages.forEach(message => {
            message.classList.remove('show');
        });
    }, 5000); // Change to 5000 for 5 seconds
</script>
<?php include 'assists/footer.php'; ?>

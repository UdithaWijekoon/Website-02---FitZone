<!-- contact.php -->
<?php include('assists/header.php'); ?>

<style>
    /* General Styles */
    body {
        background-color: #1a1a1a;
        color: white;
    }

    /* Header Section */
    .header-section {
        background: url('assists/contact/bg.jpg') center center no-repeat;
        background-size: cover;
        color: white;
        padding: 200px 0;
        text-align: center;
        position: relative;
        background-blend-mode: overlay;
        background-color: rgba(0, 0, 0, 0.7);
    }
    .header-section h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    /* Contact Section */
    .contact-section {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        padding: 40px 0;
        justify-content: center;
    }
    .contact-form-container {
        flex: 1;
        max-width: 600px; 
        background-color: #333;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
    }
    .contact-details-card {
        flex: 1;
        max-width: 400px;
        background-color: #333;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
    }
    .contact-form-container h2, .contact-details-card h2 {
        color: #ff4c4c;
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
    }

    /* Contact Form Styles */
    .contact-form .form-group {
        margin-bottom: 15px;
    }
    .contact-form input, .contact-form textarea {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        color: white;
        background-color: #444;
        border: 1px solid #666;
        border-radius: 5px;
    }
    .contact-form input::placeholder, .contact-form textarea::placeholder {
        color: #aaa;
    }
    .contact-form button {
        background-color: #ff4c4c;
        color: white;
        font-size: 1.1rem;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .contact-form button:hover {
        background-color: #e04343;
    }

    /* Contact Details Styles */
    .contact-details-card p {
        font-size: 1.1rem;
        color: #f1f1f1;
        margin: 10px 0;
    }
    .contact-details-card h3 {
        color: #ff4c4c;
        margin-bottom: 20px;
        text-align: center;
    }
    /* Image Styles */
    .contact-details-card img {
        max-width: 100%; 
        border-radius: 5px;
        margin-top: 20px; 
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .contact-section {
            flex-direction: column;
            align-items: center;
        }
        .contact-form-container, .contact-details-card {
            max-width: 90%;
        }
    }
    /* Additional styling for success and error messages */
    .success-message, .error-message {
        max-width: 600px;
        margin: 20px auto;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        font-size: 1.1rem;
    }
    .success-message {
        background-color: #4CAF50;
        color: white;
    }
    .error-message {
        background-color: #f44336;
        color: white;
    }
</style>

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We’re here to help you with any inquiries.</p>
    </div>
</section>
<!-- Display Success or Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message"><?php echo $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="error-message"><?php echo $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
<!-- Contact Form and Details Section -->
<section class="contact-section">
    <!-- Contact Form Container -->
    <div class="contact-form-container">
        <h2>Get in Touch</h2>
        <form action="contact_process.php" method="POST" class="contact-form">
            <div class="form-group">
                <input type="text" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <input type="text" name="subject" placeholder="Subject" required>
            </div>
            <div class="form-group">
                <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <div class="form-group text-center">
                <button type="submit">Send Message</button>
            </div>
        </form>
    </div>

    <!-- Contact Details Card -->
    <div class="contact-details-card">
        <h2>Contact Information</h2>
        <div class="contact-details">
            <p><strong>Address:</strong> 123 FitZone Road, Kurunegala, Sri Lanka</p>
            <p><strong>Phone:</strong> +94 123 456 789</p>
            <p><strong>Email:</strong> info@fitzone.com</p>
        </div>
        <img src="assists/contact/gym.jpg" alt="Contact Us" />
    </div>
</section>

<?php include('assists/footer.php'); ?>

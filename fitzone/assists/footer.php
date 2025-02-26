<div class="red-line"></div>
<!-- footer.php -->
<footer class="bg-dark text-white text-center py-3 ">

<style>
/* Footer */
footer {
    color: #fff;
    padding: 40px 0;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.footer-section {
    flex: 1 1 300px;
    margin: 20px;
}

.footer-section h3 {
    border-bottom: 2px solid #ff4c4c;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.footer-section p, .footer-section ul {
    margin: 0;
    padding: 0;
    list-style: none;
    line-height: 1.8;
}

.footer-section a {
    color: #fff;
    text-decoration: none;
}

.footer-section a:hover {
    color: #ff4c4c;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #444;
    margin-top: 20px;
    margin-bottom: -30px;
}
</style>
<footer class="bg-dark">
    <div class="footer-content">
        <div class="footer-section about">
            <h3>FitZone Fitness Center</h3>
            <p>At FitZone, we’re dedicated to providing a welcoming and inclusive space where everyone can reach their fitness goals. Our gym offers a wide range of facilities and services designed to cater to all fitness levels.</p>
        </div>
        <div class="footer-section links">
            <h3>Quick Links</h3>
            <ul>
              <li><a href="index.php">Home</a></li>
              <li><a href="about.php">About Us</a></li>
              <li><a href="classes.php">Classes</a></li>
              <li><a href="personal_training.php">Personal Training</a></li>
              <li><a href="membership.php">Membership</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li><a href="blog.php">Blog</a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p>Location: 12/24 D.S.Athugala Street, Kurunegala, Sri Lanka</p>
            <p>Phone: +94 37 2345678</p>
            <p>Email: info@fitzone.com</p>
        </div>
      </div>
    <div class="footer-bottom">
    <p>&copy; <?php echo date("Y"); ?> FitZone Fitness Center. All Rights Reserved.</p>
        <p>Follow us on:
            <a href="#" class="text-white me-2 social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-2 social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-2 social-icon"><i class="fab fa-instagram"></i></a>
        </p>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- index.php -->
<?php include 'assists/header.php'; ?>

    <style>
        /* Global Theme Colors */
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        a {
            color: #ff4c4c;
            text-decoration: none;
        }
        a:hover {
            color: #ff1a1a;
        }

        /* Banner Styles */
        .banner {
            background: url('assists/home/bg.jpg') center center no-repeat;
            background-size: cover;
            color: white;
            padding: 200px 0;
            text-align: center;
            position: relative;
            background-blend-mode: overlay;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .banner h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .cta-buttons .btn {
            margin: 10px;
            font-size: 1.2rem;
        }

        /* Quick Links Styles */
        .highlight-icon {
            font-size: 2.5rem;
            color: #ff4c4c;
            margin-bottom: 15px;
        }
        .service-box {
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.3s ease-in-out;
        }
        .service-box:hover {
            transform: scale(1.05);
            background-color: #ff4c4c;
            color: #1a1a1a;
        }

        .service-box:hover .highlight-icon {
            color: #1a1a1a; 
        }

        /* Testimonial Styles */
        .testimonial {
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 8px;
            color: #ffffff;
        }
        .testimonial img {
            border-radius: 50%;
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 2px solid #ff4c4c;
        }
        .testimonial h5 {
            color: #ff4c4c;
        }

        /* Section Styles */
        .section {
            padding: 60px 0;
        }
        .section img {
            width: 100%;
            border-radius: 8px;
        }
        .section .content {
            color: #ffffff;
            padding: 20px;
        }
        .section .btn {
            background-color: #ff4c4c;
            border: none;
            transition: background-color 0.3s;
        }
        .section .btn:hover {
            background-color: #ff1a1a;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .banner h1 {
                font-size: 2rem;
            }
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
</head>
<body>

    <!-- Banner Section -->
    <section class="banner text-center">
        <div class="container">
            <h1>Welcome to FitZone Fitness Center</h1>
            <p>Your journey to a healthier life starts here!</p>
            <div class="cta-buttons">
                <a href="membership.php" class="btn btn-danger btn-lg">Get Membership</a>
                <a href="contact.php" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section bg-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="assists/home/about.jpg" alt="About FitZone">
                </div>
                <div class="col-md-6 content">
                    <h3>About FitZone Fitness Center</h3>
                    <p>At FitZone, we’re dedicated to providing a welcoming and inclusive space where everyone can reach their fitness goals. Our gym offers a wide range of facilities and services designed to cater to all fitness levels.</p>
                    <a href="about.php" class="btn btn-danger mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="py-5 text-center">
        <div class="container">
            <h2 class="mb-4">Explore Our Services</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-box">
                        <i class="fas fa-dumbbell highlight-icon"></i>
                        <h5>Strength Training</h5>
                        <p>Build muscle and improve strength with our state-of-the-art equipment.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-box">
                        <i class="fas fa-heartbeat highlight-icon"></i>
                        <h5>Cardio</h5>
                        <p>Get your heart pumping with our range of cardio classes.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-box">
                        <i class="fas fa-spa highlight-icon"></i>
                        <h5>Yoga</h5>
                        <p>Relax and rejuvenate with our calming yoga sessions.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-box">
                        <i class="fas fa-user-friends highlight-icon"></i>
                        <h5>Personal Training</h5>
                        <p>Achieve your goals with one-on-one guidance from certified trainers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Personal Training Section -->
    <section class="section bg-secondary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-2">
                    <img src="assists/home/training.jpg" alt="Personal Training">
                </div>
                <div class="col-md-6 content">
                    <h3>Personal Training</h3>
                    <p>Our certified personal trainers are here to guide you through a customized fitness program tailored to your goals. Whether you’re looking to build muscle, lose weight, or increase endurance, we have you covered.</p>
                    <a href="personal_training.php" class="btn btn-danger mt-3">Discover More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-dark">
        <div class="container">
            <h2 class="text-center mb-4">What Our Members Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial text-center">
                        <img src="assists/home/member_1.jpg" alt="Member Photo">
                        <h5 class="mt-3">Kasun Lakshitha</h5>
                        <p>"FitZone transformed my fitness journey. The trainers are fantastic!"</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial text-center">
                        <img src="assists/home/member_2.jpg" alt="Member Photo">
                        <h5 class="mt-3">Yohani Fernando</h5>
                        <p>"I love the group classes here! Great variety and friendly community."</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial text-center">
                        <img src="assists/home/member_3.jpeg" alt="Member Photo">
                        <h5 class="mt-3">Shashitha Perera</h5>
                        <p>"Best decision I've made for my health. Highly recommend FitZone!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
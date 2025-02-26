<!-- about.php -->
<?php 
include('assists/header.php');
include 'database_connection.php';
?>
<style>
    body {
        background-color: #1a1a1a;
        color: white; 
    }
    .header-section {
        background: url('assists/about/bg.jpg') center center no-repeat;
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
    .section-container {
        background-color: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        margin: 20px 0;
        display: flex;
        align-items: center;
    }
    .section-image {
        flex: 1;
        margin-right: 20px;
        max-width: 300px;
        border-radius: 8px;
    }
    .section-content {
        flex: 2;
    }
    .section-title {
        color: #ff4c4c;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    .section-text, .section-list {
        color: #f1f1f1;
        font-size: 1.1rem;
    }
    .section-list {
        list-style: none;
        padding: 0;
    }
    .section-list li {
        margin: 8px 0;
    }
    .overview-section{
        background-color: transparent;
    }
    .overview-section .section-container {
        display: flex;
        align-items: center;
        background-color: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        margin: 20px 0;
    }
    .overview-section .section-image {
        flex: 2; 
        margin-right: 20px;
        max-width: 500px;
        border-radius: 8px;
    }
    .overview-section .section-content {
        flex: 1;
        font-size: 1.3rem; 
        line-height: 1.6;
    }
    .overview-section .section-title {
        color: #ff4c4c;
        font-size: 3rem;
        margin-bottom: 15px;
    }
    .overview-section p {
        font-size: 1.5rem;
    }
    .mission-vision {
        background: url('assists/about/bg2.jpg') ;
        background-size: cover;
        padding: 40px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .mission-vision .container-wrapper {
        display: flex;
        width: 100%;
        max-width: 1200px;
        margin-bottom: 20px;
    }
    .mission-vision .container-wrapper:nth-child(odd) {
        justify-content: flex-start;
    }
    .mission-vision .container-wrapper:nth-child(even) {
        justify-content: flex-end;
    }
    .mission-vision .section-container {
        width: 45%;
    }
    /* Team Section Styles */
    .team-section{
        padding: 20px 0;
    }
    .team-member {
        background-color: #333; 
        border-radius: 10px; 
        padding: 20px;
        text-align: center;
        margin: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .team-member:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.7);
    }
    .team-member img {
        border-radius: 50%; 
        width: 150px; 
        height: 150px; 
        margin-bottom: 15px; 
    }
    .team-member h4 {
        color: #ff4c4c;
        margin-top: 10px;
        font-size: 1.3rem;
    }
    .team-member p {
        color: #d0d0d0;
    }
    /* Responsive Styles */
    @media (max-width: 768px) {
        .header-section h1 {
            font-size: 2rem;
        }
        .mission-vision .section-content {
            font-size: 1.1rem; 
            line-height: 1.5;
        }
        .mission-vision .container-wrapper {
            flex-direction: column; 
            align-items: center; 
        }
        .mission-vision .section-container {
            width: 150%; 
        }
        .team-section .team-member img {
            width: 120px; 
            height: 120px;
        }
    }
    /* Mobile Responsiveness for Overview Section */
    @media (max-width: 768px) {
        .overview-section .section-container {
            flex-direction: column;
            text-align: center;
            padding: 15px;
        }
        .overview-section .section-image {
            margin: 0 0 20px 0;
            max-width: 100%;
        }
        .overview-section .section-title {
            font-size: 2.5rem;
        }
        .overview-section p {
            font-size: 1.2rem; 
            line-height: 1.4;
        }
    }

    /* Further adjustments for smaller screens */
    @media (max-width: 576px) {
        .overview-section .section-title {
            font-size: 2rem;
        }
        .overview-section p {
            font-size: 1rem; 
        }
    }

    /* General Improvements for Mobile Responsiveness */
    @media (max-width: 576px) {
        .section-title {
            font-size: 1.5rem; 
        }
        .section-text, .section-list li {
            font-size: 1rem;
        }
        .team-member h4 {
            font-size: 1.1rem;
        }
        .team-member img {
            width: 100px;
            height: 100px; 
        }
    }
    .btn:hover {
        background-color: #ff1a1a;
    }
</style>

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <h1>About FitZone Fitness Center</h1>
        <p>Your healthier lifestyle begins here!</p>
    </div>
</section>

<!-- Overview Section -->
<section class="overview-section">
    <div class="container">
        <div class="section-container bg-dark">
            <img src="assists/about/overview.jpg" alt="Overview Image" class="section-image">
            <div class="section-content">
                <h2 class="section-title">Overview</h2>
                <p>FitZone is dedicated to promoting a healthier lifestyle for all individuals. We provide modern facilities, top-notch trainers, and a variety of fitness programs to help you reach your goals, whatever they may be. Join us and be a part of our fitness community in Kurunegala.</p>
            </div>
        </div>

</section>

<!-- Mission and Vision Section -->
<section class="mission-vision">
    <div class="container">
        <!-- Mission -->
        <div class="container-wrapper">
            <div class="section-container">
                <img src="assists/about/1.jpeg" alt="Mission Image" class="section-image">
                <div class="section-content">
                    <h2 class="section-title">Our Mission</h2>
                    <p class="section-text">To provide a supportive and motivating environment for our members to achieve their fitness goals.</p>
                </div>
            </div>
        </div>
        <!-- Vision -->
        <div class="container-wrapper">
            <div class="section-container">
                <img src="assists/about/2.jpg" alt="Vision Image" class="section-image">
                <div class="section-content">
                    <h2 class="section-title">Our Vision</h2>
                    <p class="section-text">To be the leading fitness center in Kurunegala, fostering a community focused on health and wellness.</p>
                </div>
            </div>
        </div>
        <!-- Values -->
        <div class="container-wrapper">
            <div class="section-container">
                <img src="assists/about/3.jpg" alt="Values Image" class="section-image">
                <div class="section-content">
                    <h2 class="section-title">Our Values</h2>
                    <ul class="section-list">
                        <li>Community: We build lasting relationships with our members.</li>
                        <li>Excellence: We strive to exceed expectations in all that we do.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <h2 class="text-center section-title">Meet Our Trainers</h2>
        <div class="row">
            <?php
            // Fetch the first three trainers
            $query = "SELECT * FROM trainers LIMIT 3";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($trainer = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="team-member">';
                    echo '<img src="fitzone/' . $trainer['photo_path'] . '" alt="' . htmlspecialchars($trainer['name']) . '">';
                    echo '<h4>' . htmlspecialchars($trainer['name']) . '</h4>';
                    echo '<p>' . htmlspecialchars($trainer['expertise']) . '</p>';
                    echo '<p>Available: ' . htmlspecialchars($trainer['availability']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No trainers available at the moment.</p>';
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="personal_training.php" class="btn btn-danger">See More Trainers</a>
        </div>
    </div>
</section>

<?php include('assists/footer.php'); ?>

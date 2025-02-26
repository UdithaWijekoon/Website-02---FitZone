<?php
include 'assists/header.php';
include 'database_connection.php';

// SQL query to fetch trainer data
$sql = "SELECT * FROM trainers";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<style>
    /* General Styles */
    body {
        background-color: #1a1a1a;
        color: #333;
        font-family: Arial, sans-serif;
        color: #f1f1f1;
    }

    /* Header Section */
    .header-section {
        background: url('assists/personal_training/bg.jpg') center center no-repeat;
        background-size: cover;
        color: white;
        padding: 200px 0;
        text-align: center;
        background-blend-mode: overlay;
        background-color: rgba(0, 0, 0, 0.6);
    }
    .header-section h1 {
        font-size: 2.8rem;
        margin-bottom: 15px;
    }
    .header-section p {
        font-size: 1.2rem;
    }

    /* Overview Section */
    .overview-section {
        padding: 40px 20px;
        text-align: center;
    }

    /* Trainer Profiles */
    .trainers-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
        padding: 20px;
    }

    /* Trainer Card */
    .trainer-card {
        background-color: #333;
        color: #f1f1f1;
        border-radius: 10px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .trainer-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
        margin-bottom: 15px;
    }
    .trainer-card h2 {
        font-size: 1.6rem;
        color: #ff4c4c;
        margin-bottom: 10px;
    }
    .trainer-card p {
        font-size: 1rem;
        margin: 10px 0;
    }
    .trainer-card .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #ff4c4c;
        margin: 10px 0;
    }
    .trainer-card .appointment-btn {
        background-color: #ff4c4c;
        color: white;
        padding: 10px 20px;
        font-size: 1.1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s;
    }
    .trainer-card .appointment-btn:hover {
        background-color: #e04343;
    }

    /* Search and Filter */
    .search-filter-section {
        padding: 20px;
        text-align: center;
    }
    .search-filter-section input[type="text"], .search-filter-section select {
        padding: 10px;
        margin: 5px;
        width: 200px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .text-center {
        text-align: center;
        margin-bottom: 40px; 
    }
</style>

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <h1>Personal Training</h1>
        <p>Achieve your fitness goals with our dedicated personal training services.</p>
    </div>
</section>

<!-- Overview Section -->
<section class="overview-section">
    <h2>Overview of Personal Training Services</h2>
    <p>Our personal training programs are designed to meet your unique fitness needs. Get one-on-one guidance, customized workout plans, and motivation from our expert trainers.</p>
</section>

<div class="text-center">
        <a href="appointment_history.php" class="btn btn-danger">Your Appointment History</a>
</div>

<!-- Search and Filter Section -->
<section class="search-filter-section">
    <form method="GET" action="Personal_Training.php">
        <input type="text" name="search" placeholder="Search trainers...">
        <select name="expertise">
            <option value="">Filter by Expertise</option>
            <option value="Strength Training">Strength Training</option>
            <option value="Cardio">Cardio</option>
            <option value="Flexibility">Flexibility</option>
            <option value="Yoga">Yoga</option>
            <!-- Add other expertise options here as needed -->
        </select>
        <button class="btn btn-outline-light btn-lg" type="submit">Search</button>
    </form>
</section>

<!-- Trainers Section -->
<section class="trainers-container">

    <?php
    // Filter results based on search input and expertise filter
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $expertise = isset($_GET['expertise']) ? $_GET['expertise'] : '';

    $sql = "SELECT * FROM trainers WHERE name LIKE ? AND expertise LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%{$search}%";
    $expertiseTerm = $expertise ? "%{$expertise}%" : "%";
    $stmt->bind_param("ss", $searchTerm, $expertiseTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='trainer-card'>";
            echo "<img src='fitzone/" . htmlspecialchars($row['photo_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<p><strong>Expertise:</strong> " . htmlspecialchars($row['expertise']) . "</p>";
            echo "<p><strong>Availability:</strong> " . htmlspecialchars($row['availability']) . "</p>";
            echo "<p class='price'>Price: $" . htmlspecialchars($row['session_price']) . " per session</p>";
            echo "<a href='make_appointment.php?trainer_id=" . urlencode($row['id']) . "' class='appointment-btn'>Make an Appointment</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No trainers found based on your criteria.</p>";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
    ?>

</section>

<?php include('assists/footer.php'); ?>

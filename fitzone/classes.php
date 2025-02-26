<?php
include 'assists/header.php'; 
include 'database_connection.php'; 

// SQL query to fetch class data
$sql = "SELECT * FROM classes"; 
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<style>
    /* General Styles */
    body {
        background-color: #1a1a1a;
        color: white;
        font-family: Arial, sans-serif;
    }

    /* Header Section */
    .header-section {
        background: url('assists/classes/bg.jpg') center center no-repeat;
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
        margin-bottom: 10px;
    }
    .header-section p {
        font-size: 1.2rem;
    }

    /* Classes Section */
    .classes-section {
        padding: 40px 20px;
    }
    .classes-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }

    /* Class Card */
    .class-card {
        background-color: #333;
        color: #f1f1f1;
        border-radius: 10px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .class-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
        margin-bottom: 15px;
    }
    .class-card h2 {
        font-size: 1.8rem;
        color: #ff4c4c;
        margin-bottom: 15px;
    }
    .class-card p {
        font-size: 1rem;
        margin: 10px 0;
    }
    .class-card .trainer-info {
        font-style: italic;
        color: #aaa;
        margin-bottom: 15px;
    }
    .class-card .view-schedule-btn {
        background-color: #ff4c4c;
        color: white;
        padding: 10px 20px;
        font-size: 1.1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
    }
    .class-card .view-schedule-btn:hover {
        background-color: #e04343;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .class-card {
            width: 100%;
            max-width: 400px;
        }
    }
    .text-center {
        text-align: center;
        margin-bottom: 40px; 
    }

</style>

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <h1>Our Classes</h1>
        <p>Explore our wide range of fitness classes tailored for all levels.</p>
    </div>
</section>

<!-- Classes Section -->
<section class="classes-section">
    <div class="text-center">
        <a href="booking_history.php" class="btn btn-danger">Your Booking History</a>
    </div>
    <div class="classes-container">
        
        <?php
        if ($result->num_rows > 0) {
            // Output data for each class
            while ($row = $result->fetch_assoc()) {
                // Get data for each class
                $className = $row["name"];
                $classDescription = $row["description"];
                $classTrainer = $row["trainer"];
                $classSchedule = $row["schedule"];
                $classImage = $row["image_path"]; 

                // Output each class card
                echo "<div class='class-card'>";
                echo "<img src='fitzone/" . htmlspecialchars($classImage) . "' alt='" . htmlspecialchars($className) . " Class'>";
                echo "<h2>" . htmlspecialchars($className) . "</h2>";
                echo "<p>" . htmlspecialchars($classDescription) . "</p>";
                echo "<p class='trainer-info'>Trainers: " . htmlspecialchars($classTrainer) . "</p>";
                echo "<p>Schedule: " . htmlspecialchars($classSchedule) . "</p>";
                echo "<a href='schedule.php?class_id=" . urlencode($row["id"]) . "' class='view-schedule-btn'>View Schedule</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No classes available at the moment.</p>";
        }

        // Close connection
        $conn->close();
        ?>
        
    </div>
</section>

<?php include('assists/footer.php'); ?>


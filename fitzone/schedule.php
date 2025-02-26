<?php
include 'assists/header.php'; 
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to the login page if not logged in
    header("Location: customer_login.php");
    exit();
}

// Get the class ID from the URL
$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;

?>

<style>
    /* Schedule Section */
    .schedule-container {
        padding: 40px 20px;
    }
    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .schedule-item {
        background-color: #333;
        color: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
    }
    .buttons-container {
        margin: 20px 0;
    }
    .button {
        background-color: #ff4c4c;
        color: white;
        padding: 10px 20px;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s;
    }
    .button:hover {
        background-color: #e04343;
    }
</style>

<section class="schedule-container">
    <!-- Upcoming Class Schedule List -->
    <div class="schedule-list">
    <?php

if ($class_id > 0) {
    // Prepare the SQL query to get the schedule for the selected class
    $sql = "SELECT * FROM class_schedule WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any schedule records exist
    if ($result->num_rows > 0) {
        echo "<h1>Upcoming Class Schedule</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='schedule-item'>";
            echo "<p><strong>Trainer:</strong> " . htmlspecialchars($row['trainer']) . "</p>";
            echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
            echo "<p><strong>Time:</strong> " . htmlspecialchars($row['time']) . "</p>";
            echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . " minutes</p>";
            echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
            echo "<p><strong>Seats Available:</strong> " . htmlspecialchars($row['seats_available']) . "</p>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            
            echo "</div><hr>";
        }
    } else {
        echo "<p>No schedule available for this class.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid class ID.</p>";
}

// Close the database connection
$conn->close();
?>
<div class="buttons-container">
        <a href="booking.php?class_id=<?php echo urlencode($class_id); ?>" class="btn btn-danger">Make a Booking</a>
        <button class="btn btn-primary" onclick="window.history.back();">Back</button>
    </div>
    
    </div>
</section>

<?php include('assists/footer.php'); ?>


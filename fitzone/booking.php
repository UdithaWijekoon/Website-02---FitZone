<?php
include 'assists/header.php';
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page if not logged in
    header("Location: customer_login.php");
    exit();
}

// Get the class ID from the URL
$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$customer_id = $_SESSION['customer_id'];

// Check if a valid class ID is provided
if ($class_id <= 0) {
    echo "<p>Invalid class selection.</p>";
    exit();
}

// Fetch schedule options for the selected class
$sql = "SELECT * FROM class_schedule WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
$schedules = $result->fetch_all(MYSQLI_ASSOC);

// Process booking if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_id'])) {
    $schedule_id = (int)$_POST['schedule_id'];

    // Insert booking into database
    $booking_sql = "INSERT INTO bookings (customer_id, class_id, schedule_id, status) VALUES (?, ?, ?, 'pending')";
    $booking_stmt = $conn->prepare($booking_sql);
    $booking_stmt->bind_param("iii", $customer_id, $class_id, $schedule_id);
    
    if ($booking_stmt->execute()) {
        echo "<div class='alert alert-success'>
                Booking successful! Your booking is pending confirmation.
              </div>";
    } else {
        echo "<div class='alert alert-danger'>
                Booking failed: " . htmlspecialchars($conn->error) . "
              </div>";
    }
}

// Close connection
$stmt->close();
$conn->close();
?>

<style>
    .booking-container {
        padding: 40px 20px;
        color: white;
    }
    .schedule-option {
        background-color: #333;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
    }
    .schedule-option h2 {
        color: #ff4c4c;
    }
    .book-btn {
        background-color: #ff4c4c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s;
    }
    .book-btn:hover {
        background-color: #e04343;
    }
    .back-btn {
        color: #ff4c4c;
        text-decoration: none;
        font-size: 1rem;
        margin-top: 20px;
        display: inline-block;
    }
    .alert {
    padding: 15px;
    margin: 20px auto;
    max-width: 600px;
    border-radius: 5px;
    text-align: center;
}

.alert-success {
    background-color: #4caf50; /* Green background */
    color: white;
}

.alert-danger {
    background-color: #f44336; /* Red background */
    color: white;
}
</style>

<section class="booking-container">
    <h1>Book Your Class</h1>
    <?php if (count($schedules) > 0): ?>
        <form action="booking.php?class_id=<?php echo urlencode($class_id); ?>" method="post">
            <?php foreach ($schedules as $schedule): ?>
                <div class="schedule-option">
                    <h2><?php echo htmlspecialchars($schedule['trainer']); ?></h2>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($schedule['date']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($schedule['time']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($schedule['location']); ?></p>
                    <p><strong>Seats Available:</strong> <?php echo htmlspecialchars($schedule['seats_available']); ?></p>
                    <button type="submit" name="schedule_id" value="<?php echo $schedule['id']; ?>" class="book-btn">Book Now</button>
                </div>
            <?php endforeach; ?>
        </form>
    <?php else: ?>
        <p>No schedule available for this class.</p>
    <?php endif; ?>

    <!-- Back button to return to the previous page -->
    <a href="schedule.php?class_id=<?php echo urlencode($class_id); ?>" class="btn btn-primary">Back to Schedule</a>
</section>

<?php include('assists/footer.php'); ?>

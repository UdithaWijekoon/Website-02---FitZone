<?php
include 'assists/header.php';
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

// Get the trainer ID from the URL
$trainer_id = isset($_GET['trainer_id']) ? intval($_GET['trainer_id']) : 0;

// Fetch trainer details
$sql = "SELECT * FROM trainers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$trainer_result = $stmt->get_result();

if ($trainer_result->num_rows === 0) {
    die("Trainer not found.");
}

$trainer = $trainer_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION['customer_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    // Insert appointment into the database
    $insert_sql = "INSERT INTO appointments (customer_id, trainer_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iiss", $customer_id, $trainer_id, $appointment_date, $appointment_time);

    if ($insert_stmt->execute()) {
        echo "<div class='alert alert-success'>Appointment booked successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }

    $insert_stmt->close();
}

$conn->close();
?>

<style>
    body {
        background-color: #1a1a1a;
        color: #333;
        font-family: Arial, sans-serif;
        color: #f1f1f1;
    }
    h1{
        text-align: center;
        margin-bottom: 20px;
        color: #f1f1f1;
    }
    .appointment-container {
        padding: 40px 20px;
    }
    .appointment-form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #333;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9);
        color: white;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #222;
        color: white;
    }
    .btn-submit {
        background-color: #ff4c4c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-submit:hover {
        background-color: #e04343;
    }
    .btn{
        color: #f1f1f1;
    }
    .btn:hover {
        text-decoration: underline;
    }
    .alert {
    padding: 15px;
    margin: 20px auto;
    width: 100%;
    max-width: 600px;
    border-radius: 5px;
    text-align: center;
}

.alert-success {
    background-color: #4caf50; /* Green background */
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.alert-danger {
    background-color: #f44336; /* Red background */
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

</style>

<section class="appointment-container">
    <h1>Make an Appointment with <?php echo htmlspecialchars($trainer['name']); ?></h1>
    <div class="appointment-form">
        <form method="POST">
            <div class="form-group">
                <label for="selected_trainer">Selected Trainer:</label>
                <input type="text" id="selected_trainer" name="selected_trainer" value="<?php echo htmlspecialchars($trainer['name'] . ' - ' . $trainer['expertise']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" required>
            </div>
            <div class="form-group">
                <label for="appointment_time">Appointment Time:</label>
                <input type="time" id="appointment_time" name="appointment_time" required>
            </div>
            <button type="submit" class="btn-submit">Make an Appointment</button>
            <a href="personal_training.php" class="btn">&larr; Back</a>
        </form>
    </div>
</section>

<?php include 'assists/footer.php'; ?>

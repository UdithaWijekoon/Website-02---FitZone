<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';
include 'assists/header_admin.php';

// Fetch all classes for the dropdown
$classes = $conn->query("SELECT id, name FROM classes");

// Handle adding a new schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
    $class_id = $_POST['class_id'];
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $duration = $_POST['duration'];
    $location = $_POST['location'];
    $seats_available = $_POST['seats_available'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO class_schedule (class_id, trainer, date, time, duration, location, seats_available, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisis", $class_id, $trainer, $date, $time, $duration, $location, $seats_available, $description);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Schedule added successfully!";
    } else {
        $_SESSION['error'] = "Error adding schedule.";
    }
    $stmt->close();
}

// Handle editing an existing schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $duration = $_POST['duration'];
    $location = $_POST['location'];
    $seats_available = $_POST['seats_available'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE class_schedule SET trainer = ?, date = ?, time = ?, duration = ?, location = ?, seats_available = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssisisi", $trainer, $date, $time, $duration, $location, $seats_available, $description, $schedule_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Schedule updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating schedule.";
    }
    $stmt->close();
}

// Handle deleting a schedule
if (isset($_GET['delete_schedule'])) {
    $schedule_id = $_GET['delete_schedule'];

    $stmt = $conn->prepare("DELETE FROM class_schedule WHERE id = ?");
    $stmt->bind_param("i", $schedule_id);

    try {
        if ($stmt->execute()) {
            $_SESSION['message'] = "Schedule deleted successfully!";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is a foreign key constraint violation
        if ($e->getCode() == 1451) { 
            $_SESSION['error'] = "Cannot delete schedule: There are existing bookings associated with this schedule.";
        } else {
            $_SESSION['error'] = "Error deleting schedule.";
        }
    }
    $stmt->close();
}

// Fetch all schedules to display
$schedules = $conn->query("SELECT cs.*, c.name AS class_name FROM class_schedule cs JOIN classes c ON cs.class_id = c.id");
?>
<style>
    /* General page styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #1c1c1c;
    margin: 0;
    padding: 0;
}

.manage-class-schedule {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    color: #f4f4f9;
}

.manage-class-schedule h1{
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

.ht2 {
    color: #ff4c4c;
    text-align: center;
    margin-bottom: 20px;
}
.ht{
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    margin-top: 40px;
}
/* Form styling */
.form2 {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
    padding: 15px;
    background-color: #333;
    border-radius: 8px;
}

form label {
    font-weight: bold;
    color: #f4f4f9;
}

form input[type="text"], form input[type="date"], form input[type="time"], form input[type="number"], form select, form textarea {
    padding: 8px;
    border: 1px solid #555;
    border-radius: 5px;
    background-color: #222;
    color: #f4f4f9;
}

.btn2[type="submit"] {
    padding: 10px;
    background-color: #ff4c4c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.btn2[type="submit"]:hover {
    background-color: #d14040;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #2a2a2a;
    color: #f4f4f9;
}

table, th, td {
    border: 1px solid #444;
}

th {
    padding: 10px;
    background-color: #ff4c4c;
    color: #fff;
    text-align: center;
}

td {
    padding: 10px;
    background-color: #333;
    text-align: center;
}

/* Edit and Delete actions */
.actions form,
.link {
    display: inline-block;
    margin: 5px;
}

.actions button {
    padding: 5px;
    background-color: #ff4c4c;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
}

.actions button:hover {
    background-color: #d14040;
}

.link {
    color: #ff4c4c;
    font-weight: bold;
    text-decoration: none;
}

.link:hover {
    color: #e04343;
}

/* Responsive design */
@media (max-width: 768px) {
    .manage-class-schedule {
        padding: 10px;
    }
    table, form {
        width: 100%;
    }
}
    .message {
        padding: 10px;
        margin: 20px auto;
        text-align: center;
        border-radius: 5px;
        max-width: 500px;
    }
    .success {
        background-color: #4caf50;
        color: white;
    }
    .error {
        background-color: #f44336;
        color: white;
    }
</style>
<section class="manage-class-schedule">
    <h1>Manage Class Schedule</h1>
    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Add New Schedule Form -->

    <form method="post" class="form2">
    <h2 class="ht2">Add New Schedule</h2>
        <label for="class_id">Class</label>
        <select name="class_id" required>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="trainer" placeholder="Trainer" required>
        <input type="date" name="date" required>
        <input type="time" name="time" required>
        <input type="number" name="duration" placeholder="Duration (minutes)" required>
        <input type="text" name="location" placeholder="Location" required>
        <input type="number" name="seats_available" placeholder="Seats Available" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="hidden" name="add_schedule" value="1">
        <button type="submit" class="btn2">Add Schedule</button>
    </form>

    <!-- Schedules Table -->
    <h2 class="ht">Existing Schedules</h2>
    <table border="1">
        <tr>
            <th>Class</th>
            <th>Trainer</th>
            <th>Date</th>
            <th>Time</th>
            <th>Duration</th>
            <th>Location</th>
            <th>Seats Available</th>
            <th>Actions</th>
        </tr>
        <?php while ($schedule = $schedules->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($schedule['class_name']) ?></td>
                <td><?= htmlspecialchars($schedule['trainer']) ?></td>
                <td><?= htmlspecialchars($schedule['date']) ?></td>
                <td><?= htmlspecialchars($schedule['time']) ?></td>
                <td><?= htmlspecialchars($schedule['duration']) ?> mins</td>
                <td><?= htmlspecialchars($schedule['location']) ?></td>
                <td><?= htmlspecialchars($schedule['seats_available']) ?></td>
                <td>
                    <!-- Edit Schedule Form -->
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="schedule_id" value="<?= $schedule['id'] ?>">
                        <input type="text" name="trainer" value="<?= htmlspecialchars($schedule['trainer']) ?>" required>
                        <input type="date" name="date" value="<?= htmlspecialchars($schedule['date']) ?>" required>
                        <input type="time" name="time" value="<?= htmlspecialchars($schedule['time']) ?>" required>
                        <input type="number" name="duration" value="<?= htmlspecialchars($schedule['duration']) ?>" required>
                        <input type="text" name="location" value="<?= htmlspecialchars($schedule['location']) ?>" required>
                        <input type="number" name="seats_available" value="<?= htmlspecialchars($schedule['seats_available']) ?>" required>
                        <textarea name="description"><?= htmlspecialchars($schedule['description']) ?></textarea>
                        <input type="hidden" name="edit_schedule" value="1">
                        <br>
                        <button type="submit" class="btn2">Save</button>
                    </form>

                    <!-- Delete Schedule Link -->
                    <a class="link" href="manage_class_schedule.php?delete_schedule=<?= $schedule['id'] ?>" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>

<?php include 'assists/footer_admin.php'; ?>
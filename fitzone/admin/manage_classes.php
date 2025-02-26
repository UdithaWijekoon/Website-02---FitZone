<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';


// Directory to store uploaded images
$imageDir = '../images/';

// Handle adding a new class with an uploaded image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trainer = $_POST['trainer'];
    $schedule = $_POST['schedule'];
    
    // Handle the image upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $imageDir . uniqid() . '_' . $imageName;

        // Check and move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        }
    }

    // Insert the new class into the database
    $stmt = $conn->prepare("INSERT INTO classes (name, description, trainer, schedule, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $description, $trainer, $schedule, $imagePath);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Class added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add class. Please try again.";
    }
    $stmt->close();
    header("Location: manage_classes.php");
    exit();
}

// Handle updating a class (trainer and schedule only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
    $class_id = $_POST['class_id'];
    $trainer = $_POST['trainer'];
    $schedule = $_POST['schedule'];

    $stmt = $conn->prepare("UPDATE classes SET trainer = ?, schedule = ? WHERE id = ?");
    $stmt->bind_param("ssi", $trainer, $schedule, $class_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Class updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update class. Please try again.";
    }
    $stmt->close();
    header("Location: manage_classes.php");
    exit();
}

// Handle deleting a class
if (isset($_GET['delete_class'])) {
    $class_id = $_GET['delete_class'];

    // Check if there are related bookings for this class
    $stmt = $conn->prepare("SELECT COUNT(*) AS booking_count FROM bookings WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['booking_count'] > 0) {
        // If there are bookings, set an error message and redirect
        $_SESSION['error'] = "Cannot delete this class as it is associated with existing bookings.";
    } else {
        // Proceed with deletion if there are no bookings
        $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
        $stmt->bind_param("i", $class_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Class deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete class. Please try again.";
        }
        $stmt->close();
    }
    header("Location: manage_classes.php");
    exit();
}

// Fetch all classes
$classes = $conn->query("SELECT * FROM classes");
include 'assists/header_admin.php'; 
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

.manage-classes {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    color: #f4f4f9;
}

h1{
    color: #333;
    text-align: center;
}

h2 {
    color: #ff4c4c;
    text-align: center;
}
/* Add Class Form styling */
.form2 {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
    padding: 15px;
    background-color: #333;
    border-radius: 8px;
}

input[type="text"], textarea, input[type="file"] {
    padding: 8px;
    border: 1px solid #555;
    border-radius: 5px;
    background-color: #222;
    color: #f4f4f9;
}

.btn2 {
    padding: 10px;
    background-color: #ff4c4c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn2 {
    background-color: #d14040;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #2a2a2a;
}

th, td {
    padding: 10px;
    border: 1px solid #444;
    text-align: center;
    color: #f4f4f9;
}

th {
    background-color: #ff4c4c;
    color: #fff;
}

td {
    background-color: #333;
}

img {
    border-radius: 5px;
    width: 200px;
    height: auto;
}

/* Edit and Delete buttons */
.link {
    color: #ff4c4c;
    text-decoration: none;
}

.link:hover {
    color: #e04343;
}

input[type="text"][name="trainer"],
input[type="text"][name="schedule"] {
    width: 100px;
    margin: 0 5px;
    background-color: #222;
    color: #f4f4f9;
}

form[style*="display:inline-block;"] button {
    margin-top: 5px;
    padding: 5px;
    font-size: 0.9rem;
    width: auto;
    background-color: #ff4c4c;
}

@media (max-width: 768px) {
    .manage-classes {
        padding: 10px;
    }
    table, form {
        width: 100%;
    }
}
.ht{
    color: #333;
    text-align: center;
    margin-top: 50px;
}
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1rem;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert button {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: 20px;
}

.alert button:hover {
    color: #000;
}

</style>
<section class="manage-classes">
    <h1>Manage Classes</h1>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<p class='alert alert-success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='alert alert-danger'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>


    <!-- Add Class Form -->
    
    <form method="post" class="form2" enctype="multipart/form-data">
    <h2>Add New Class</h2>
    <!-- Display success or error messages -->
        <input type="text" name="name" placeholder="Class Name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="text" name="trainer" placeholder="Trainers" required>
        <input type="text" name="schedule" placeholder="Schedule" required>
        <input type="file" name="image" accept="image/*" required>
        <input type="hidden" name="add_class" value="1">
        <button type="submit" class="btn2">Add Class</button>
    </form>

    <!-- Classes Table -->
    <h2 class="ht">Existing Classes</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Trainers</th>
            <th>Schedule</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $classes->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['trainer']) ?></td>
                <td><?= htmlspecialchars($row['schedule']) ?></td>
                <td>
                    <?php if ($row['image_path']): ?>
                        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="50">
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Edit Trainer & Schedule Form -->
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="class_id" value="<?= $row['id'] ?>">
                        <input type="text" name="trainer" value="<?= htmlspecialchars($row['trainer']) ?>" required>
                        <input type="text" name="schedule" value="<?= htmlspecialchars($row['schedule']) ?>" required>
                        <input type="hidden" name="edit_class" value="1">
                        <button type="submit" class="btn2">Save</button>
                    </form>

                    <!-- Delete Class Link -->
                    <a class="link" href="manage_classes.php?delete_class=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>

<?php include 'assists/footer_admin.php'; ?>
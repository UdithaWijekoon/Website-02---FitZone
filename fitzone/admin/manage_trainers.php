<?php
include 'database_connection.php';
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}

// Handle form submissions for add, edit, and delete trainers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Add Trainer
    if (isset($_POST['add_trainer'])) {
        $name = $_POST['name'];
        $expertise = $_POST['expertise'];
        $bio = $_POST['bio'];
        $availability = $_POST['availability'];
        $session_price = $_POST['session_price'];
        
        // Handle photo upload
        $photo_path = null;
        if (!empty($_FILES['photo']['name'])) {
            $photo_name = $_FILES['photo']['name'];
            $target_directory = "../images/trainers/";
            $target_file = $target_directory . basename($photo_name);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                $photo_path = $target_file;
            } else {
                $_SESSION['error'] = "Failed to upload photo.";
            }
        }
        
        // Insert trainer data
        if (empty($_SESSION['error'])) {
            $stmt = $conn->prepare("INSERT INTO trainers (name, expertise, bio, availability, photo_path, session_price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", $name, $expertise, $bio, $availability, $photo_path, $session_price);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Trainer added successfully.";
            } else {
                $_SESSION['error'] = "Failed to add trainer.";
            }
            $stmt->close();
        }
    }

    // Handle Delete Trainer
    if (isset($_POST['delete_trainer'])) {
        $trainer_id = $_POST['trainer_id'];
        $stmt = $conn->prepare("DELETE FROM trainers WHERE id = ?");
        $stmt->bind_param("i", $trainer_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Trainer deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete trainer.";
        }
        $stmt->close();
    }

    // Redirect to prevent resubmission
    header("Location: manage_trainers.php");
    exit;
}

// Fetch trainers
$trainers = $conn->query("SELECT * FROM trainers");
include 'assists/header_admin.php'; 
?>

<style>
/* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    color: #333333;
    margin: 0;
    padding: 0;
}

.manage-trainers {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.manage-trainers h1 {
    text-align: center;
    color: #333;
}

.manage-trainers button {
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    margin-bottom: 15px;
}

.manage-trainers button:hover {
    background-color: #d14040;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #f9f9f9;
}

table, th, td {
    border: 1px solid #ddd;
}

th {
    padding: 12px;
    background-color: #333;
    color: #ffffff;
    text-align: center;
}

td {
    padding: 10px;
    text-align: center;
}

.a {
    color: #ff4c4c;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    color: #d14040;
}

/* Add Trainer Modal Styling */
#addTrainerModal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    width: 80%;
    max-width: 500px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

#addTrainerModal h2 {
    color: #ff4c4c;
}

#addTrainerModal label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

#addTrainerModal input[type="text"],
#addTrainerModal input[type="number"],
#addTrainerModal input[type="file"],
#addTrainerModal textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

#addTrainerModal button[type="submit"],
#addTrainerModal button[type="button"] {
    padding: 10px 15px;
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

#addTrainerModal button[type="button"] {
    background-color: #555555;
    margin-left: 10px;
}

#addTrainerModal button[type="submit"]:hover {
    background-color: #d14040;
}

#addTrainerModal button[type="button"]:hover {
    background-color: #333333;
}

/* Responsive Design */
@media (max-width: 768px) {
    .manage-trainers, #addTrainerModal {
        width: 95%;
        padding: 15px;
    }

    table, th, td {
        font-size: 14px;
    }
}
.message {
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}
.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<section class="manage-trainers">
    <h1>Manage Trainers</h1>

    <!-- Display Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success"><?= $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="message error"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <button onclick="document.getElementById('addTrainerModal').style.display='block'">Add Trainer</button>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Expertise</th>
            <th>Availability</th>
            <th>Session Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $trainers->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['expertise']) ?></td>
                <td><?= htmlspecialchars($row['availability']) ?></td>
                <td>$<?= htmlspecialchars($row['session_price']) ?></td>
                <td>
                    <a class="a" href="edit_trainer.php?id=<?= $row['id'] ?>">Edit</a>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="trainer_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete_trainer" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>

<!-- Add Trainer Modal -->
<div id="addTrainerModal" style="display:none;">
    <form method="post" enctype="multipart/form-data">
        <h2>Add Trainer</h2>
        <label>Name:</label><input type="text" name="name" required><br>
        <label>Expertise:</label><textarea name="expertise" required></textarea><br>
        <label>Bio:</label><textarea name="bio"></textarea><br>
        <label>Availability:</label><input type="text" name="availability" required><br>
        <label>Session Price:</label><input type="number" name="session_price" step="0.01" required><br>
        <label>Photo:</label><input type="file" name="photo"><br>
        <button type="submit" name="add_trainer">Add Trainer</button>
        <button type="button" onclick="document.getElementById('addTrainerModal').style.display='none'">Cancel</button>
    </form>
</div>

<?php include 'assists/footer_admin.php'; ?>
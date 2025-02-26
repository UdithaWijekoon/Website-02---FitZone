<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';

$trainer_id = $_GET['id'];
$trainer = $conn->query("SELECT * FROM trainers WHERE id = $trainer_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $expertise = $_POST['expertise'];
    $bio = $_POST['bio'];
    $availability = $_POST['availability'];
    $session_price = $_POST['session_price'];

    // Update query
    $stmt = $conn->prepare("UPDATE trainers SET name = ?, expertise = ?, bio = ?, availability = ?, session_price = ? WHERE id = ?");
    $stmt->bind_param("ssssdi", $name, $expertise, $bio, $availability, $session_price, $trainer_id);
    
    // Execute and set session message
    if ($stmt->execute()) {
        $_SESSION['success'] = "Trainer updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating trainer. Please try again.";
    }

    $stmt->close();
    header("Location: manage_trainers.php");
    exit();
}

include 'assists/header_staff.php';
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

.edit-trainer {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #333;
    color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.edit-trainer h1 {
    text-align: center;
    color: #ff4c4c;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-top: 15px;
    font-weight: bold;
}

form input[type="text"],
form input[type="number"],
form textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    background-color: #2c2c2c;
    color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

form textarea {
    resize: vertical; 
}

/* Button Styling */
.btn2 {
    margin-top: 20px;
    padding: 10px;
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.btn2:hover {
    background-color: #d14040;
}

/* Responsive Design */
@media (max-width: 768px) {
    .edit-trainer {
        width: 95%;
        padding: 15px;
    }

    form input[type="text"],
    form input[type="number"],
    form textarea {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}
.back-button {
    display: inline-block;
    margin-bottom: 20px;
    margin-top: 20px;
    color: #ff4c4c;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
    font-size: 1rem;
    padding: 8px 16px;
    border: 2px solid #ff4c4c;
    border-radius: 5px;
    transition: background 0.3s, color 0.3s;
    }

    .back-button:hover {
    background-color: #ff4c4c;
    color: white;
    }
</style>
<section class="edit-trainer">
    <h1>Edit Trainer</h1>
    <form method="post">
        <label>Name:</label><input type="text" name="name" value="<?= htmlspecialchars($trainer['name']) ?>" required><br>
        <label>Expertise:</label><textarea name="expertise" required><?= htmlspecialchars($trainer['expertise']) ?></textarea><br>
        <label>Bio:</label><textarea name="bio"><?= htmlspecialchars($trainer['bio']) ?></textarea><br>
        <label>Availability:</label><input type="text" name="availability" value="<?= htmlspecialchars($trainer['availability']) ?>" required><br>
        <label>Session Price:</label><input type="number" name="session_price" step="0.01" value="<?= htmlspecialchars($trainer['session_price']) ?>" required><br>
        <button type="submit" class="btn2">Update Trainer</button>
        <a href="javascript:history.back()" class="back-button">← Back</a>
    </form>
</section>
<?php include 'assists/footer_staff.php'; ?>
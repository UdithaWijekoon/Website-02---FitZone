<?php
session_start();

// Check if the user is logged in and if they have the 'staff' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'assists/header_staff.php'; 
include 'database_connection.php';

$message = ""; // Initialize message variable

// Add Membership Plan
if (isset($_POST['add_plan'])) {
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $guest_passes = $_POST['guest_passes'];
    $class_access = $_POST['class_access'];
    $health_assessment = isset($_POST['health_assessment']) ? 1 : 0;
    $personal_training_sessions = $_POST['personal_training_sessions'];
    $nutrition_counseling = isset($_POST['nutrition_counseling']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "INSERT INTO membership_plans (plan_name, description, price, guest_passes, class_access, health_assessment, personal_training_sessions, nutrition_counseling, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssdisiiii", $plan_name, $description, $price, $guest_passes, $class_access, $health_assessment, $personal_training_sessions, $nutrition_counseling, $is_active);
        if ($stmt->execute()) {
            $message = 'Membership plan added successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error adding membership plan.';
            $message_type = 'error';
        }
        $stmt->close();
    } else {
        $message = 'Error Preparing the Statement.';
        $message_type = 'error';
    }
}

// Delete Membership Plan
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM membership_plans WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = 'Membership plan deleted successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error deleting membership plan.';
            $message_type = 'error';
        }
        $stmt->close();
    } else {
        $message = 'Error preparing the statement.';
        $message_type = 'error';
    }
}

// Fetch Membership Plans
$plans = $conn->query("SELECT * FROM membership_plans ORDER BY created_at DESC");
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

h1, h2 {
    text-align: center;
    color: #333;
}

.pink{
    color: #ff4c4c;
}

/* Form Styling */
.form2 {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #333;
    border: 1px solid #ddd;
    border-radius: 8px;
}

label {
    display: block;
    margin: 10px 0 5px;
    color: #fff;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #2c2c2c;
    color: #fff;
}

input[type="checkbox"] {
    margin-right: 10px;
}

/* Button Styling */
.btn2 {
    background-color: #ff4c4c;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    width: 100%;
}

.btn2:hover {
    background-color: #d93d3d;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #333333;
    color: #ffffff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        width: 95%;
        padding: 15px;
    }

    th, td {
        font-size: 14px;
    }
}
/* Message Styling */
.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: opacity 0.3s ease-in-out;
    opacity: 1;
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
<h1>Manage Membership Plans</h1>

<!-- Display the Message -->
<?php if (!empty($message)): ?>
    <div class="message <?php echo $message_type; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form method="post" class="form2">
    <h2 class="pink">Add New Plan</h2>
    <label>Plan Name: <input type="text" name="plan_name" required></label><br>
    <label>Description: <textarea name="description" required></textarea></label><br>
    <label>Price: <input type="number" step="0.01" name="price" required></label><br>
    <label>Guest Passes: <input type="number" name="guest_passes"></label><br>
    <label>Class Access: <input type="text" name="class_access"></label><br>
    <label>Health Assessment: <input type="checkbox" name="health_assessment"></label><br>
    <label>Personal Training Sessions: <input type="number" name="personal_training_sessions"></label><br>
    <label>Nutrition Counseling: <input type="checkbox" name="nutrition_counseling"></label><br>
    <label>Active: <input type="checkbox" name="is_active" checked></label><br>
    <button class="btn2" type="submit" name="add_plan">Add Plan</button>
</form>

<hr>

<!-- Display Membership Plans -->
<h2>Existing Membership Plans</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Plan Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Guest Passes</th>
        <th>Class Access</th>
        <th>Health Assessment</th>
        <th>Personal Training Sessions</th>
        <th>Nutrition Counseling</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>
    <?php while ($plan = $plans->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($plan['plan_name']); ?></td>
            <td><?php echo htmlspecialchars($plan['description']); ?></td>
            <td><?php echo htmlspecialchars($plan['price']); ?></td>
            <td><?php echo htmlspecialchars($plan['guest_passes']); ?></td>
            <td><?php echo htmlspecialchars($plan['class_access']); ?></td>
            <td><?php echo $plan['health_assessment'] ? 'Yes' : 'No'; ?></td>
            <td><?php echo htmlspecialchars($plan['personal_training_sessions']); ?></td>
            <td><?php echo $plan['nutrition_counseling'] ? 'Yes' : 'No'; ?></td>
            <td><?php echo $plan['is_active'] ? 'Yes' : 'No'; ?></td>
            <td>

                <!-- Delete Button -->
                <a class="btn btn-danger" href="manage_membership_plans.php?delete_id=<?php echo $plan['id']; ?>" onclick="return confirm('Are you sure you want to delete this plan?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
$conn->close();
include 'assists/footer_staff.php';
?>

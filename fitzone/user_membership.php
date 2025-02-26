<?php 
include 'assists/header.php'; 
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to the login page if not logged in
    header("Location: customer_login.php");
    exit();
}

// Get the plan ID from the URL parameter
$plan_id = isset($_GET['plan_id']) ? (int)$_GET['plan_id'] : 0;
$user_id = $_SESSION['customer_id'];

if ($plan_id > 0) {
    // Fetch the membership plan details from the database
    $query = "SELECT * FROM membership_plans WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $plan_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $plan = mysqli_fetch_assoc($result);

    if ($plan) {
        // Plan found, display its details
?>

<style>
body {
    background-color: #1a1a1a;
}

/* Container styling */
.container2 {
    max-width: 700px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 2px solid #ff4d4d;
}

.membership-details h2 {
    color: #333;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.membership-details p {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
}

.plan-price {
    font-size: 1.5rem;
    font-weight: 600;
    color: #28a745;
    margin: 10px 0;
}

.membership-details h5 {
    font-size: 1.3rem;
    color: #333;
    margin-top: 20px;
    margin-bottom: 10px;
}

.membership-details ul {
    padding-left: 0;
    list-style-type: none;
    color: #666;
}

.membership-details ul li {
    font-size: 1rem;
    padding: 8px 0;
    border-bottom: 1px solid #ddd;
}

.membership-details ul li:last-child {
    border-bottom: none;
}

/* Responsive styling */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .membership-details h2 {
        font-size: 1.75rem;
    }

    .plan-price {
        font-size: 1.25rem;
    }
}
/* Alert Styles */
.alert {
    max-width: 600px;
    margin: 20px auto;
    padding: 15px 20px;
    border-radius: 5px;
    text-align: center;
    font-size: 1.1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: #fff;
}

.alert-success {
    background-color: #28a745;
    border: 1px solid #218838;
}

.alert-error {
    background-color: #e74c3c;
    border: 1px solid #c0392b;
}

/* Add transition for smooth visibility */
.alert {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.alert.show {
    opacity: 1;
}

</style>
<?php
// Display the message if it exists
if (isset($_SESSION['message'])) {
    $message_type = $_SESSION['message_type'] === "success" ? "alert-success" : "alert-error";
    echo "<div class='alert $message_type show'>{$_SESSION['message']}</div>";
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<div class="container2 my-5">
    <div class="membership-details">
        <h2><?php echo htmlspecialchars($plan['plan_name']); ?> Membership</h2>
        <p><?php echo htmlspecialchars($plan['description']); ?></p>
        <p class="plan-price">$<?php echo number_format($plan['price'], 2); ?>/month</p>
        <h5>Features:</h5>
        <ul class="list-unstyled">
            <li>Guest Passes: <?php echo htmlspecialchars($plan['guest_passes']); ?>/month</li>
            <li>Class Access: <?php echo htmlspecialchars($plan['class_access']); ?></li>
            <li>Health Assessment: <?php echo $plan['health_assessment'] ? 'Yes' : 'No'; ?></li>
            <li>Personal Training Sessions: <?php echo $plan['personal_training_sessions']; ?>/month</li>
            <li>Nutrition Counseling: <?php echo $plan['nutrition_counseling'] ? 'Yes' : 'No'; ?></li>
        </ul>

        <!-- Confirmation form -->
        <form action="confirm_membership.php" method="POST">
            <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit" class="btn btn-danger mt-4">Confirm Membership</button>
        </form>
        <br>
        <a href="membership.php" class="btn btn-primary">&larr; Back to Membership Plans</a>
    </div>
</div>

<?php
    } else {
        echo "<p class='text-center my-5'>Invalid Membership Plan</p>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<p class='text-center my-5'>No Membership Plan Selected</p>";
}
include 'assists/footer.php';
?>

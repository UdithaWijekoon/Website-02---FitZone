<?php include 'assists/header.php'; ?>
    <style>
        body {
            background-color: #1a1a1a; 
            color: white; 
        }
        .header-section {
            background: url('assists/membership/bg.jpg') center center no-repeat;
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
        }
        .membership-plan {
            background-color: #333;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 15px 0;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .membership-plan:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(255, 76, 76, 0.3);
        }
        .membership-plan h3 {
            margin-bottom: 15px;
            color: #ff4c4c;
        }
        .plan-price {
            font-size: 1.5rem;
            color: #ff4c4c;
            margin-bottom: 15px;
        }
        .comparison-table {
            color: white;
        }
        /* Make all membership plans the same height */
        .row .membership-plan {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .d-flex{
            margin-bottom: 60px;
        }
        .text-center {
            text-align: center;
            margin-bottom: 20px; 
            margin-top: 20px; 
        }
    </style>

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <h1>Membership Plans</h1>
        <p>Choose the plan that best fits your fitness goals!</p>
    </div>
</section>
<?php
include 'database_connection.php'; 

// Fetch membership plans from the database
$query = "SELECT * FROM membership_plans WHERE is_active = TRUE";
$result = mysqli_query($conn, $query);
?>
<div class="text-center">
        <a href="membership_details.php" class="btn btn-danger">Your Membership Details</a>
</div>
<div id="membership-plans" class="container my-5">
    <div class="row">
        <?php while ($plan = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 d-flex">
                <div class="membership-plan">
                    <h3><?php echo htmlspecialchars($plan['plan_name']); ?></h3>
                    <p><?php echo htmlspecialchars($plan['description']); ?></p>
                    <p class="plan-price">$<?php echo htmlspecialchars(number_format($plan['price'], 2)); ?>/month</p>
                    <p>Features:</p>
                    <ul class="list-unstyled">
                        <li>Guest Passes: <?php echo $plan['guest_passes']; ?>/month</li>
                        <li>Class Access: <?php echo htmlspecialchars($plan['class_access']); ?></li>
                        <li>Health Assessment: <?php echo $plan['health_assessment'] ? 'Yes' : 'No'; ?></li>
                        <li>Personal Training Sessions: <?php echo $plan['personal_training_sessions']; ?>/month</li>
                        <li>Nutrition Counseling: <?php echo $plan['nutrition_counseling'] ? 'Yes' : 'No'; ?></li>
                    </ul>
                    <a href="user_membership.php?plan_id=<?php echo $plan['id']; ?>" class="btn btn-danger mt-3">Join Now</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<br>

<!-- Comparison Table Section -->
<section class="comparison-table my-5">
    <div class="container">
        <h2 class="text-center mb-4">Compare Our Plans</h2>
        <table class="table table-dark table-striped text-center">
            <thead>
                <tr>
                    <th>Features</th>
                    <th>Basic</th>
                    <th>Premium</th>
                    <th>VIP</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gym Access</td>
                    <td>✔️</td>
                    <td>✔️</td>
                    <td>✔️</td>
                </tr>
                <tr>
                    <td>Guest Passes</td>
                    <td>1/month</td>
                    <td>2/month</td>
                    <td>5/month</td>
                </tr>
                <tr>
                    <td>All Classes</td>
                    <td>Cardio Only</td>
                    <td>✔️</td>
                    <td>✔️</td>
                </tr>
                <tr>
                    <td>Health Assessment</td>
                    <td>-</td>
                    <td>✔️</td>
                    <td>✔️</td>
                </tr>
                <tr>
                    <td>Personal Training</td>
                    <td>-</td>
                    <td>-</td>
                    <td>1 session/month</td>
                </tr>
                <tr>
                    <td>Nutrition Counseling</td>
                    <td>-</td>
                    <td>-</td>
                    <td>✔️</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<br>

<!-- Special Promotions Section -->
<section class="special-promotions my-5">
    <div class="container text-center">
        <h2>Special Promotions</h2>
        <p>Join now and get 20% off on the first three months of our Premium or VIP plans!</p>
        <a href="#membership-plans" class="btn btn-danger mt-3">Claim Offer</a>
    </div>
</section>

<?php include 'assists/footer.php'; ?> <!-- Include footer -->
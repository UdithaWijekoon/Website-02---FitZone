<?php
include 'assists/header.php';
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
?>

<style>
    .membership-container {
        padding: 40px 20px;
    }
    .membership-table {
        width: 100%;
        border-collapse: collapse;
    }
    .membership-table th, .membership-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .membership-table th {
        background-color: #333;
        color: white;
    }
    .membership-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .back-button {
    display: inline-block;
    margin-bottom: 20px;
    margin-left: 20px;
    color: #ff4c4c;
    text-decoration: none;
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

<section class="membership-container">
    <h1>Your Membership Details</h1>
    <table class="membership-table">
        <tr>
            <th>Membership Plan</th>
            <th>Start Date</th>
            <th>Status</th>
        </tr>

        <?php
        // Query to fetch membership details for the logged-in customer
        $sql = "SELECT mp.plan_name, um.start_date, um.status
                FROM user_memberships AS um
                JOIN membership_plans AS mp ON um.plan_id = mp.id
                WHERE um.user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['plan_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No membership details found.</td></tr>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </table>
</section>
<a href="javascript:history.back()" class="back-button">← Back</a>
<?php include('assists/footer.php'); ?>

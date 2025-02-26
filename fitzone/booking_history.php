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
    .history-container {
        padding: 40px 20px;
    }
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }
    .history-table th, .history-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .history-table th {
        background-color: #333;
        color: white;
    }
    .history-table tr:nth-child(even) {
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

<section class="history-container">
    <h1>Your Booking History</h1>
    <table class="history-table">
        <tr>
            <th>Booking ID</th>
            <th>Class</th>
            <th>Trainer</th>
            <th>Schedule Date</th>
            <th>Schedule Time</th>
            <th>Status</th>
        </tr>

        <?php
        // Query to fetch booking history for the logged-in customer
        $sql = "SELECT b.booking_id, c.name AS class_name, s.trainer, s.date, s.time, b.status
                FROM bookings AS b
                JOIN classes AS c ON b.class_id = c.id
                JOIN class_schedule AS s ON b.schedule_id = s.id
                WHERE b.customer_id = ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['trainer']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No bookings found.</td></tr>";
        }

        $stmt->close();
        $conn->close();
        ?>

    </table>
</section>
<a href="javascript:history.back()" class="back-button">← Back</a>

<?php include('assists/footer.php'); ?>

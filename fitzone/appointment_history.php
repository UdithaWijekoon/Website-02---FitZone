<?php
include 'assists/header.php';
include 'database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$query = "
    SELECT a.appointment_date, a.appointment_time, a.status, 
           t.name AS trainer_name, t.expertise, t.session_price
    FROM appointments a
    JOIN trainers t ON a.trainer_id = t.id
    WHERE a.customer_id = ?
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<style>
        /* Basic styling for the section */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .appointment-history {
            max-width: 800px;
            margin: 0 auto;
            margin-top: 40px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td {
            color: #555;
        }
        .status {
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
        }
        .status.Pending {
            background-color: #ffecb3;
            color: #ff9800;
        }
        .status.Confirmed {
            background-color: #c8e6c9;
            color: #388e3c;
        }
        .status.Cancelled {
            background-color: #ffcdd2;
            color: #d32f2f;
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

<section class="appointment-history">
<h1>Your Appointment History</h1>
    <table>
        <tr>
            <th>Trainer</th>
            <th>Expertise</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Session Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['trainer_name']) ?></td>
                <td><?= htmlspecialchars($row['expertise']) ?></td>
                <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                <td>
                    <span class="status <?= htmlspecialchars($row['status']) ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </span>
                </td>
                <td>$<?= htmlspecialchars(number_format($row['session_price'], 2)) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>
<a href="javascript:history.back()" class="back-button">← Back</a>
<?php
$stmt->close();
$conn->close();
?>

<?php include('assists/footer.php'); ?>
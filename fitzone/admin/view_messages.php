<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'assists/header_admin.php'; 
include 'database_connection.php';

// Fetch messages from the contact_messages table
$sql = "SELECT id, name, email, subject, message, created_at FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<style>
    /* General styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

h1 {
    text-align: center;
    color: #333;
    margin-top: 20px;
}

/* Table styling */
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

table, th, td {
    border: none;
}

th, td {
    padding: 15px;
    text-align: center;
    font-size: 0.9rem;
}

th {
    background-color: #333;
    color: #fff;
    font-weight: bold;
}

td {
    background-color: #fafafa;
    color: #333;
}

tr:nth-child(even) td {
    background-color: #f9f9f9;
}

tr:hover td {
    background-color: #ffe6e6;
}

/* Message styling */
td {
    word-wrap: break-word;
    max-width: 200px;
}

/* Responsive styling */
@media (max-width: 768px) {
    h2 {
        font-size: 1.5rem;
    }

    th, td {
        padding: 10px;
        font-size: 0.85rem;
    }
}

</style>
<h1>Customer Messages</h1>

<?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date Received</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No messages found.</p>
<?php endif; ?>

<?php
$conn->close();
include 'assists/footer_admin.php'; 
?>

<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php';

// Fetch all blog posts
$sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$result = $conn->query($sql);
include 'assists/header_admin.php'; 
?>
<style>
   /* Container styling */
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
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #ffe6e6;
}

/* Image styling */
td img {
    border-radius: 4px;
    object-fit: cover;
}

/* Actions link styling */
td a {
    color: #ff4c4c;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease;
}

td a:hover {
    color: #e04343;
}

/* Responsive styling */
@media (max-width: 768px) {
    h2 {
        font-size: 1.5rem;
    }

    .button {
        padding: 8px 15px;
        font-size: 0.9rem;
    }

    th, td {
        padding: 10px;
        font-size: 0.85rem;
    }

    td img {
        width: 80px;
        height: 50px;
    }
}
/* Message Container Styling */
.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
}

/* Success Message Styling */
.success {
    background-color: #d4edda; 
    color: #155724;
    border: 1px solid #c3e6cb; 
}

/* Error Message Styling */
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
<h1>Manage Blogs</h1>
<!-- Display success or error messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="message success">
        <?php echo $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php elseif (isset($_SESSION['error_message'])): ?>
    <div class="message error">
        <?php echo $_SESSION['error_message']; ?>
        <?php unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>
<a href="add_blog.php" class="btn btn-danger">Add New Blog</a>

<table border="1">
    <tr>
        <th>Title</th>
        <th>Image</th>
        <th>Description</th>
        <th>Featured</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" width="100" height="60" alt="Image"></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo $row['is_featured'] ? 'Yes' : 'No'; ?></td>
            <td>
                <a href="delete_blog.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
$conn->close();
include 'assists/footer_admin.php';
?>

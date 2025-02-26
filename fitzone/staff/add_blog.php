<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../admin_staff_login.php");
    exit();
}
include 'database_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = '../images/';
        $uploadFilePath = $uploadDir . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
            // Insert blog post data into the database
            $sql = "INSERT INTO blog_posts (title, image_url, description, content, is_featured) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $title, $uploadFilePath, $description, $content, $is_featured);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Blog post added successfully!"; // Set success message
            } else {
                $_SESSION['error_message'] = "Error: " . $stmt->error; // Set error message
            }

            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Error uploading image."; // Set error message
        }
    } else {
        $_SESSION['error_message'] = "Please upload an image file."; // Set error message
    }

    header("Location: add_blog.php"); 
    exit(); 
}

$conn->close();
include 'assists/header_staff.php';
?>
<style>
    /* General page styling */
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

/* Form styling */
.add {
    width: 90%;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    color: #fff;
    margin-top: 10px;
    display: block;
}

input[type="text"], 
input[type="file"], 
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    box-sizing: border-box;
    color: #fff;
    background-color: #2c2c2c;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

input[type="checkbox"] {
    margin-top: 5px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #ff4c4c;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    margin-top: 20px;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #e04343;
}

/* Responsive styling */
@media (max-width: 768px) {
    form {
        width: 100%;
        padding: 15px;
    }
}

.back-button {
    display: inline-block;
    margin-bottom: 20px;
    margin-top: 20px;
    color: #ff4c4c;
    text-decoration: none;
    font-weight: bold;
    font-size: 1rem;
    padding: 8px 16px;
    border: 2px solid #ff4c4c;
    border-radius: 5px;
    transition: background 0.3s, color 0.3s;
    width: 100%;
    text-align: center;
    }

    .back-button:hover {
    background-color: #ff4c4c;
    color: white;
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

<h1>Add New Blog Post</h1>
<!-- Display success or error messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="message success">
        <?php echo $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); // Clear the message after displaying ?>
    </div>
<?php elseif (isset($_SESSION['error_message'])): ?>
    <div class="message error">
        <?php echo $_SESSION['error_message']; ?>
        <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
    </div>
<?php endif; ?>
<form class="add" action="add_blog.php" method="post" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br>
    
    <label>Image:</label><br>
    <input type="file" name="image" required><br>
    
    <label>Description:</label><br>
    <textarea name="description" required></textarea><br>
    
    <label>Content:</label><br>
    <textarea name="content" required></textarea><br>
    
    <label>Featured:</label>
    <input type="checkbox" class="cb" name="is_featured" value="1"><br>
    
    <input type="submit" value="Add Blog Post">
    <a href="javascript:history.back()" class="back-button">← Back</a>
</form>

<?php include 'assists/footer_staff.php'; ?>

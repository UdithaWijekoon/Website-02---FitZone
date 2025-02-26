<?php
include 'assists/header.php';
include 'database_connection.php';

// Fetch all blog posts
$query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<style>
    body {
            background-color: #1a1a1a; 
            color: white; 
        }

    .blog-card {
    background-color: #2c2c2c;
    color: #fff;
    border: none;
    transition: transform 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.blog-card img {
    max-height: 600px;
    object-fit: cover;
}

.card-title {
    color: #ff4c4c;
    font-size: 1.8rem;
}

.blog-card p {
    color: #ddd;
    line-height: 1.6;
}

</style>
<div class="container my-5">
    <h2 class="text-center mb-4">Latest Blog Posts</h2>
    <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-12 mb-5">
                <div class="card blog-card p-4">
                    <img src="fitzone/<?php echo htmlspecialchars($post['image_url']); ?>" class="card-img-top mb-3" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($post['description'])); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'assists/footer.php'; ?>

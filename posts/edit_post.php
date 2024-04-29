<?php
    session_start();
    
    if (!isset($_SESSION["username"])) {
        header("Location: ../registration/profile.php");
        exit;
    }

    // Include database connection
    include '../database/db.php';

    // Check if the post ID is provided
    if (isset($_GET['blog_id'])) {
        $blog_id = $_GET['blog_id'];
        
    // Retrieve the blog post data from the database
    $sql = "SELECT * FROM blogs WHERE blog_id=$blog_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the form for editing the blog post
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="top-bar">
            <span id="topBarTitle">Edit Post</span>
        </div>

        <div class="sidebar">
            <div class="top-bar">
                <span>Weblogr</span> 
            </div>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href='../registration/profile.php'>Profile</a></li>
                <li><a href='new_post.html'>Start sharing</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
        <div class="writing-section">
        <form action="update_post.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
            <input id="blogTitle" name="title" type="text" placeholder="Blog Title..." value="<?php echo $row['title']; ?>" autocomplete="off"><br>
            <input type="file" name="uploadimage"><br><br>
            <textarea id="blogPara" name="description" cols="50" rows="7" placeholder="description..." autocomplete="off"><?php echo $row['description']; ?></textarea><br><br>
            <button id="saveBtn" type="submit">Save Changes</button>
        </form>
        </div>
    </body>
    </html>

<?php
    } else {
        echo "Blog post not found.";
    }
} else {
    echo "Post ID not provided.";
}
?>

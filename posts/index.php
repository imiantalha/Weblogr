<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
    <script src="../scripts/script.js"></script>
</head>
<body>

    <div class="sidebar">
        <div class="top-bar">
            <span>Blogs</span> 
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

    <div class="content">
        <div class="all-posts-container">
            <?php
            include '../database/db.php';

            $sql = "SELECT blog_id, title, created_date, image_path, description FROM blogs;";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-container'>";
                    echo "<span id='displayTitle'>" . $row["title"] . "</span><br>";
                    echo "<div class='date-container'>";
                    echo "<span>" . date('d/m/Y', strtotime($row["created_date"])) . "</span><br><br>";
                    echo "</div>";
                    echo "<img id='displayImage' src='../images/" . $row["image_path"] . "'><br>";
                    echo "<p id='displayPara'>" . $row["description"] . "</p>";
                    echo "<button class='like-button'><a style='margin-top:0px; text-decoration: none; color:white' href='../comments/likes.php?blog_id=" . $row['blog_id'] . "'>Like</a></button>";
                    echo "<button class='comment-button'><a style='margin-top:0px; text-decoration: none; color:white' href='../comments/comments.php?blog_id=" . $row['blog_id'] . "'>Post Comment</a></button>";
                    // Edit and delete options
                    echo "<a style='display: inline-block; text-align: right;' href='edit_post.php?blog_id=" . $row["blog_id"] . "'>Edit</a>  ";
                    echo" | ";
                    echo "<a style='display: inline-block; text-align: right;' href='delete_post.php?blog_id=" . $row["blog_id"] . "' onclick='return confirmDelete();'>Delete</a>";
                    echo "</div>";                
                }
            } else {
                echo "<center><span>No Blog Posts Found</span></center>";
            }

            $con->close();
            ?>
        </div>
        <br>
    </div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this post?");
    }
</script>

</body>
</html>

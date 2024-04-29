<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blog Post</title>
</head>
<body>

<center>
    <a href="../posts/index.php">Back</a>
    <br>
<?php
include '../database/db.php';
// Check if blog_id is provided in the URL
if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];

    // Retrieve the blog post based on the provided blog_id
    $sql_blog = "SELECT * FROM blogs WHERE blog_id = $blog_id";
    $result_blog = $con->query($sql_blog);

    $sql_count = "SELECT likes FROM blogs WHERE blog_id = $blog_id";
        $result = $con->query($sql_count);
        $row = $result->fetch_assoc();
        

    if ($result_blog->num_rows > 0) {
        // Display the blog post content
        $row = $result_blog->fetch_assoc();
        echo "<div class='post-container' style='align-items: center;'>";
        echo "<span id='displayTitle'>" . $row["title"] . "</span><br>";
        echo "<div class='date-container'>";
        echo "<span>" . date('d/m/Y', strtotime($row["created_date"])) . "</span><br><br>";
        echo "</div>";
        echo "<img id='displayImage' src='../images/" . $row["image_path"] . "'><br>";
        echo "<p id='displayPara'>" . $row["description"] . "</p>";
        echo "</div>";
        echo "Likes: " . $row['likes'];
        // Display existing comments for the blog post
        $sql_comments = "SELECT * FROM comments WHERE blog_id = $blog_id";
        $result_comments = $con->query($sql_comments);

        if ($result_comments->num_rows > 0) {
            echo "<h3>Comments:</h3>";
            while ($comment = $result_comments->fetch_assoc()) {
                echo "<div>";
                echo "<p>" . $comment["comment_text"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }

        // Comment form
        echo "<form action='save_comment.php' method='post'>";
        echo "<input type='hidden' name='blog_id' value='" . $blog_id . "'>";
        // echo "<input type='hidden' name='commenter_id' value='" . $user_id . "'>";
        echo "<textarea id='blogPara' name='comment_text' cols='40' rows='2' placeholder='Comment...'></textarea><br><br>";
        echo "<button id='saveBtn' type='submit'>Save Comment</button>";
        echo "</form>";
    } else {
        echo "<p>Blog ID not provided.</p>";
    }
}

$con->close();
?>
</center>
</body>
</html>

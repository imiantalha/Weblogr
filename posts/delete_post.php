<?php
// Include database connection
include '../database/db.php';

// Check if the post ID is provided
if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];
    
    $sql = "DELETE FROM comments WHERE blog_id = $blog_id";
    if ($con->query($sql) === TRUE) {
        // Delete the blog post from the database
        $sql = "DELETE FROM blogs WHERE blog_id= $blog_id";
        if ($con->query($sql) === TRUE) {
            
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting post: " . $con->error;
        }
        } else {
        echo "Post ID not provided.";
        }
    }

?>

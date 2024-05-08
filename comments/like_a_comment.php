<?php
include '../database/db.php';

if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];
    $blog_id = $_POST['blog_id'];
    
    // Update the like count for the comment in the database
    $sql_update_likes = "UPDATE comments SET likes = likes + 1 WHERE comment_id = ?";
    $statement = $con->prepare($sql_update_likes);
    $statement->bind_param("i", $comment_id);
    $result_update_likes = $statement->execute();
    
    if ($result_update_likes) {
        // Redirect back to the page where the comment was liked
        header("Location: comments.php?blog_id=" . $blog_id);
        exit();
    } else {
        echo "Error updating like count.";
    }
} else {
    echo "Comment ID not provided.";
}

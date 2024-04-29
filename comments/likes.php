<?php

include '../database/db.php';

if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];

    $sql = "UPDATE blogs SET likes = likes + 1 WHERE blog_id = $blog_id";
    if ($con->query($sql) === TRUE) {
        // Retrieve the updated like count
        header("location: ../posts/index.php");
    } else {
        // Error handling
        echo "Error updating like count: " . $con->error;
    }
} else {
    // Error handling
    echo "Post ID not provided.";
}
?>

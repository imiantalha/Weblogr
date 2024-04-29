<?php
// Include database connection
include '../database/db.php';

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['blog_id'], $_POST['comment_text'])) {
        // Sanitize input data
        $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
        $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);

        // Insert the comment into the database
        $sql = "INSERT INTO comments (blog_id, comment_text, comment_date) VALUES ('$blog_id', '$comment_text', NOW())";

        if ($con->query($sql) === TRUE) {
            // Redirect back to the blog post after successful comment submission
            header("Location: comments.php?blog_id=$blog_id");
            exit();
        } else {
            echo "Error saving comment: " . $con->error;
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>

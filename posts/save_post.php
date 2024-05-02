<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../registration/profile.php");
    exit;
}

include '../database/db.php';

// Check if the form is submitted as a draft
$is_draft = isset($_POST["draft"]);

$title = $_POST["title"];
$description = $_POST["description"];
$category = $_POST["category"];
$like_count = 0;

if (isset($_FILES['uploadimage'])) {
    $filename = $_FILES['uploadimage']['name'];
    $tempname = $_FILES['uploadimage']['tmp_name'];
    move_uploaded_file($tempname, "../images/" . $filename);
} 

if(isset($_POST["draft_id"])) {
    $draft_id = $_POST["draft_id"];
    $from_draft = $_POST["from_draft"];
} else {
    $draft_id = NULL;
    $from_draft = NULL;
}

if(!$is_draft  && empty($filename) && $from_draft) {
    // No new image provided, retrieve the existing image filename from the draft_posts
    $sql_draft_image = "SELECT image FROM draft_posts WHERE draft_id = $draft_id";
    $result_draft_image = $con->query($sql_draft_image);
    if ($result_draft_image->num_rows > 0) {
        $row_draft_image = $result_draft_image->fetch_assoc();
        $filename = $row_draft_image['image'];
    }
}

$username = $_SESSION["username"];
$sql = "SELECT user_id FROM users WHERE username = '$username'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
}

//draft or not
if ($is_draft) {
    if($from_draft) {
        $sql_insert_draft = "UPDATE draft_posts SET `title`='$title', `created_date`=NOW(), `image`='$filename', `description`='$description',  `category`='$category'";
    } else {
        $sql_insert_draft = "INSERT INTO draft_posts (`title`, `created_date`, `image`, `description`, `category`, `user_id`) 
            VALUES ('$title', NOW(), '$filename', '$description', '$category', '$user_id')";
    }
    

    if($con->query($sql_insert_draft)=== TRUE) {
        header('Location: draft_posts.php');
        exit;
    } else {
        echo "Error saving post: " . $con->error;
    }
} else {
    $sql_insert_blogs = "INSERT INTO blogs (`title`, `created_date`, `image`, `description`, `category`, `user_id`) 
            VALUES ('$title', NOW() , '$filename', '$description', '$category', '$user_id')";

    if ($con->query($sql_insert_blogs) === TRUE) {
        if($from_draft) {
            $delete_draft = "DELETE FROM draft_posts WHERE draft_id = $draft_id";
            if ($con->query($delete_draft) === TRUE) {
                // header('Location: save_post.php');                 
            } else {
                echo "Error deleting draft post: " . $con->error;
            }
        } else {
            // header('Location: save_post.php');
        }
    } else {
        echo "Error saving post: " . $con->error;
    }
} 

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Saved</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php include 'sidebar.php'; ?>
    
    <div class="all-posts-container">
        <h1>Uploaded</h1>
    <!-- <div class="post-container"> -->
        <br>
        <span style='font-weight: bold;' id='displayTitle'><?php echo $title ?></span>
        <br>
        <span><?php echo "Category: " . $category; ?></span>
        <br>
        <center><img id='displayImage' src="../images/<?php echo $filename; ?>" alt="image"></center>
        <br>
        <span id='displayPara'><?php echo $description; ?></span>
        <br><br>
    <!-- </div> -->
    </div>
</body>
</html>
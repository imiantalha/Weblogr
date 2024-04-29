<?php
session_start();
    
 if (!isset($_SESSION["username"])) {
    header("Location: ../registration/profile.php");
    exit;
}

include '../database/db.php';

$title = $_POST["title"];
$description = $_POST["description"];
$like_count = 0;
$filename = "NONE";

if (isset($_FILES['uploadimage'])) {
    $filename = $_FILES['uploadimage']['name'];
    $tempname = $_FILES['uploadimage']['tmp_name'];
    move_uploaded_file($tempname, "../images/" . $filename);
}

$username = $_SESSION["username"];
$sql = "SELECT user_id FROM users WHERE username = '$username'";
$result = $con->query($sql);
if($result) {
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }
}
    

$sql = "INSERT INTO blogs (`title`, `created_date`, `image_path`, `description`, `user_id`) 
        VALUES ('$title', NOW() , '$filename', '$description', '$user_id')"; 

if ($con->query($sql) === TRUE) {
    // Post saved successfully
} else {
    echo "Error saving post: " . $conn->error;
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
    <div class="all-posts-container">
        <h1>Post Uploaded</h1>
    <!-- <div class="post-container"> -->
        <br>
        <span style='font-weight: bold;' id='displayTitle'><?php echo $title; ?></span>
        <br>
        <center><img id='displayImage' src="../images/<?php echo $filename; ?>"></center>
        <br>
        <span id='displayPara'><?php echo $description; ?></span>
        <br><br>
    <!-- </div> -->
    </div>
</body>
</html>

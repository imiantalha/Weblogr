<?php
    session_start();
    
    if (!isset($_SESSION["username"])) {
        header("Location: ../registration/login.php");
        exit;
    }

    include '../database/db.php';

    $username = $_SESSION["username"];
    $sql = "SELECT user_id FROM users WHERE username = '$username'";
    $result = $con->query($sql);
    if($result) {
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
        }
    }


    $sql = "SELECT COUNT(*) AS post_count FROM blogs WHERE user_id = $user_id";
    $result = $con->query($sql);
    $post_count = ($result && $result->num_rows > 0) ? $result->fetch_assoc()["post_count"] : 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 class="profile-h2">Welcome to Your Weblogr's Profile</h2>
    <div class="sidebar">
        <div class="top-bar">
            <span>Blogs</span> 
        </div>
        <ul class="menu">
        <li><a href="../posts/index.php">Home</a></li>
            <li><a href='profile.php'>Profile</a></li>
            <li><a href='../posts/new_post.html'>Start sharing</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
    <div class="profile-container">
        <div class="profile-picture">
            <img src="../images/M.png" alt="Profile Picture">
        </div>
        <div class="user-info">
                <h1>
                <?php
                    echo " " . strtoupper($_SESSION["username"]);
                ?></h1>
            <div class="stats">
                <span>
                    <strong>
                    <?php echo $post_count ?>
                    </strong>
                    <br>
                    Posts
                </span>
                <span>
                    <strong>
                       1
                    </strong>
                    <br>
                    Followers
                </span>
                <span>
                    <strong>0</strong>
                    <br>
                    Following
                </span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed arcu magna, tincidunt mattis pulvinar vel, pulvinar eget augue. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>
            <button class="profile-btn"><a href="../posts/user_posts.php"><b>My Posts</b></a></button>
            <button class="profile-btn"><b>Edit Profile</b></button>
            <button class="profile-btn"><a href="logout.php"><b>Log Out</b></a></button>

        </div>
    </div>    
</body>
</html>

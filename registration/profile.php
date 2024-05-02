<?php
    session_start();
    
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
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

    // Fetch user's profile information from the profile table
    $sql_profile = "SELECT * FROM profile WHERE user_id = $user_id";
    $result_profile = $con->query($sql_profile);
    if ($result_profile && $result_profile->num_rows > 0) {
        $profile_data = $result_profile->fetch_assoc();
        $full_name = $profile_data['full_name'];
        $bio = $profile_data['bio'];
        $profile_picture = $profile_data['profile_picture'];
        if(empty($profile_picture)) {
            $profile_picture = 'logo.PNG';
        }
    } else {
        $full_name = 'Your name';
        $bio = 'Bio';
        $profile_picture = 'logo.PNG';
    }

    // Count the number of posts for the user
    $sql_post_count = "SELECT COUNT(*) AS post_count FROM blogs WHERE user_id = $user_id";
    $result_post_count = $con->query($sql_post_count);
    $post_count = ($result_post_count && $result_post_count->num_rows > 0) ? $result_post_count->fetch_assoc()["post_count"] : 0;

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
    
    <?php include '../posts/sidebar.php'; ?>
    
    <div class="profile-container">
        <div class="profile-picture">
            <img src="<?php echo "../uploads/" . $profile_picture ?>" alt="Profile Picture">
        </div>
        <div class="user-info">
            <h1><?php echo $full_name ?></h1>
            <div class="stats">
                <span><strong><?php echo $post_count ?></strong><br>Posts</span>
                <span><strong>1</strong><br>Followers</span>
                <span><strong>0</strong><br>Following</span>
            </div>
            <p><?php echo $bio ?></p>
            <br>
            <a href="edit_profile.php"><b>Edit Profile</b></a>
        </div>
    </div>    
</body>
</html>

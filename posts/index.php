<?php 
    session_start();

    if(!isset($_SESSION['username'])) {
        header('Locaton: ../registration/login.php');
        exit;
    }
?>

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

<?php include 'sidebar.php'; ?>
    
<div class="content">
    <div class="all-posts-container">
        <form action="" method="GET">
            <label for="category" style="font-size: 20px;">SELECT: </label>
            <select name="category" id="category" style="width: 150px; text-align: center; font-size: 16px; color: #999; border:none">
                <option value="">--Category--</option>
                <option value="education">Education</option>
                <option value="technology">Technology</option>
                <option value="travel">Travel</option>
                <option value="food">Food</option>
                <option value="fashion">Fashion</option>
                <option value="sport">Sports    </option>
            </select>
            <input type="submit" value="Filter" style="border: 2px solid gray;">
        </form>
        
        <?php
        include '../database/db.php';

        // Default SQL query to fetch all blog posts
        $sql = "SELECT blog_id, title, created_date, image, description FROM blogs";

        // Check if a category is selected
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            // Sanitize the selected category to prevent SQL injection
            $selected_category = mysqli_real_escape_string($con, $_GET['category']);
            // Modify the SQL query to fetch blog posts of the selected category
            $sql .= " WHERE category = '$selected_category'";
        }

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post-container'>";
                echo "<span id='displayTitle'>" . $row["title"] . "</span><br>";
                echo "<div class='date-container'>";
                echo "<span>" . date('d/m/Y', strtotime($row["created_date"])) . "</span><br><br>";
                echo "</div>";
                echo "<img id='displayImage' src='../images/" . $row["image"] . "' alt='image'><br>";
                echo "<p id='displayPara'>" . $row["description"] . "</p>";
                echo "<button class='like-button'><a style='margin-top:0px; text-decoration: none; color:white' href='../comments/likes.php?blog_id=" . $row['blog_id'] . "'>Like</a></button>";
                echo "<button class='comment-button'><a style='margin-top:0px; text-decoration: none; color:white;' href='../comments/comments.php?blog_id=" . $row['blog_id'] . "'>Post Comment</a></button>";
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

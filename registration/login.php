<?php
session_start();

// Redirect if the user is already logged in
if (isset($_SESSION["username"])) {
    header("Location: profile.php");
    exit;
}

$password_exist = false;
$username_exist = false;
$account_not_verified = false;

if (isset($_POST['username'])) {

    // Database con
    include '../database/db.php';

    //escaping special characters in a string 
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $select = "SELECT username, password, is_verified FROM users WHERE username = ?";
    $statement = $con->prepare($select);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $username_exist = true;
                $password_exist = true;
                if (!$row['is_verified']) {
                    // Set session variable for logged-in user
                    $_SESSION["username"] = $username;
                    // Redirect on successful login
                    header("Location: ../posts/index.php");
                    exit;
                } else {
                    // User is not verified
                    $account_not_verified = true;
                }
            } 
        }
    }

    if (!$username_exist || !$password_exist) {
        echo '<script>alert("Username or password is incorrect.");</script>';
    }

    $statement->close();
    $con->close();
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title> 
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>

<body>
  <div class="container">
    <div class="welcome">
        <h1>Welcome to Weblogr</h1>
    </div>

    <div class="wrapper">
      <div class="title"><span>Login Form</span></div>

      <form name="sign-in" method="post">
        <div class="row">
          <i class="fas fa-user"></i>
          <input type="text" placeholder="Username" required="" name="username" id="username">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" placeholder="Password" required="" name="password" id="password">
        </div>
        <div class="row">
          <select name="type" id="" class="row" style="width: 100%; text-align: center; font-size: 18px; color: #999;">
            <option value="user" selected>USER</option>
            <option value="admin">ADMIN</option>
          </select>
        </div>
        <div class="row button">
          <input type="submit" value="Login" name="login"> 
          <a href="forgot_password.php" style="float:right;">Forgot Password?</a><br>
        </div>
        <br>
        <div class="signup-link">Not a member? <a href="signup.php">Signup Now</a></div>
      </form>
    </div>
  </div>
</body>
</html>

<?php 
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Your Profile</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="navbar">
    <img src="uploads/<?php echo $u['avatar']; ?>" class="avatar">
    <a href="home.php">Home</a>
    <a href="contact.php">Creators</a>
    <a href="logout.php">Logout</a>
</div>

<div class="profile-box">
    <h1><?php echo $u['name']; ?></h1>
    <img src="uploads/<?php echo $u['avatar']; ?>" class="big-avatar">
    <p><strong>Email:</strong> <?php echo $u['email']; ?></p>
    <p><strong>Bio:</strong> <?php echo $u['bio']; ?></p>
    <p><strong>Joined:</strong> <?php echo $u['created_at']; ?></p>
</div>

</body>
</html>

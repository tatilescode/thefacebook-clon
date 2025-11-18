<?php
// index.php
require_once 'config.php';
secureSession();

// Si ya está logueado, redirigir a home
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thefacebook</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="index-page">
    <div class="index-container">
        <div class="index-header">
            <h1>thefacebook</h1>
            <p class="tagline">a Mark Zuckerberg production</p>
        </div>
        
        <div class="index-content">
            <div class="welcome-box">
                <h2>Welcome to thefacebook</h2>
                <p>thefacebook is an online directory that connects people through universities.</p>
                
                <div class="features">
                    <h3>Features:</h3>
                    <ul>
                        <li>Search for people at your university</li>
                        <li>Find out who are in your classes</li>
                        <li>Look up your friends' friends</li>
                        <li>See a visualization of your social network</li>
                    </ul>
                </div>
                
                <div class="cta-buttons">
                    <a href="login.php" class="btn-primary">Log In</a>
                    <a href="register.php" class="btn-secondary">Sign Up</a>
                </div>
                
                <p class="note">You must have a university email address to register.</p>
            </div>
            
            <div class="info-box">
                <h3>About This Project</h3>
                <p>This is a recreation of the original Facebook interface from 2004, developed as an academic project to demonstrate web development skills using PHP, MySQL, HTML, CSS, and JavaScript.</p>
                <p>The interface and functionality are inspired by the original thefacebook that launched at Harvard University.</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2004 thefacebook</p>
    </footer>
</body>
</html>
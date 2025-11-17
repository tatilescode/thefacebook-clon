<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user'] = mysqli_fetch_assoc($result);
        header("Location: home.php");
        exit();
    } else {
        $error = "Datos incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Thefacebook - Login</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container small">
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p style="color:red;"><?php echo $error; ?></p>

    <a href="index.php">Back</a>
</div>

</body>
</html>
            Welcome to Thefacebook, a social utility that helps you connect with your friends and family.
            Share photos, updates, and stay in touch with people you care about.
        </p>
    </div>  

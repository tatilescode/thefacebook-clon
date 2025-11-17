<?php
include 'config.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    
    if (mysqli_query($conn, $query)) {
        $msg = "Cuenta creada con éxito. <a href='login.php'>Iniciar sesión</a>";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Thefacebook - Register</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container small">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Create Account</button>
    </form>
    <p><?php echo $msg; ?></p>

    <a href="index.php">Back</a>
</div>

</body>
</html>

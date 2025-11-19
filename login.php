<?php
// login.php
require_once 'config.php';
secureSession();

// Si ya está logueado, redirigir
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $conn = getDBConnection();
        
        $stmt = $conn->prepare("SELECT id, first_name, last_name, avatar FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_avatar'] = $user['avatar'];
            
            $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("i", $user['id']);
            $updateStmt->execute();
            $updateStmt->close();
            
            header('Location: home.php');
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[thefacebook]</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 11px;
            background-color: #3b5998;
            color: #333;
        }
        
        .main-wrapper {
            width: 900px;
            margin: 20px auto;
            background: white;
            border: 2px solid #cccccc;
        }
        
        /* Header */
        .header {
            background: linear-gradient(to bottom, #6d84b4 0%, #3b5998 100%);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #133783;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: -1px;
        }
        
        .logo-text {
            color: #cce;
            font-size: 11px;
        }
        
        .nav-links {
            display: flex;
            gap: 15px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 11px;
        }
        
        .nav-links a:hover {
            text-decoration: underline;
        }
        
        /* Content Area */
        .content-wrapper {
            display: flex;
            min-height: 500px;
        }
        
        /* Left Sidebar - Login */
        .sidebar-login {
            width: 280px;
            padding: 20px;
            background: #f7f7f7;
            border-right: 1px dashed #999;
        }
        
        .login-box {
            background: white;
            border: 2px dotted #999;
            padding: 15px;
        }
        
        .login-box h3 {
            margin-bottom: 10px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .form-row {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .form-row label {
            width: 70px;
            text-align: right;
            padding-right: 5px;
            font-size: 11px;
        }
        
        .form-row input[type="text"],
        .form-row input[type="email"],
        .form-row input[type="password"] {
            flex: 1;
            padding: 3px 5px;
            border: 1px solid #999;
            font-size: 11px;
            font-family: Verdana, sans-serif;
        }
        
        .button-row {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 15px;
        }
        
        .btn {
            padding: 3px 15px;
            border: 1px solid #999;
            background: #f0f0f0;
            cursor: pointer;
            font-size: 11px;
            font-family: Verdana, sans-serif;
        }
        
        .btn:hover {
            background: #e0e0e0;
        }
        
        .btn-primary {
            background: #6d84b4;
            color: white;
            border-color: #3b5998;
        }
        
        .btn-primary:hover {
            background: #5b7399;
        }
        
        .error-msg {
            background: #ffebe8;
            border: 1px solid #dd3c10;
            color: #dd3c10;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 11px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px 40px;
        }
        
        .welcome-header {
            background: #6d84b4;
            color: white;
            padding: 8px 15px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 13px;
        }
        
        .welcome-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        
        .welcome-text {
            line-height: 1.6;
            margin-bottom: 15px;
            font-size: 12px;
        }
        
        .welcome-text strong {
            font-weight: bold;
        }
        
        .features-list {
            margin: 20px 0 20px 20px;
            line-height: 1.8;
            font-size: 12px;
        }
        
        .cta-text {
            margin: 20px 0;
            font-size: 12px;
        }
        
        .cta-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        
        .btn-large {
            padding: 5px 25px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            background: #f7f7f7;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #ccc;
            font-size: 10px;
        }
        
        .footer-links {
            margin-bottom: 8px;
        }
        
        .footer-links a {
            color: #3b5998;
            text-decoration: none;
            margin: 0 8px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .footer-text {
            color: #666;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px; /* Espacio entre el título y la producción */
        }

        /* Foto del creador */
        #creator-photo {
            width: 75px;
            height: 75px;
            border: 1px solid #ffffff;
            object-fit: cover;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->

        <div class="header">
            <div class="header-left">
                <div class="logo">[thefacebook]</div>
                <img 
                        id="creator-photo" 
                        src="uploads/foto tati.jpg" 
                        alt="Foto de la Creadora" 
                    >
                <div class="logo-text">a Tatiana López production</div>
            </div>
            <div class="nav-links">
                <a href="login.php">login</a>
                <a href="register.php">register</a>
                <a href="contact.php">about</a>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content-wrapper">
            <!-- Left Sidebar - Login Form -->
            <div class="sidebar-login">
                <div class="login-box">
                    <h3>Login</h3>
                    
                    <?php if ($error): ?>
                        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="login.php">
                        <div class="form-row">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-row">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <div class="button-row">
                            <a href="register.php" class="btn">register</a>
                            <button type="submit" class="btn btn-primary">login</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="main-content">
                <div class="welcome-header">Welcome to Thefacebook!</div>
                
                <h1 class="welcome-title">[ Welcome to Thefacebook ]</h1>
                
                <p class="welcome-text">
                    Thefacebook is an online directory that connects people through social networks at colleges.
                </p>
                
                <p class="welcome-text">
                    We have opened up Thefacebook for popular consumption at <strong>your university</strong>.
                </p>
                
                <p class="welcome-text">You can use Thefacebook to:</p>
                
                <ul class="features-list">
                    <li>Search for people at your school</li>
                    <li>Find out who are in your classes</li>
                    <li>Look up your friends' friends</li>
                    <li>See a visualization of your social network</li>
                </ul>
                
                <p class="cta-text">
                    To get started, click below to register. If you have already registered, you can log in.
                </p>
                
                <div class="cta-buttons">
                    <a href="register.php" class="btn btn-large">Register</a>
                    <a href="login.php" class="btn btn-primary btn-large">Login</a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-links">
                <a href="contact.php">about</a>
                <a href="#">contact</a>
                <a href="#">faq</a>
                <a href="#">terms</a>
                <a href="#">privacy</a>
            </div>
            <div class="footer-text">
                a Mark Zuckerberg production<br>
                Thefacebook &copy; 2004
            </div>
        </div>
    </div>
</body>
</html>

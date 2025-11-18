<?php
// login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        try {
            $conn = getDBConnection();
            
            // Buscar usuario por email y contraseña (texto plano)
            $stmt = $conn->prepare("SELECT id, first_name, last_name, avatar FROM users WHERE email = ? AND password = ?");
            
            if (!$stmt) {
                $error = 'Database error: ' . $conn->error;
            } else {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    
                    // Establecer sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    $_SESSION['user_avatar'] = $user['avatar'];
                    
                    // Actualizar último login
                    $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $user['id']);
                    $updateStmt->execute();
                    $updateStmt->close();
                    
                    $stmt->close();
                    $conn->close();
                    
                    // Redirigir a home
                    header('Location: home.php');
                    exit();
                } else {
                    $error = 'Invalid email or password. Please check your credentials.';
                }
                
                $stmt->close();
            }
            
            $conn->close();
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thefacebook | login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <h1><a href="index.php">thefacebook</a></h1>
            <p class="tagline">a Mark Zuckerberg production</p>
        </div>
        
        <div class="login-box">
            <h2>Log In</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">University Email:</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Log In</button>
            </form>
            
            <div class="register-link">
                Don't have an account? <a href="register.php">Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>
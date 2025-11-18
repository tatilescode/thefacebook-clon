<?php
// contact.php

// 1. Incluir el archivo de configuración (donde deben estar definidas las constantes DB_HOST, etc.)
require_once 'config.php';
secureSession();

// 2. Comprobar autenticación
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 3. Establecer conexión a la DB
$conn = getDBConnection();

// 4. Obtener información del usuario para el navbar
$stmt = $conn->prepare("SELECT first_name, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// 5. Obtener creadores (CORRECCIÓN APLICADA AQUÍ)
$creators = [];
// Se eliminó la palabra extraña 'TContinuar' de la consulta.
$result = $conn->query("SELECT * FROM creators ORDER BY display_order");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $creators[] = $row;
    }
    $result->free(); // Liberar la memoria del resultado
}

// 6. Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thefacebook | about the creators</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="contact-page">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <h1 class="logo"><a href="home.php">thefacebook</a></h1>
            </div>
            <div class="nav-right">
                <a href="home.php" class="nav-link">home</a>
                <a href="profile.php" class="nav-link">profile</a>
                <a href="contact.php" class="nav-link active">contact</a>
                <a href="logout.php" class="nav-link">logout</a>
                <div class="nav-avatar">
                    <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" 
                         alt="<?php echo htmlspecialchars($user['first_name']); ?>"
                         onerror="this.src='uploads/default-avatar.jpg'">
                </div>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="contact-container">
            <h2>About thefacebook</h2>
            <div class="about-section">
                <p>thefacebook is an online directory that connects people through universities.</p>
                <p>This is a faithful recreation of the original Facebook interface from 2004, developed as an academic project.</p>
            </div>
            <h2>The Creators</h2>
            <div class="creators-grid">
                <?php foreach ($creators as $creator): ?>
                <div class="creator-card">
                    <div class="creator-photo">
                        <img src="uploads/<?php echo htmlspecialchars($creator['photo']); ?>" 
                             alt="<?php echo htmlspecialchars($creator['name']); ?>"
                             onerror="this.src='uploads/default-avatar.jpg'">
                    </div>
                    <div class="creator-info">
                        <h3><?php echo htmlspecialchars($creator['name']); ?></h3>
                        <p class="creator-role"><?php echo htmlspecialchars($creator['role']); ?></p>
                        <?php if ($creator['description']): ?>
                        <p class="creator-description"><?php echo htmlspecialchars($creator['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="project-info">
                <h3>Project Information</h3>
                <ul>
                    <li><strong>Technologies:</strong> PHP, MySQL, HTML, CSS, JavaScript</li>
                    <li><strong>Purpose:</strong> Educational project recreating the original Facebook</li>
                    <li><strong>Features:</strong> User registration, authentication, profile management</li>
                    <li><strong>Year:</strong> 2025</li>
                </ul>
            </div>
            <div class="disclaimer">
                <p><em>Note: This is a student project and is not affiliated with Meta Platforms, Inc. or Facebook. All trademarks belong to their respective owners.</em></p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2004 thefacebook | a Mark Zuckerberg production (recreation)</p>
    </footer>
</body>
</html>

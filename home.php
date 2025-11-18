<?php
// home.php
require_once 'config.php';
secureSession();

// Verificar si está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = getDBConnection();

// Obtener información del usuario
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thefacebook | <?php echo htmlspecialchars($user['first_name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-page">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <h1 class="logo"><a href="home.php">thefacebook</a></h1>
            </div>
            <div class="nav-right">
                <a href="home.php" class="nav-link">home</a>
                <a href="profile.php" class="nav-link">profile</a>
                <a href="contact.php" class="nav-link">contact</a>
                <a href="logout.php" class="nav-link">logout</a>
                <div class="nav-avatar">
                    <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" 
                         alt="<?php echo htmlspecialchars($user['first_name']); ?>"
                         onerror="this.src='uploads/default-avatar.jpg'">
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="profile-container">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar-large">
                    <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" 
                         alt="<?php echo htmlspecialchars($user['first_name']); ?>"
                         onerror="this.src='uploads/default-avatar.jpg'">
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
                    <p class="profile-email"><?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="profile-member-since">
                        Member since <?php echo date('F j, Y', strtotime($user['created_at'])); ?>
                    </p>
                    <?php if ($user['last_login']): ?>
                        <p class="profile-last-login">
                            Last login: <?php echo date('F j, Y g:i A', strtotime($user['last_login'])); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="profile-section">
                <h3>Basic Info</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['relationship_status']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Looking For:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['looking_for']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Interested In:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['interested_in']); ?></span>
                    </div>
                    <?php if ($user['political_views']): ?>
                    <div class="info-item">
                        <span class="info-label">Political Views:</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['political_views']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($user['bio']): ?>
            <div class="profile-section">
                <h3>About Me</h3>
                <p><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($user['interests']): ?>
            <div class="profile-section">
                <h3>Interests</h3>
                <p><?php echo nl2br(htmlspecialchars($user['interests'])); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($user['favorite_music']): ?>
            <div class="profile-section">
                <h3>Favorite Music</h3>
                <p><?php echo nl2br(htmlspecialchars($user['favorite_music'])); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($user['favorite_movies']): ?>
            <div class="profile-section">
                <h3>Favorite Movies</h3>
                <p><?php echo nl2br(htmlspecialchars($user['favorite_movies'])); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($user['favorite_books']): ?>
            <div class="profile-section">
                <h3>Favorite Books</h3>
                <p><?php echo nl2br(htmlspecialchars($user['favorite_books'])); ?></p>
            </div>
            <?php endif; ?>

            <div class="profile-actions">
                <a href="profile.php" class="btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2004 thefacebook | <a href="contact.php">About the Creators</a></p>
    </footer>
</body>
</html>
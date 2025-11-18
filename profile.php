<?php
// profile.php
require_once 'config.php';
secureSession();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = getDBConnection();
$success = '';
$error = '';

// Obtener información del usuario
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Actualizar perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = trim($_POST['bio']);
    $lookingFor = $_POST['looking_for'];
    $interestedIn = $_POST['interested_in'];
    $relationshipStatus = $_POST['relationship_status'];
    $politicalViews = trim($_POST['political_views']);
    $interests = trim($_POST['interests']);
    $favoriteMusic = trim($_POST['favorite_music']);
    $favoriteMovies = trim($_POST['favorite_movies']);
    $favoriteBooks = trim($_POST['favorite_books']);
    
    // Manejar subida de avatar
    $avatarName = $user['avatar'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['avatar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed) && $_FILES['avatar']['size'] < 5000000) {
            $newName = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], 'uploads/' . $newName)) {
                $avatarName = $newName;
            }
        }
    }
    
    $stmt = $conn->prepare("UPDATE users SET bio = ?, avatar = ?, looking_for = ?, interested_in = ?, relationship_status = ?, political_views = ?, interests = ?, favorite_music = ?, favorite_movies = ?, favorite_books = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssi", $bio, $avatarName, $lookingFor, $interestedIn, $relationshipStatus, $politicalViews, $interests, $favoriteMusic, $favoriteMovies, $favoriteBooks, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $_SESSION['user_avatar'] = $avatarName;
        $success = 'Profile updated successfully!';
        $user['avatar'] = $avatarName;
        $user['bio'] = $bio;
        $user['looking_for'] = $lookingFor;
        $user['interested_in'] = $interestedIn;
        $user['relationship_status'] = $relationshipStatus;
        $user['political_views'] = $politicalViews;
        $user['interests'] = $interests;
        $user['favorite_music'] = $favoriteMusic;
        $user['favorite_movies'] = $favoriteMovies;
        $user['favorite_books'] = $favoriteBooks;
    } else {
        $error = 'Error updating profile.';
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thefacebook | edit profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="profile-edit-page">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <h1 class="logo"><a href="home.php">thefacebook</a></h1>
            </div>
            <div class="nav-right">
                <a href="home.php" class="nav-link">home</a>
                <a href="profile.php" class="nav-link active">profile</a>
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

    <div class="main-container">
        <div class="edit-profile-container">
            <h2>Edit Your Profile</h2>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="profile.php" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Profile Picture</h3>
                    <div class="current-avatar">
                        <img src="uploads/<?php echo htmlspecialchars($user['avatar']); ?>" 
                             alt="Current avatar"
                             onerror="this.src='uploads/default-avatar.jpg'">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Upload New Picture:</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                        <small>Max 5MB. Allowed: JPG, PNG, GIF</small>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Basic Info</h3>
                    <div class="form-group">
                        <label for="relationship_status">Relationship Status:</label>
                        <select id="relationship_status" name="relationship_status">
                            <option value="Single" <?php echo $user['relationship_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                            <option value="In a Relationship" <?php echo $user['relationship_status'] == 'In a Relationship' ? 'selected' : ''; ?>>In a Relationship</option>
                            <option value="Married" <?php echo $user['relationship_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                            <option value="Its Complicated" <?php echo $user['relationship_status'] == 'Its Complicated' ? 'selected' : ''; ?>>It's Complicated</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="looking_for">Looking For:</label>
                        <select id="looking_for" name="looking_for">
                            <option value="Friends" <?php echo $user['looking_for'] == 'Friends' ? 'selected' : ''; ?>>Friends</option>
                            <option value="Dating" <?php echo $user['looking_for'] == 'Dating' ? 'selected' : ''; ?>>Dating</option>
                            <option value="Random Play" <?php echo $user['looking_for'] == 'Random Play' ? 'selected' : ''; ?>>Random Play</option>
                            <option value="Whatever" <?php echo $user['looking_for'] == 'Whatever' ? 'selected' : ''; ?>>Whatever</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="interested_in">Interested In:</label>
                        <select id="interested_in" name="interested_in">
                            <option value="Men" <?php echo $user['interested_in'] == 'Men' ? 'selected' : ''; ?>>Men</option>
                            <option value="Women" <?php echo $user['interested_in'] == 'Women' ? 'selected' : ''; ?>>Women</option>
                            <option value="Both" <?php echo $user['interested_in'] == 'Both' ? 'selected' : ''; ?>>Both</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="political_views">Political Views:</label>
                        <input type="text" id="political_views" name="political_views" 
                               value="<?php echo htmlspecialchars($user['political_views']); ?>">
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>About You</h3>
                    <div class="form-group">
                        <label for="bio">About Me:</label>
                        <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="interests">Interests:</label>
                        <textarea id="interests" name="interests" rows="3"><?php echo htmlspecialchars($user['interests']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="favorite_music">Favorite Music:</label>
                        <textarea id="favorite_music" name="favorite_music" rows="3"><?php echo htmlspecialchars($user['favorite_music']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="favorite_movies">Favorite Movies:</label>
                        <textarea id="favorite_movies" name="favorite_movies" rows="3"><?php echo htmlspecialchars($user['favorite_movies']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="favorite_books">Favorite Books:</label>
                        <textarea id="favorite_books" name="favorite_books" rows="3"><?php echo htmlspecialchars($user['favorite_books']); ?></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <a href="home.php" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2004 thefacebook</p>
    </footer>
</body>
</html>
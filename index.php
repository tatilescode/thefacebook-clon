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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Facebook - Login</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff; 
            color: #000000;
            margin: 0;
            padding: 20px;
        }

        /* Contenedor principal para centrar el contenido */
        .main-container {
            width: 750px;
            margin: 0 auto;
            border: 1px solid #3B5998; /* Borde azul para el contenedor principal */
        }

        /* ENCABEZADO */
        .header {
            background-color: #3B5998;
            color: #FFFFFF;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10pt;
        }

        /* Título [thefacebook] */
        .header h1 {
            font-size: 15pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
            letter-spacing: 1px;
        }

        /* Contenedor del título y la producción */
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
        
        /* Estilo para el texto de producción */
        .production-text {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 8pt;
        }

        /* Enlaces del encabezado */
        .header-nav a {
            color: #FFFFFF;
            text-decoration: none;
            padding: 0 5px;
        }
        .header-nav a:hover {
            text-decoration: underline;
        }

        /* CONTENIDO PRINCIPAL */
        .content {
            padding: 10px;
            display: flex;
        }

        /* COLUMNA IZQUIERDA: Formulario de Login */
        .login-column {
            width: 170px;
            padding-right: 15px;
            font-size: 10pt;
        }
        .login-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        .login-row label {
            font-weight: bold;
            text-align: right;
            margin-right: 5px;
        }
        .login-column input[type="text"], 
        .login-column input[type="password"] {
            width: 100px;
            border: 1px solid #777777;
            padding: 1px;
            font-size: 10pt;
        }
        .login-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 5px;
            margin-top: 10px;
        }
        
        /* Botones (simulando el estilo clásico) */
        .login-buttons button, .content-buttons button {
            background-color: #F0F0F0;
            border: 1px solid #3B5998;
            color: #3B5998;
            font-size: 10pt;
            padding: 1px 5px;
            cursor: pointer;
        }
        .login-buttons button:hover, .content-buttons button:hover {
            background-color: #CCCCCC;
        }

        /* COLUMNA DERECHA: Texto de Bienvenida */
        .welcome-column {
            flex-grow: 1;
            padding-left: 15px;
            border-left: 1px dashed #cccccc; /* Separador de columna */
        }
        
        /* Título de bienvenida */
        .welcome-title-box {
            background-color: #D8E6F3;
            border: 1px solid #3B5998;
            color: #3B5998;
            font-size: 12pt;
            font-weight: bold;
            padding: 3px 5px;
            margin-bottom: 10px;
        }

        .welcome-column p {
            margin-bottom: 10px;
            font-size: 10pt;
            line-height: 1.4;
        }
        
        .welcome-column ul {
            list-style-type: disc;
            margin-left: 20px;
            padding-left: 0;
            font-size: 10pt;
        }
        
        .welcome-column li {
            margin-bottom: 5px;
        }

        .content-buttons {
            margin-top: 15px;
        }
        .content-buttons button {
            background-color: #3B5998;
            color: #FFFFFF;
            border-color: #3B5998;
            padding: 4px 10px;
            font-size: 11pt;
            font-weight: bold;
        }
        .content-buttons button:hover {
            background-color: #2D4373;
        }

        /* PIE DE PÁGINA */
        .footer {
            text-align: center;
            font-size: 9pt;
            padding: 10px 0;
            border-top: 1px solid #cccccc;
            margin-top: 10px;
        }
        .footer a {
            color: #3B5998;
            text-decoration: none;
            padding: 0 5px;
        }
        .footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <!-- CONTENIDO VISUAL DENTRO DEL BODY -->
    <div class="main-container">

        <!-- ENCABEZADO -->
        <header class="header">
            <div class="header-left">
                <h1>[thefacebook]</h1>
                
                <!-- SECCIÓN DEL CREADOR (con la foto) -->
                <div class="production-text">
                    <img 
                        id="creator-photo" 
                        src="uploads/foto tati.jpg" 
                        alt="Foto de la Creadora" 
                    >
                    <span>a Tatiana Lopez's production</span>
                </div>
            </div>
            
            <nav class="header-nav">
                <a href="login.php">login</a> | 
                <a href="register.php">register</a> | 
                <a href="about.php">about</a>
            </nav>
        </header>
        
        <!-- CONTENIDO PRINCIPAL -->
        <main class="content">
            
            <!-- COLUMNA IZQUIERDA: Formulario de Login -->
            <div class="login-column">
                <!-- Usamos un formulario que apunta a login.php para la lógica de inicio de sesión -->
                <form action="login.php" method="POST">
                    <div class="login-row">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="tescobar@ug.edu.gt">
                    </div>
                    <div class="login-row">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="login-buttons">
                        <!-- El botón register lleva a la página de registro -->
                        <button type="button" onclick="window.location.href='register.php'">register</button>
                        <!-- El botón login envía el formulario -->
                        <button type="submit">login</button>
                    </div>
                </form>
            </div>
            
            <!-- COLUMNA DERECHA: Texto de Bienvenida e Información -->
            <div class="welcome-column">
                <div class="welcome-title-box">
                    [ Welcome to Thefacebook ]
                </div>
                
                <p>
                    Thefacebook is an online directory that connects people through social networks at colleges.
                </p>
                <p>
                    We have opened up Thefacebook for popular consumption at <strong>your university</strong>.
                </p>
                
                <p>You can use Thefacebook to:</p>
                <ul>
                    <li>Search for people at your school</li>
                    <li>Find out who are in your classes</li>
                    <li>Look up your friends' friends</li>
                    <li>See a visualization of your social network</li>
                </ul>
                
                <p>
                    To get started, click below to register. If you have already registered, you can log in.
                </p>
                
                <div class="content-buttons">
                    <button onclick="window.location.href='register.php'">Register</button>
                    <button onclick="window.location.href='login.php'">Login</button>
                </div>
            </div>
        </main>

        <!-- PIE DE PÁGINA -->
        <footer class="footer">
            <p>
                <a href="#">about</a> • 
                <a href="#">contact</a> • 
                <a href="#">faq</a> • 
                <a href="#">terms</a> • 
                <a href="#">privacy</a>
            </p>
            <p>a Creador/a production</p>
            <p>Thefacebook &copy; 2004</p>
        </footer>
    </div>
</body>
</html>
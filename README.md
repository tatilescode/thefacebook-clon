TheFacebook Clon

Este proyecto es un clon simplificado de The Facebook (versión antigua) desarrollado con PHP, MySQL, HTML, CSS y JavaScript, implementado localmente utilizando XAMPP.

Funcionalidades principales

Autenticación

* Registro de usuarios
* Inicio de sesión con verificación en base de datos
* Cierre de sesión seguro con `session_destroy()`

Perfiles de usuario

* Visualización de información básica del usuario
* Página de perfil personalizada

Página principal (Home)

* Bienvenida al usuario con su nombre
* Vista después de iniciar sesión correctamente

Formularios adicionales

* Página de contacto

Estructura del proyecto

/ thefacebook-clon
│
├── css/
│   └── style.css
├── js/
├── uploads/
├── config.php
├── index.php
├── login.php
├── logout.php
├── register.php
├── home.php
├── profile.php
├── contact.php
└── .htaccess

|Configuración del proyecto
Requisitos

* PHP 8+
* MySQL
* Servidor local como **XAMPP** o **WAMP**
* Extensión `mysqli` habilitada

Configurar la base de datos

Crea una base de datos llamada por ejemplo: `thefacebook`.
Luego importa tu archivo SQL o crea una tabla como:

sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Editar `config.php`

Asegúrate de que tu configuración sea correcta:

php
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'thefacebook';
$conn = new mysqli($host, $user, $pass, $db);
?>

Cómo ejecutar el proyecto

1. Copia la carpeta **thefacebook-clon** dentro de:


/xampp/htdocs/

2. Inicia **Apache** y **MySQL** desde XAMPP.
3. Abre en el navegador:


http://localhost/thefacebook-clon/

 Problemas comunes y soluciones

session_start(): Ignoring session_start()

Ocurre cuando ya existe una sesión iniciada.

* Solución: elimina `session_start()` duplicados.

Error 500 en InfinityFree

* Verifica que no tengas funciones bloqueadas.
* Revísalo en tu archivo `.htaccess`.

Próximas mejoras

* Subir imágenes de perfil
* Sistema de publicaciones
* Likes y comentarios
* Chat en tiempo real

Sobre la desarrolladora

Soy Tatiana López, desarrolladora Full Stack. Este proyecto forma parte de mi crecimiento profesional y de mi interés por construir aplicaciones web funcionales utilizando PHP, JavaScript, MySQL y tecnologías relacionadas. Me enfoco en crear soluciones claras, organizadas y fáciles de mantener, aplicando buenas prácticas tanto en el frontend como en el backend.

Licencia

Este proyecto es únicamente educativo y sin fines comerciales.
Puedes usarlo, modificarlo y distribuirlo libremente, siempre y cuando se mantenga el crédito a la autora original.

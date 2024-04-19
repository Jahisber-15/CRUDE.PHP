<?php
// Configuración de la conexión a la base de datos
$servername = "127.0.0.1"; // Nombre del servidor (localhost)
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos (generalmente está vacía en entornos locales)
$dbname = "formulario_contacto"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

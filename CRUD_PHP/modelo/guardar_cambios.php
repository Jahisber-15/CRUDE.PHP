<?php
// Verificar si se recibieron datos del formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir la configuración de la base de datos u otros archivos necesarios
    include('configuracion_bd.php'); // Asegúrate de cambiar esto según el nombre de tu archivo de configuración
    
    // Recuperar los datos del formulario de edición
    $id_contacto = $_POST["id_contacto"];
    $nuevo_nombre = $_POST["nuevo_nombre"];
    $nuevo_apellido = $_POST["nuevo_apellido"];
    // Agregar más campos según sea necesario
    
    // Actualizar el registro en la base de datos con los nuevos valores
    $sql_actualizar = "UPDATE contactos SET nombre='$nuevo_nombre', apellido='$nuevo_apellido' WHERE id=$id_contacto";
    if ($conn->query($sql_actualizar) === TRUE) {
        // Redirigir al usuario de regreso a la página de inicio u otra página
        header("Location: index.php");
        exit(); // Salir del script después de redirigir
    } else {
        echo "Error al guardar los cambios: " . $conn->error;
    }
} else {
    // Si se intenta acceder directamente a este archivo sin enviar datos del formulario, redirigir a la página de inicio u otra página
    header("Location: index.php");
    exit(); // Salir del script después de redirigir
}
?>

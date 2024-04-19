<?php
// Incluir el archivo de configuración de la base de datos
include('configuracion_bd.php');

// Verificar si se proporciona un ID de contacto en la URL
if (!isset($_GET['id'])) {
    // Si no se proporciona un ID, redirigir a la página de inicio u otra página
    header("Location: index.php");
    exit(); // Salir del script para evitar que se ejecute el resto del código
}

// Recuperar el ID del contacto de la URL
$id_contacto_editar = $_GET['id'];

// Consultar la base de datos para obtener los detalles del contacto a editar
$sql_editar = "SELECT * FROM contactos WHERE id = $id_contacto_editar";
$result_editar = $conn->query($sql_editar);

if ($result_editar->num_rows > 0) {
    // Mostrar el formulario de edición con los detalles del contacto
    $row_editar = $result_editar->fetch_assoc();
} else {
    echo "No se encontró el contacto a editar.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
    <style>
        /* Estilos para el formulario de edición */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form action="guardar_cambios.php" method="post">
    <input type="hidden" name="id_contacto" value="<?php echo $id_contacto_editar; ?>">
    <div>
        <label for="nuevo_nombre">Nombre:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $row_editar["nombre"]; ?>" required>
    </div>
    <div>
        <label for="nuevo_apellido">Apellido:</label>
        <input type="text" id="nuevo_apellido" name="nuevo_apellido" value="<?php echo $row_editar["apellido"]; ?>" required>
    </div>
    <div>
        <label for="nuevo_dni">DNI:</label>
        <input type="text" id="nuevo_dni" name="nuevo_dni" value="<?php echo $row_editar["dni"]; ?>">
    </div>
    <div>
        <label for="nueva_fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="nueva_fecha_nacimiento" name="nueva_fecha_nacimiento" value="<?php echo $row_editar["fecha_nacimiento"]; ?>">
    </div>
    <div>
        <label for="nuevo_email">Correo Electrónico:</label>
        <input type="email" id="nuevo_email" name="nuevo_email" value="<?php echo $row_editar["email"]; ?>">
    </div>
    <!-- Agregar más campos según sea necesario -->
    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
<?php
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

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $email = $_POST["email"];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO contactos (nombre, apellido, dni, fecha_nacimiento, email)
    VALUES ('$nombre', '$apellido', '$dni', '$fecha_nacimiento', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos insertados correctamente";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
}
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            overflow-x: hidden; /* Ocultar la barra de desplazamiento horizontal */
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .formulario-container,
        .tabla-container {
            flex: 1;
            padding: 20px;
            box-sizing: border-box; /* Incluye el padding en el ancho */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .formulario {
            padding: 20px;
            text-align: left; /* Alinear el texto a la izquierda */
            border: none; /* Quitar el borde */
        }

        h1 {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            max-width: 300px; /* Ancho máximo para los campos de entrada */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            display: block;
            padding: 10px 20px; /* Ajustar el relleno del botón */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px; /* Espacio entre los campos de entrada y el botón */
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Estilos adicionales para la tabla */
        .tabla {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .tabla-container {
            margin-top: 40px; /* Ajustar margen superior */
            margin-bottom: 40px; /* Ajustar margen inferior */
            text-align: center; /* Centrar horizontalmente */
        }

        .acciones {
            display: flex;
            gap: 10px; /* Espacio entre iconos */
        }

        .acciones a {
            text-decoration: none;
        }

        .acciones img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="formulario-container">
        <div class="formulario">
            <h1>Formulario de Contacto</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div>
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" pattern="[0-9]{8}" title="El DNI debe contener 8 dígitos" required>
                </div>
                <div>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div>
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>

        <!-- Mostrar la tabla de contactos -->
        <div class="tabla-container">
    <h2>Registros de Contactos</h2>
    <div class="tabla">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar la base de datos para obtener los registros de contactos
                $query = "SELECT * FROM contactos";
                $result = $conn->query($query);

                // Iterar sobre los resultados y mostrar cada registro en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["apellido"] . "</td>";
                        echo "<td>" . $row["dni"] . "</td>";
                        echo "<td>" . $row["fecha_nacimiento"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo '<td class="acciones">';
                        echo '<a href="editar_contacto.php?id=' . $row["id"] . '"><img src="https://cdn-icons-png.flaticon.com/512/6324/6324826.png" alt="Editar"></a>';
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?eliminar=' . $row["id"] . '"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAb1BMVEX///8AAABhYWGoqKiysrKLi4s6Ojr8/PzR0dGQkJAeHh7ExMQqKiqAgIBFRUXb29vw8PBpaWkTExNwcHC4uLiWlpZPT08JCQnj4+MbGxuhoaGBgYHu7u6/v794eHgvLy84ODhaWlokJCRKSkpVVVW0Ms8sAAAEQElEQVR4nO2d63aqMBBG0aJQ8a4o3lDR93/GYy2Jcs4J0TBhpl3f/tus6WwTkhhiEgTURHG6WA3XnXeZn875R0aeDjmH2dtqFY6jCbdCLcm4md+dhdyK3PcJ/L4YcZsYSIj8boz33DL/I6UTvHU7MbfOv2wpBW+IexgPxIKd+ZRbqcrkr/yK/vhdTptqiBW3U5XKKLFL9g4VEE2zsDKYbunTdOe5jX42aV6T81MkSe30kdW66ZTkqcfakeRGQqiT2jQfyJYSK/Gqc6KYVD4G1pAgGgl7nVJKEk93W2eScATodrWJSOLp6d9aSjPNVUY9ooCFCihl7talTminAh6IAjZlpRKiCqibvZBBPzpSG+oHUcgXxem8zGdAFVHPcmdUEZuhDQuqiDBsGxi+DwzbBobvA8O2geH7iDX8vbM2lc+aKqI27FJFbEY0KSFbiKePCMBPJ8qSD5GEMcmL1CzXixQCuWwbL2D2uB1sbJJGftGFW+AFGi20U2we8U+DNUfxTbTEeSU64878Vcauhrk9thAce5uosIcWQu5m+Pf+CsGc3EbFpT2yGNwmN9S7nHziZhjaA4vBzTDmTvt1CrfX4VN7ZCm4rnacuRN/GddtKYRbYv0yd/4KtbIHF8GHq+BPeRKbrDn+iGnNqtHX/GzInb8Vxznpg1D2/PtCsVcw3uZdkcx2IRbFAQAAAGqWoRz8bACXNEX183Maqt/AUkD1qwAY8gFDGMKQHxjCEIb8wBCGMOSHzfCYxmHtQVHdME5Ptaknh5Fgw+79LVDNQS7Lr79HC+Pfh/cdB5n9oDAmw3lZ0HjakMrL+LKnfA1h3yPBZKg2ekamAmpPiGmnzlX9q42hALfhUpWcGwqoV5mmDQI6b3M75jXUOwQNa1YDZWhqhZ8qwM5Q4PcYWrtTGMIQhjCEIQxhCEMYwhCGMIQhDGEIQxjCEIYwhCEMYQhDGMIQhjCEIQxhCEMYwhCGMIQhDGEIQxjCEIYwhCEMYQhDGMIQhjCEIQxhCEMYwhCGMIQhDGEIQxjCEIYwhCEMYQhDGMIQhjCEIQxhCEMYwhCGMIQhDGEIQxg6G0o97VrfcG4qoAxNJ+/rvGtvH2A0VFVgvM5b3d5rOnV+bPuIuA070++CxjPjyyvCjefuq3YeijUc3yvJeDVCWcuZ+VL69V2x5voIbsNOZ7Yd1RY75dtZ7e0V1/TT/AFIMGwLGMIQhvzA0I0xt9YTqT1dB14Zp9piaU/XAet0uEUSe7oOvHJbWFv4uZfbPh9uj709XQcybq0HRy+CQTDgFtP46UolPYh+HsMgmHCLKYaeBIOgy61W4mc0/MJ+L2ErHCN7qq5Yb+1rBX9VGASRhO409ygoorPx1818wz6xGWT2JJvxwlKfT45+5msVYtMto21w9diNPoh6XH6Fz160wiS330lMTz+dtiV4I0p6s357zbW4LLauPcwfoh+eZNieduAAAAAASUVORK5CYII=" alt="Borrar"></a>';
                        echo '</td>';
                        echo "</tr>";
                    
                        // Manejo de la eliminación
                        if (isset($_GET['eliminar']) && $_GET['eliminar'] == $row["id"]) {
                            $id_eliminar = $_GET['eliminar'];
                            // Realizar la operación de eliminación en la base de datos utilizando el ID recibido
                            $sql_eliminar = "DELETE FROM contactos WHERE id = $id_eliminar";
                            if ($conn->query($sql_eliminar) === TRUE) {
                                // Éxito en la eliminación
                                echo '<script>window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
                                exit; // Salir del script para evitar que se muestre la tabla nuevamente antes de redireccionar
                            } else {
                                // Error al eliminar
                                echo "Error al eliminar el contacto: " . $conn->error;
                            }
                        }
                    }
                
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
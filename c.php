<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cf";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";
$alerta_tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Preparar la sentencia SQL para prevenir inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO clientes (NombreCliente, Correo, Telefono, Direccion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $direccion);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        $mensaje = "¡Cliente insertado correctamente! 🎉";
        $alerta_tipo = "success";
    } else {
        $mensaje = "Error al insertar el cliente: " . $stmt->error;
        $alerta_tipo = "error";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Inserción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .return-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .return-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Resultado de la Operación</h2>
    
    <?php if ($mensaje): ?>
        <div class="alert <?php echo $alerta_tipo; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <a href="c.html" class="return-link">Volver a Añadir Cliente</a>
</div>

</body>
</html>

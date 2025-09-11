<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "cf";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = $alerta_tipo = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validamos el ID recibido como número entero
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    if ($id_cliente === false) {
        $mensaje    = "El ID del cliente es inválido.";
        $alerta_tipo = "error";
    } else {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE IdCliente = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id_cliente);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensaje    = "¡Cliente con ID $id_cliente eliminado correctamente! 🎉";
                    $alerta_tipo = "success";
                } else {
                    $mensaje    = "No se encontró un cliente con el ID $id_cliente.";
                    $alerta_tipo = "error";
                }
            } else {
                $mensaje    = "Error al ejecutar la eliminación: " . $stmt->error;
                $alerta_tipo = "error";
            }
            $stmt->close();
        } else {
            $mensaje    = "Error en la preparación de la consulta: " . $conn->error;
            $alerta_tipo = "error";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Eliminación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .return-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .return-link:hover {
            background: #0056b3;
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
    <a href="d.html" class="return-link">Volver
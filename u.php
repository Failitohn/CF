<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cf";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Lógica para procesar la actualización del producto (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // **Validaciones del lado del servidor**
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    $nombre = filter_input(INPUT_POST, 'nombre_producto', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $fecha_ingreso = filter_input(INPUT_POST, 'fecha_ingreso', FILTER_SANITIZE_STRING);
    $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_STRING);

    if (empty($id_producto) || empty($nombre) || empty($precio) || empty($categoria) || empty($stock) || empty($fecha_ingreso) || empty($fecha_vencimiento)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("UPDATE Productos SET NombreProducto = ?, Precio = ?, Categoria = ?, Stock = ?, FechaIngreso = ?, FechaVencimiento = ? WHERE IdProducto = ?");
    
    // Bind de parámetros seguro para evitar inyección SQL
    $stmt->bind_param("sdsissi", $nombre, $precio, $categoria, $stock, $fecha_ingreso, $fecha_vencimiento, $id_producto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '¡Producto actualizado correctamente! 🎉']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto: ' . $stmt->error]);
    }
    $stmt->close();
    
} else if ($_SERVER["REQUEST_METHOD"] == "GET") { // Lógica para buscar el producto (GET)
    // **Validación de ID del lado del servidor**
    $id_producto = filter_input(INPUT_GET, 'id_producto', FILTER_VALIDATE_INT);
    
    if (!$id_producto || $id_producto <= 0) {
        echo json_encode(['error' => 'ID de producto inválido.']);
        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM Productos WHERE IdProducto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo json_encode(['producto' => $producto]);
    } else {
        echo json_encode(['error' => 'No se encontró ningún producto con el ID proporcionado.']);
    }
    $stmt->close();
}

$conn->close();
?>

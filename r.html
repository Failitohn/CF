<?php
header('Content-Type: application/json; charset=utf-8');

// Configuración de conexión a MySQL
$host = "localhost";
$user = "root";     // tu usuario MySQL
$pass = "";         // tu contraseña
$db   = "inventario"; // tu base de datos

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

// Parámetros recibidos
$tipo  = $_GET['tipo'] ?? '';
$q     = $_GET['q'] ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

$resultados = [];

if ($tipo === 'productos') {
    $sql = "SELECT IdProducto, NombreProducto, Precio, Categoria, FechaIngreso, FechaVencimiento 
            FROM productos WHERE 1=1";
    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " AND (NombreProducto LIKE '%$q%' OR Categoria LIKE '%$q%')";
    }
    if ($desde !== '') $sql .= " AND FechaIngreso >= '$desde'";
    if ($hasta !== '') $sql .= " AND FechaIngreso <= '$hasta'";
}
elseif ($tipo === 'clientes') {
    $sql = "SELECT IdCliente, NombreCliente, Correo, Telefono, Direccion 
            FROM clientes WHERE 1=1";
    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " AND (NombreCliente LIKE '%$q%' OR Correo LIKE '%$q%' OR Telefono LIKE '%$q%')";
    }
}
elseif ($tipo === 'pedidos') {
    $sql = "SELECT IdPedido, Cliente, FechaPedido, EstadoPedido, Total 
            FROM pedidos WHERE 1=1";
    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " AND (Cliente LIKE '%$q%' OR IdPedido LIKE '%$q%')";
    }
    if ($desde !== '') $sql .= " AND FechaPedido >= '$desde'";
    if ($hasta !== '') $sql .= " AND FechaPedido <= '$hasta'";
}
else {
    echo json_encode(["error" => "Tipo de búsqueda no válido"]);
    exit;
}

$res = $conn->query($sql);
if (!$res) {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    exit;
}

while ($fila = $res->fetch_assoc()) {
    $resultados[] = $fila;
}

echo json_encode(["resultados" => $resultados], JSON_UNESCAPED_UNICODE);
$conn->close();

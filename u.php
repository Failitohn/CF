<?php

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db   = "CF";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

// Parámetros recibidos
$tipo  = $_GET['tipo']  ?? '';
$q     = $_GET['q']     ?? '';
$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

$q     = $conn->real_escape_string($q);
$desde = $conn->real_escape_string($desde);
$hasta = $conn->real_escape_string($hasta);

$sql = "";
switch ($tipo) {
    case "productos":
        $sql = "SELECT IdProducto, NombreProducto, Precio, Categoria, FechaIngreso, FechaVencimiento 
                FROM Productos 
                WHERE 1=1";
        // Nuevo código para buscar por ID
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $id = $conn->real_escape_string($_GET['id']);
            $sql .= " AND IdProducto = '$id'";
        } else if ($q != "") {
            $sql .= " AND (NombreProducto LIKE '%$q%' OR Categoria LIKE '%$q%')";
        }
        if ($desde != "") {
            $sql .= " AND FechaIngreso >= '$desde'";
        }
        if ($hasta != "") {
            $sql .= " AND FechaIngreso <= '$hasta'";
        }
        break;

    case "clientes":
        $sql = "SELECT IdCliente, NombreCliente, Correo, Telefono, Direccion 
                FROM Clientes 
                WHERE 1=1";
        if ($q != "") {
            $sql .= " AND (NombreCliente LIKE '%$q%' OR Correo LIKE '%$q%' OR Telefono LIKE '%$q%')";
        }
        break;

    case "pedidos":
        $sql = "SELECT p.IdPedido, c.NombreCliente AS Cliente, p.FechaPedido, p.EstadoPedido, p.Total
                FROM Pedidos p
                INNER JOIN Clientes c ON c.IdCliente = p.IdCliente
                WHERE 1=1";
        if ($q != "") {
            $sql .= " AND (c.NombreCliente LIKE '%$q%' OR p.IdPedido LIKE '%$q%')";
        }
        if ($desde != "") {
            $sql .= " AND p.FechaPedido >= '$desde'";
        }
        if ($hasta != "") {
            $sql .= " AND p.FechaPedido <= '$hasta'";
        }
        break;

    default:
        echo json_encode(["error" => "Tipo de búsqueda inválido"]);
        exit;
}

// Ejecutar consulta
$result = $conn->query($sql);
if (!$result) {
    echo json_encode(["error" => "Error en consulta: " . $conn->error]);
    exit;
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode([
    "resultados" => $rows
]);

$conn->close();
?>

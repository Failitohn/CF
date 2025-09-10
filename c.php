<?php
include("conexion.php");

// Verificamos si vienen datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    // Consulta para insertar
    $sql = "INSERT INTO usuarios (nombre, apellido, correo) 
            VALUES ('$nombre', '$apellido', '$correo')";

    if (mysqli_query($conexion, $sql)) {
        echo "✅ Registro agregado correctamente.";
        echo "<br><a href='crear.php'>Volver</a>";
    } else {
        echo "❌ Error: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>

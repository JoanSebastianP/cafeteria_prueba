<?php
require 'includes/config.php';
// Verificar si se ha proporcionado el ID del producto a eliminar
if (!isset($_GET['id'])) {
    echo "<p>No se ha proporcionado un ID de producto válido.</p>";
    echo "<p><a href='index.php'>Volver</a></p>";
    exit;
}

// Obtener el ID del producto
$id = $_GET['id'];

// Incluir el archivo de configuración de la base de datos

// Eliminar el producto de la base de datos
$sql = "DELETE FROM productos WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "<p>Producto eliminado exitosamente.</p>";
} else {
    echo "Error al eliminar el producto: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();

echo "<p><a href='index.php'>Volver</a></p>";

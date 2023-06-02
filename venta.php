<?php
require 'includes/config.php';


// Obtener y mostrar la lista de productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Listado de Productos</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['precio'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No hay productos registrados.</p>";
}

// Verificar si se ha proporcionado el ID del producto y la cantidad vendida como parámetros
if (isset($_POST['id']) && isset($_POST['cantidad'])) {
    // Obtener el ID del producto y la cantidad vendida
    $id = $_POST['id'];
    $cantidadVendida = $_POST['cantidad'];

    // Obtener la información del producto
    $sql = "SELECT * FROM productos WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stockActual = $row['stock'];

        // Verificar si hay suficiente stock para la venta
        if ($stockActual >= $cantidadVendida) {
            // Calcular el nuevo stock después de la venta
            $nuevoStock = $stockActual - $cantidadVendida;

            // Actualizar el campo de stock del producto
            $updateSql = "UPDATE productos SET stock='$nuevoStock' WHERE id='$id'";
            if ($conn->query($updateSql) === TRUE) {
                // Registrar la venta en una tabla de ventas
                $fechaVenta = date('Y-m-d');
                $insertSql = "INSERT INTO ventas (producto_id, cantidad, fecha_venta) VALUES ('$id', '$cantidadVendida', '$fechaVenta')";
                if ($conn->query($insertSql) === TRUE) {
                    echo "<p>Venta realizada exitosamente.</p>";
                } else {
                    echo "Error al registrar la venta: " . $conn->error;
                }
            } else {
                echo "Error al actualizar el stock del producto: " . $conn->error;
            }
        } else {
            echo "<p>No hay suficiente stock disponible para realizar la venta.</p>";
        }
    } else {
        echo "<p>No se ha encontrado un producto con el ID proporcionado.</p>";
    }



    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Realizar Venta</title>
</head>

<body>
    <h1>Realizar Venta</h1>

    <form method="POST" action="">
        <label>ID del Producto:</label>
        <input type="text" name="id" required><br>

        <label>Cantidad Vendida:</label>
        <input type="number" name="cantidad" required><br>

        <input type="submit" name="submit" value="Realizar Venta">
    </form>


    <a href="inicio.php"><button>Volver al inicio</button></a>


</body>

</html>
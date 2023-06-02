<?php
require 'includes/config.php';
// Verificar si se ha proporcionado el ID del producto
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Incluir el archivo de configuración de la base de datos

    // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['submit'])) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $referencia = $_POST['referencia'];
        $precio = $_POST['precio'];
        $peso = $_POST['peso'];
        $categoria = $_POST['categoria'];
        $stock = $_POST['stock'];

        // Actualizar el producto en la base de datos
        $updateSql = "UPDATE productos SET nombre='$nombre', referencia='$referencia', precio='$precio', peso='$peso', categoria='$categoria', stock='$stock' WHERE id='$producto_id'";
        if ($conn->query($updateSql) === TRUE) {
            echo "Producto actualizado correctamente.";
        } else {
            echo "Error al actualizar el producto: " . $conn->error;
        }
    }

    // Obtener los datos actuales del producto de la base de datos
    $sql = "SELECT * FROM productos WHERE id='$producto_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $referencia = $row['referencia'];
        $precio = $row['precio'];
        $peso = $row['peso'];
        $categoria = $row['categoria'];
        $stock = $row['stock'];
    } else {
        echo "No se encontró un producto con el ID proporcionado.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "No se ha proporcionado el ID del producto.";
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Producto</title>
</head>

<body>
    <h1>Editar Producto</h1>

    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br>

        <label>Referencia:</label>
        <input type="text" name="referencia" value="<?php echo $referencia; ?>" required><br>

        <label>Precio:</label>
        <input type="number" name="precio" value="<?php echo $precio; ?>" required><br>

        <label>Peso:</label>
        <input type="number" name="peso" value="<?php echo $peso; ?>" required><br>

        <label>Categoría:</label>
        <input type="text" name="categoria" value="<?php echo $categoria; ?>" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo $stock; ?>" required><br>

        <input type="submit" name="submit" value="Guardar Cambios">
    </form>

    <p><a href="index.php">Volver</a></p>

</body>

</html>
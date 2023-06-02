<!DOCTYPE html>
<html>

<head>
    <title>Gestión de Inventario</title>
</head>

<body>
    <h1>Gestión de Inventario</h1>

    <?php
    // Incluir el archivo de configuración de la base de datos
    require 'includes/config.php';

    // Procesar las acciones del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Acción para crear un nuevo producto
        if (isset($_POST['create'])) {
            $nombre = $_POST['nombre'];
            $referencia = $_POST['referencia'];
            $precio = $_POST['precio'];
            $peso = $_POST['peso'];
            $categoria = $_POST['categoria'];
            $stock = $_POST['stock'];
            $fechaCreacion = $_POST['fecha_creacion'];

            // Insertar el nuevo producto en la base de datos
            $sql = "INSERT INTO productos (nombre, referencia, precio, peso, categoria, stock, fecha_creacion)
                    VALUES ('$nombre', '$referencia', '$precio', '$peso', '$categoria', '$stock', '$fechaCreacion')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Producto creado exitosamente.</p>";
            } else {
                echo "Error al crear el producto: " . $conn->error;
            }
        }

        // Acción para editar un producto
        if (isset($_POST['edit'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $referencia = $_POST['referencia'];
            $precio = $_POST['precio'];
            $peso = $_POST['peso'];
            $categoria = $_POST['categoria'];
            $stock = $_POST['stock'];

            // Actualizar el producto en la base de datos
            $sql = "UPDATE productos SET nombre='$nombre', referencia='$referencia', precio='$precio', peso='$peso',
                    categoria='$categoria', stock='$stock' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Producto actualizado exitosamente.</p>";
            } else {
                echo "Error al actualizar el producto: " . $conn->error;
            }
        }

        // Acción para eliminar un producto
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            // Eliminar el producto de la base de datos
            $sql = "DELETE FROM productos WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Producto eliminado exitosamente.</p>";
            } else {
                echo "Error al eliminar el producto: " . $conn->error;
            }
        }
    }

    // Obtener y mostrar la lista de productos
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Listado de Productos</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Referencia</th><th>Precio</th><th>Peso</th><th>Categoría</th><th>Stock</th><th>Fecha de Creación</th><th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['referencia'] . "</td>";
            echo "<td>" . $row['precio'] . "</td>";
            echo "<td>" . $row['peso'] . "</td>";
            echo "<td>" . $row['categoria'] . "</td>";
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . $row['fecha_creacion'] . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Editar</a> | <a href='delete.php?id=" . $row['id'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hay productos registrados.</p>";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>

    <h2>Crear Producto</h2>
    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label>Referencia:</label>
        <input type="text" name="referencia" required><br>

        <label>Precio:</label>
        <input type="number" name="precio" required><br>

        <label>Peso:</label>
        <input type="number" name="peso" required><br>

        <label>Categoría:</label>
        <input type="text" name="categoria" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" required><br>

        <label>Fecha de Creación:</label>
        <input type="date" name="fecha_creacion" required><br>

        <input type="submit" name="create" value="Crear">


    </form>

    <a href="inicio.php"><button>Volver al inicio</button></a>


</body>

</html>
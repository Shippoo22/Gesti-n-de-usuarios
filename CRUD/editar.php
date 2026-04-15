<?php
include("conexion.php");

// Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ ID inválido.");
}

$id = (int) $_GET['id'];

// Obtener datos del usuario
$query = "SELECT * FROM usuarios WHERE id = $1";
$resultado = pg_query_params($conexion, $query, array($id));

if (!$resultado) {
    die("❌ Error al obtener el usuario: " . pg_last_error($conexion));
}

$fila = pg_fetch_assoc($resultado);
if (!$fila) {
    die("⚠️ Usuario no encontrado.");
}

// Actualizar registro si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    // Validar campos vacíos
    if ($nombre === "" || $correo === "" || $telefono === "") {
        echo "<div class='alert alert-danger text-center'>⚠️ Todos los campos son obligatorios.</div>";
    } else {
        $updateQuery = "UPDATE usuarios SET nombre = $1, correo = $2, telefono = $3 WHERE id = $4";
        $update = pg_query_params($conexion, $updateQuery, array($nombre, $correo, $telefono, $id));

        if ($update) {
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger text-center'>❌ Error al actualizar: " . pg_last_error($conexion) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
  <div class="container mt-5">
    <h2 class="text-info text-center mb-4">Editar Usuario</h2>

    <form action="" method="POST" class="card p-4 bg-secondary">
      <input type="text" name="nombre" class="form-control mb-3" value="<?php echo htmlspecialchars($fila['nombre']); ?>" required>
      <input type="email" name="correo" class="form-control mb-3" value="<?php echo htmlspecialchars($fila['correo']); ?>" required>
      <input type="text" name="telefono" class="form-control mb-3" value="<?php echo htmlspecialchars($fila['telefono']); ?>" required>
      <button type="submit" name="actualizar" class="btn btn-warning">Actualizar</button>
      <a href="usuarios.php" class="btn btn-light">Cancelar</a>
    </form>
  </div>
</body>
</html>

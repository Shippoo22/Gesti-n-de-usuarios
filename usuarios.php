<?php 
include("conexion.php");
session_start();  

// 🔒 Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Tu archivo CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-dark text-light">

<div class="container mt-5 fade-in">
    <div class="text-center mb-4">
      <h1 class="text-info"><i class="bi bi-people-fill"></i> Gestión de Usuarios</h1>
      <p class="text-secondary">Administra tus usuarios fácilmente con estilo</p>
    </div>

    <div class="card p-4 bg-secondary bg-opacity-25 border-light shadow-lg">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-light m-0"><i class="bi bi-list-ul"></i> Lista de usuarios</h4>

        <div>
          <!-- 🔹 Botón Agregar Usuario -->
          <a href="agregar.php" class="btn btn-success me-2">
            <i class="bi bi-person-plus"></i> Agregar Usuario
          </a>

          <!-- 🔹 Botón Regresar -->
          <a href="index.php" class="btn btn-outline-info">
            <i class="bi bi-arrow-left-circle"></i> Regresar al Inicio
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>Foto</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
<?php
$resultado = pg_query($conexion, "SELECT * FROM usuarios ORDER BY id ASC");

if (!$resultado) {
    echo "<tr><td colspan='6'>❌ Error en la consulta: " . pg_last_error($conexion) . "</td></tr>";
} else {
    while ($fila = pg_fetch_assoc($resultado)) {

    $foto = !empty($fila['avatar']) 
    ? $fila['avatar'] 
    : "api/avatar.php?name=" . urlencode($fila['nombre']);
        echo "
        <tr>
            <td>{$fila['id']}</td>

            <!-- FOTO DEL USUARIO -->
            <td>
                <img src='{$foto}' class='user-photo'>
            </td>

            <td>{$fila['nombre']}</td>
            <td>{$fila['correo']}</td>
            <td>{$fila['telefono']}</td>

            <td>
              <a href='editar.php?id={$fila['id']}' 
                 class='btn btn-outline-info btn-sm me-2'>
                <i class='bi bi-pencil-square'></i> Editar
              </a>

              <a href='eliminar.php?id={$fila['id']}' 
                 class='btn btn-danger btn-sm'
                 onclick='return confirmar()'>
                <i class='bi bi-trash3'></i> Eliminar
              </a>
            </td>
        </tr>";
    }
}
?>
          </tbody>
        </table>
      </div>
    </div>
</div>

<script>
function confirmar() {
  return confirm("¿Seguro que deseas eliminar este usuario?");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

include_once "conexion.php";

if (!$conexion) {
    die("❌ Error: " . pg_last_error());
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {

    $nombre = trim($_POST['nombre'] ?? "");
    $correo = trim($_POST['correo'] ?? "");
    $telefono = trim($_POST['telefono'] ?? "");

    if ($nombre === "" || $correo === "" || $telefono === "") {
        $error = "⚠️ Todos los campos son obligatorios.";
    } else {

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $rutaFisica = __DIR__ . "/avatars/" . $filename;
        $rutaBD = "avatars/" . $filename;

        move_uploaded_file($tmp, $rutaFisica);

        $avatar = $rutaBD;

} else {

    // API AVATAR
    $avatar_api = "http://localhost/CRUD/API/avatar.php";

    $data = ['name' => $nombre];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($avatar_api, false, $context);

    $response = json_decode($result, true);

    $avatar = $response['avatar']; // ej: avatars/user_x.png
}
        // 🔥 GUARDAR EN BD
        $query = "INSERT INTO usuarios (nombre, correo, telefono, avatar) VALUES ($1, $2, $3, $4)";
        $resultado = pg_query_params($conexion, $query, array($nombre, $correo, $telefono, $avatar));

        if ($resultado) {
            header("Location: usuarios.php");
            exit;
        } else {
            $error = "❌ Error: " . pg_last_error($conexion);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agregar Usuario</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container mt-5 fade-in">
    <div class="card p-4 text-center">
      <h2 class="text-info mb-4"><i class="bi bi-person-plus"></i> Agregar Usuario</h2>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <div class="user-image mb-3">
        <img id="avatarPreview" src="http://localhost/CRUD/api/avatar.php?name=User" class="avatar-glow">
      </div>

      <form action="" method="POST" enctype="multipart/form-data" class="text-start">
       <div class="mb-3">
    <label class="form-label text-info">Foto de perfil (opcional)</label>
    <input type="file" name="foto" class="form-control" accept="image/*">
  </div>
    <div class="mb-3">
      <label class="form-label text-info">Nombre</label>
    <input type="text" name="nombre" class="form-control" required>
</div>
        <div class="mb-3">
          <label class="form-label text-info"><i class="bi bi-envelope-fill"></i> Correo</label>
          <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label text-info"><i class="bi bi-telephone-fill"></i> Teléfono</label>
          <input type="text" name="telefono" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="usuarios.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Regresar
          </a>
          <button type="submit" name="guardar" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
const fileInput = document.querySelector('input[name="foto"]');
const avatarImg = document.getElementById('avatarPreview');

fileInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            avatarImg.src = e.target.result;
        }

        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>

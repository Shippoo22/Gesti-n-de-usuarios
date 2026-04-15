<?php
session_start();

// Redirigir solo si el usuario abrió login.php manualmente
// Evitar que un usuario logueado entre al login
// Evitar que un usuario logueado entre al login.php
if (!empty($_SESSION['usuario'])) {
    header("Location: usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #0d1117;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .login-box {
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(8px);
            width: 350px;
            text-align: center;
        }
        .login-box input {
            background-color: #ffffffd0;
        }
    </style>
</head>
<body>

<div class="login-box shadow-lg">
    <h2 class="mb-4"><i class="bi bi-person-circle"></i> Iniciar Sesión</h2>

    <form action="validar.php" method="POST" autocomplete="off">
        <input type="text" name="usuario" class="form-control mb-3" placeholder="Usuario" required>

        <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>

        <button type="submit" class="btn btn-info w-100">Ingresar</button>
    </form>

    <hr class="text-white">

    <a href="registro.php" class="text-info">¿No tienes cuenta? <strong>Registrarse</strong></a>
</div>

</body>
</html>

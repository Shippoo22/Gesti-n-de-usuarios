<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos
    $usuario = trim($_POST['usuario']);
    $pass = trim($_POST['password']);

    // Validar campos
    if ($usuario === "" || $pass === "") {
        die("❌ Todos los campos son obligatorios.");
    }

    // Verificar si ya existe
    $check = pg_query_params($conexion, "SELECT usuario FROM usuarios_login WHERE usuario = $1", array($usuario));

    if (pg_num_rows($check) > 0) {
        die("⚠ El usuario ya existe. <a href='registro.php'>Intentar nuevamente</a>");
    }

    // Hashear contraseña
    $passHash = password_hash($pass, PASSWORD_BCRYPT);

    // Insertar usuario
    $insert = pg_query_params($conexion, 
        "INSERT INTO usuarios_login (usuario, password) VALUES ($1, $2)",
        array($usuario, $passHash)
    );

    if ($insert) {
        echo "<script>alert('✔ Registro exitoso'); window.location='login.php';</script>";
    } else {
        echo "❌ Error al registrar: " . pg_last_error($conexion);
    }
}
?>

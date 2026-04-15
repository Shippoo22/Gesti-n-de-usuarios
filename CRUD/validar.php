<?php
session_start();
include "conexion.php";

if (!isset($_POST['usuario'], $_POST['password'])) {
    header("Location: login.php");
    exit();
}

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

// Buscar usuario en DB
$sql = "SELECT usuario, password FROM usuarios_login WHERE usuario = $1";
$result = pg_query_params($conexion, $sql, array($usuario));

if ($row = pg_fetch_assoc($result)) {
    
    // Validar contraseña
    if (password_verify($password, $row['password'])) {
        
        $_SESSION['usuario'] = $row['usuario']; // IMPORTANTE!
        header("Location: usuarios.php");
        exit();

    } else {
        echo "<script>alert('❌ Contraseña incorrecta'); window.location='login.php';</script>";
        exit();
    }

} else {
    echo "<script>alert('❌ Usuario no encontrado'); window.location='login.php';</script>";
    exit();
}
?>

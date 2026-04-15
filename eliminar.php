<?php
include("conexion.php");

// Validar que haya un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ ID inválido.");
}

$id = (int) $_GET['id'];

// Eliminar con consulta preparada
$query = "DELETE FROM usuarios WHERE id = $1";
$resultado = pg_query_params($conexion, $query, array($id));

if ($resultado) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "❌ Error al eliminar: " . pg_last_error($conexion);
}
?>

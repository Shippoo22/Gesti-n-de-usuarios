<?php
// conexion.php – Conexión estructurada y segura a PostgreSQL

$host = 'localhost';
$port = '5432';
$dbname = 'crud';
$user = 'postgres';
$password = 'Chivasrojasverdes3';

// Cadena de conexión
$cadena = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Crear conexión
$conexion = pg_connect($cadena);

// Validar conexión
if (!$conexion) {
    die("❌ Error al conectar a PostgreSQL: " . pg_last_error());
}

// Establecer codificación UTF-8 (muy importante para acentos y caracteres latinos)
pg_set_client_encoding($conexion, "UTF8");

// Opcional: comentar si usas en producción, útil para debug
// echo "✔ Conectado correctamente a PostgreSQL";
?>

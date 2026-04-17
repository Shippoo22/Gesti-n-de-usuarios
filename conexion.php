<?php
$host = getenv("PGHOST");
$port = getenv("PGPORT");
$db   = getenv("PGDATABASE");
$user = getenv("PGUSER");
$pass = getenv("PGPASSWORD");

$conexion = pg_connect("
    host=$host 
    port=$port 
    dbname=$db 
    user=$user 
    password=$pass
");

if (!$conexion) {
    die("❌ Error de conexión a PostgreSQL");
}
?>

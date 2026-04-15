<?php

$host = getenv("PGHOST");
$port = getenv("PGPORT");
$dbname = getenv("PGDATABASE");
$user = getenv("PGUSER");
$password = getenv("PGPASSWORD");

$conexion = pg_connect("
    host=$host 
    port=$port 
    dbname=$dbname 
    user=$user 
    password=$password
");

if (!$conexion) {
    die("❌ Error de conexión: " . pg_last_error());
}
?>
